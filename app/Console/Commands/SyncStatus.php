<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Visitation;

class SyncStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:SyncStatus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to sync transaction status';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $visitation = Visitation::where('status', 'Menunggu Konfirmasi')
            ->whereRaw('TIMESTAMPDIFF(SECOND, `created_at`, CURRENT_TIMESTAMP()) - (60 * 30) > 0')
            ->first();
        if ($visitation->count() > 0){
            Visitation::where('id', $visitation->id)
                ->update([
                    'status' => 'Ditolak'
                ]);
        }
        return Command::SUCCESS;
    }
}
