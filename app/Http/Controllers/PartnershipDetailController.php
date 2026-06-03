<?php

namespace App\Http\Controllers;

use App\Models\Partnership;
use App\Models\PartnershipDocument;
use App\Models\PartnershipTransaction;
use App\Services\PartnershipWorkflowService;
use App\Services\PremiumAccessService;
use App\Services\TrustedPetaniEligibilityService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PartnershipDetailController extends Controller
{
    public function __construct(
        private readonly PartnershipWorkflowService $workflow,
        private readonly PremiumAccessService $premiumAccess,
        private readonly TrustedPetaniEligibilityService $trustedPetani
    ) {}

    public function show(Request $request, Partnership $partnership): View
    {
        $this->authorizeParticipant($request, $partnership);

        $partnership->load([
            'product.category',
            'petani',
            'eksportir',
            'timelineEvents.author',
            'transactions',
            'documents.uploader',
        ]);

        return view('partnerships.show', [
            'partnership' => $partnership,
            'canViewExporterContact' => $this->premiumAccess->canViewExporterContact($request->user()),
            'workflowStages' => Partnership::WORKFLOW_STAGES,
            'workflowOrder' => Partnership::WORKFLOW_ORDER,
            'documentTypes' => PartnershipDocument::TYPES,
        ]);
    }

    public function advanceStage(Request $request, Partnership $partnership): RedirectResponse
    {
        abort_unless($request->user()->role === 'petani', 403);
        $this->authorizeParticipant($request, $partnership);
        abort_unless($partnership->status === 'active', 422);

        $this->workflow->advanceStage($partnership, $request->user());

        return back()->with('success', 'Tahap kerja sama diperbarui.');
    }

    public function storeTransaction(Request $request, Partnership $partnership): RedirectResponse
    {
        $this->authorizeParticipant($request, $partnership);
        abort_unless(in_array($partnership->status, ['active', 'completed'], true), 422);

        $validated = $request->validate([
            'quantity_kg' => ['required', 'integer', 'min:1'],
            'transaction_date' => ['required', 'date'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $partnership->transactions()->create($validated);

        return back()->with('success', 'Log transaksi ditambahkan.');
    }

    public function storeDocument(Request $request, Partnership $partnership): RedirectResponse
    {
        $this->authorizeParticipant($request, $partnership);

        $validated = $request->validate([
            'type' => ['required', 'in:'.implode(',', array_keys(PartnershipDocument::TYPES))],
            'document' => ['required', 'file', 'mimes:pdf', 'max:5120'],
        ]);

        $path = $request->file('document')->store('partnership-documents', 'public');

        $partnership->documents()->create([
            'type' => $validated['type'],
            'file_path' => $path,
            'original_name' => $request->file('document')->getClientOriginalName(),
            'uploaded_by' => $request->user()->id,
        ]);

        if ($validated['type'] === 'kontrak' && ! $partnership->file_kontrak) {
            $partnership->update(['file_kontrak' => $path]);
        }

        return back()->with('success', 'Dokumen berhasil diunggah.');
    }

    public function downloadDocument(Request $request, Partnership $partnership, PartnershipDocument $document)
    {
        $this->authorizeParticipant($request, $partnership);
        abort_unless($document->partnership_id === $partnership->id, 404);

        return Storage::disk('public')->download($document->file_path, $document->original_name);
    }

    public function storeReview(Request $request, Partnership $partnership): RedirectResponse
    {
        abort_unless($request->user()->role === 'eksportir', 403);
        abort_unless($partnership->eksportir_id === $request->user()->id, 403);
        abort_unless($partnership->status === 'completed', 422);
        abort_if($partnership->rating, 422, 'Partnership sudah dinilai.');

        $validated = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'review' => ['nullable', 'string', 'max:1000'],
        ]);

        $partnership->update([
            'rating' => $validated['rating'],
            'review' => $validated['review'] ?? null,
            'rated_at' => now(),
        ]);

        $this->trustedPetani->evaluate($partnership->petani);

        return back()->with('success', 'Rating dan testimoni berhasil dikirim.');
    }

    public function updateContract(Request $request, Partnership $partnership): RedirectResponse
    {
        abort_unless($request->user()->role === 'petani', 403);
        $this->authorizeParticipant($request, $partnership);

        $validated = $request->validate([
            'total_nilai_kontrak' => ['nullable', 'numeric', 'min:0'],
        ]);

        $partnership->update($validated);

        return back()->with('success', 'Nilai kontrak diperbarui.');
    }

    private function authorizeParticipant(Request $request, Partnership $partnership): void
    {
        abort_unless($partnership->isParticipant($request->user()), 403);
    }
}
