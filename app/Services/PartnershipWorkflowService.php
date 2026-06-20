<?php

namespace App\Services;

use App\Models\Partnership;
use App\Models\PartnershipTimelineEvent;
use App\Models\User;

class PartnershipWorkflowService
{
    public function logStage(Partnership $partnership, string $stage, ?User $actor = null, ?string $description = null): void
    {
        PartnershipTimelineEvent::create([
            'partnership_id' => $partnership->id,
            'stage' => $stage,
            'title' => match ($stage) {
                'pending' => 'Pengajuan Dikirim',
                'rejected' => 'Ditolak',
                default => Partnership::WORKFLOW_STAGES[$stage] ?? ucfirst($stage),
            },
            'description' => $description,
            'created_by' => $actor?->id,
        ]);
    }

    public function advanceStage(Partnership $partnership, User $actor): void
    {
        $order = Partnership::WORKFLOW_ORDER;
        $current = $partnership->workflow_stage ?? 'negotiation';
        $index = array_search($current, $order, true);

        if ($index === false || $index >= count($order) - 1) {
            return;
        }

        $next = $order[$index + 1];
        $partnership->workflow_stage = $next;

        if ($next === 'completed') {
            $partnership->status = 'completed';
            $partnership->completed_at = now();
        }

        $partnership->save();
        $this->logStage($partnership, $next, $actor);
    }

    public function startActivePartnership(Partnership $partnership, User $actor): void
    {
        $partnership->update([
            'status' => 'active',
            'workflow_stage' => 'negotiation',
        ]);

        $this->logStage($partnership, 'negotiation', $actor, 'Kerja sama disetujui, memulai negosiasi.');
    }
}
