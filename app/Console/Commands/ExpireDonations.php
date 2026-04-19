<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\DonationItem;

class ExpireDonations extends Command
{
    protected $signature = 'donations:expire';

    protected $description = 'Check and update expired perishable donation items';

    public function handle()
    {
        $expiredCount = DonationItem::where('status', 'Available')
            ->whereNotNull('expires_at')
            ->where('expires_at', '<', now())
            ->update(['status' => 'Expired']);

        $this->info("Successfully expired {$expiredCount} items.");
    }
}