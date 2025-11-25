<?php

namespace App\Console\Commands;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CompleteShippedOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:complete-shipped';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically mark shipped orders as completed after 9 days';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get orders that have been shipped for more than 9 days
        $cutoffDate = Carbon::now()->subDays(9);

        $orders = Order::where('status', 'shipped')
            ->where('shipped_at', '<=', $cutoffDate)
            ->get();

        $count = 0;

        foreach ($orders as $order) {
            $order->update(['status' => 'completed']);
            $count++;

            Log::info('Order auto-completed after 9 days', [
                'order_number' => $order->order_number,
                'order_id' => $order->id,
                'shipped_at' => $order->shipped_at,
            ]);
        }

        $this->info("Successfully marked {$count} orders as completed.");

        Log::info('Orders auto-completion job completed', ['orders_completed' => $count]);

        return Command::SUCCESS;
    }
}
