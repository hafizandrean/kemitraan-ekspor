<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Display a listing of the conversations.
     */
    public function index()
    {
        $user = Auth::user();
        
        $conversations = Conversation::where('farmer_id', $user->id)
            ->orWhere('exporter_id', $user->id)
            ->latestActive()
            ->get();

        return view('chat.index', compact('conversations'));
    }

    /**
     * Display the specified conversation.
     */
    public function show(Conversation $conversation)
    {
        $user = Auth::user();

        // Security check: User must be part of the conversation
        if ($conversation->farmer_id !== $user->id && $conversation->exporter_id !== $user->id) {
            abort(403, 'Anda tidak diizinkan mengakses percakapan ini.');
        }

        // Mark messages from the opponent as read
        $conversation->messages()
            ->where('sender_id', '!=', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $conversations = Conversation::where('farmer_id', $user->id)
            ->orWhere('exporter_id', $user->id)
            ->latestActive()
            ->get();

        $messages = $conversation->messages()->oldest()->get();

        return view('chat.index', compact('conversations', 'conversation', 'messages'));
    }

    /**
     * Store a newly created message.
     */
    public function store(Request $request, Conversation $conversation)
    {
        $user = Auth::user();

        // Security check
        if ($conversation->farmer_id !== $user->id && $conversation->exporter_id !== $user->id) {
            abort(403);
        }

        // Check if user is suspended (fallback just in case)
        if ($user->isSuspended()) {
            abort(403, 'Akun Anda sedang ditangguhkan.');
        }

        $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        // Create the message
        $message = $conversation->messages()->create([
            'sender_id' => $user->id,
            'message' => $request->message,
            'is_read' => false,
        ]);

        // Update conversation activity timestamp
        $conversation->update([
            'last_message_at' => now(),
        ]);

        if ($request->expectsJson()) {
            return response()->json($message);
        }

        return redirect()->route('chat.show', $conversation);
    }

    /**
     * Start or find a conversation between Exporter and Farmer.
     */
    public function start(Request $request)
    {
        $exporter = Auth::user();
        
        if ($exporter->role !== 'eksportir') {
            abort(403, 'Hanya eksportir yang dapat memulai percakapan.');
        }

        $request->validate([
            'farmer_id' => 'required|exists:users,id',
            'product_id' => 'nullable|exists:products,id',
        ]);

        $farmerId = (int) $request->farmer_id;
        $productId = $request->product_id ? (int) $request->product_id : null;

        $farmer = User::findOrFail($farmerId);
        if ($farmer->role !== 'petani') {
            abort(400, 'Pengguna yang dituju bukan Petani.');
        }

        // Find existing conversation with exact same farmer, exporter and product context
        $conversation = Conversation::where('farmer_id', $farmerId)
            ->where('exporter_id', $exporter->id)
            ->where('product_id', $productId)
            ->first();

        if ($conversation) {
            return redirect()->route('chat.show', $conversation);
        }

        // Apply Premium Check: Exporter must be premium to start a chat
        if (!$exporter->isPremium()) {
            return redirect()->route('premium.index')->with('error', 'Upgrade ke Premium untuk memulai percakapan baru.');
        }

        // Create new conversation
        $conversation = Conversation::create([
            'farmer_id' => $farmerId,
            'exporter_id' => $exporter->id,
            'product_id' => $productId,
            'last_message_at' => now(),
            'status' => 'active',
        ]);

        // Send initial automated prompt if product context exists
        if ($productId) {
            $product = Product::find($productId);
            $conversation->messages()->create([
                'sender_id' => $exporter->id,
                'message' => "Halo Pak, saya tertarik dengan produk {$product->nama_produk} Anda.",
                'is_read' => false,
            ]);
        }

        return redirect()->route('chat.show', $conversation);
    }
}
