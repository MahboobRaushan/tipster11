<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use DB;
use App\Models\Pool;
use Carbon\Carbon;

class PullRunning extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pool:running';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pull Running on every Minutes to Check';

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
        //return 0;
        /*
        DB::table('testing')->insert(
            ['name' => '1', 'email' => 'w','description'=>date('Y-m-d H:i:s')]
        );
        */
        $current_date_time = Carbon::now()->toDateTimeString();
        $currentTime = strtotime($current_date_time);
        $pools = DB::table('pools')->whereIn('status',['Inactive','Active'])->get();

        foreach($pools as $pool)
        {
            $startT = $pool->startTime;
            $startTime = strtotime($startT);
            $endT = $pool->endTime;
            $endTime = strtotime($endT);
            $id = $pool->id;
            $status = $pool->status;
            if($currentTime < $startTime)
            {
                //status = 0 inactive
                if($status!='Inactive')
                {                  
                    DB::table('pools')
                    ->where('id', $id)
                    ->update(['status' => 'Inactive']);

                }
            }
            if(($currentTime > $startTime) && ($currentTime < $endTime))
            {
                 //status = 1 active
                if($status!='Active')
                {
                     DB::table('pools')
                    ->where('id', $id)
                    ->update(['status' => 'Active']);
                }
            }
            if($currentTime > $endTime){
                $matchscount = DB::table('pool_match')
                ->leftJoin('match', 'match.id', '=', 'pool_match.match_id')
                ->select('match.result')
                ->whereNull('match.result')
                ->where('match.status','!=','Void')                 
                ->where('pool_match.pool_id',$id)               
                ->count();
                if($matchscount > 0)
                {
                    //status = 0 inactive
                    if($status!='Inactive')
                    {
                         DB::table('pools')
                        ->where('id', $id)
                        ->update(['status' => 'Inactive']);
                    }
                }
                else 
                {
                    //status = 2 finished
                    if($status!='Finished')
                    {
                         DB::table('pools')
                        ->where('id', $id)
                        ->update(['status' => 'Finished']);
                    }
                }

            }
        }

         $this->info('Pool Running Schedule Task on Every Minutes '.date('Y-m-d H:i:s'));
    }
}
