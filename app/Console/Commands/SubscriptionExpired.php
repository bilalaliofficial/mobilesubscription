<?php

namespace App\Console\Commands;

use App\Subscription;
use Illuminate\Console\Command;

class SubscriptionExpired extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscription:expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checking subscription which expired but but not canceled';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Subscription::where([['expiry_date','<',date('Y-m-d H:i:s')],['subscription_status','!=','Canceled']])->update(['subscription_status'=>'Canceled']);
    }
}
