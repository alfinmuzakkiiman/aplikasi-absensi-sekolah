<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ClassSession;
use Carbon\Carbon;

class EndExpiredSessions extends Command
{
    protected $signature = 'sessions:end-expired';
    protected $description = 'Akhiri sesi pelajaran yang sudah lewat jam';

    public function handle()
    {
        $now = Carbon::now();

        $ended = ClassSession::where('active', true)
            ->where('ends_at', '<=', $now)
            ->update([
                'active'  => false,
                'ends_at' => $now
            ]);

        $this->info("✅ {$ended} sesi diakhiri otomatis");
    }
}
