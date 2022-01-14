<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;



class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // get all data from menu.json file
       //  $verticalMenuJson = file_get_contents(base_path('resources/data/menu-data/verticalMenu.json'));
       // $verticalMenuData = json_decode($verticalMenuJson);
        $horizontalMenuJson = file_get_contents(base_path('resources/data/menu-data/horizontalMenu.json'));
        $horizontalMenuData = json_decode($horizontalMenuJson);

        //echo $verticalMenuJson;
        
        $v_menu_array = array();

         $v_menu_array[] = (object) array("name"=> "Agents","icon"=> "user","slug"=> "","permission"=>"agent.details.list","submenu"=> array((object) array("url"=> "agent/agentdetails","name"=> "Details","icon"=> "circle","slug"=> "agentdetails","permission"=>"agent.details.list"),(object) array("url"=> "agent/statement","name"=> "Statement","icon"=> "circle","slug"=> "statement","permission"=>"agent.statement.list"),(object) array("url"=> "agent/settlement","name"=> "Settlement","icon"=> "circle","slug"=> "settlement","permission"=>"agent.settlement.list")));

          $v_menu_array[] = (object) array("name"=> "Members","icon"=> "user","slug"=> "","permission"=>"member.details.list","submenu"=> array((object) array("url"=> "member/details","name"=> "Details","icon"=> "circle","slug"=> "details","permission"=>"member.details.list"),(object) array("url"=> "member/winloss","name"=> "Win Loss","icon"=> "circle","slug"=> "winloss","permission"=>"member.winloss.list"),(object) array("url"=> "member/adjust_credit","name"=> "Adjust Credit","icon"=> "circle","slug"=> "adjust_credit","permission"=>"member.adjust_credit.list")));

       $v_menu_array[] = (object) array("url"=> "deposit","name"=> "Deposit","icon"=> "copy","slug"=> "deposit","permission"=>"deposit.list");

       $v_menu_array[] = (object) array("url"=> "withdrawal","name"=> "Withdrawals","icon"=> "copy","slug"=> "withdrawal","permission"=>"withdrawal.list");

       $v_menu_array[] = (object) array("url"=> "transaction","name"=> "Transactions","icon"=> "copy","slug"=> "transaction","permission"=>"transaction.list");

         $v_menu_array[] = (object) array("name"=> "Statements","icon"=> "copy","slug"=> "","permission"=>"statement.companywinloss.list","submenu"=> array((object) array("url"=> "statement/companywinloss","name"=> "Company WinLoss","icon"=> "circle","slug"=> "statementcompanywinloss","permission"=>"statement.companywinloss.list")));

          $v_menu_array[] = (object) array("url"=> "megajackpots","name"=> "Mega Jackpots","icon"=> "copy","slug"=> "megajackpots","permission"=>"megajackpot.list");

           $v_menu_array[] = (object) array("url"=> "pool","name"=> "Pools","icon"=> "copy","slug"=> "pool","permission"=>"pool.list");

           $v_menu_array[] = (object) array("url"=> "match","name"=> "Matches","icon"=> "copy","slug"=> "match","permission"=>"match.list");

           $v_menu_array[] = (object) array("url"=> "announcement","name"=> "Announcements","icon"=> "file","slug"=> "announcement","permission"=>"announcement.list");

           $v_menu_array[] = (object) array("url"=> "notification","name"=> "Notifications","icon"=> "file","slug"=> "notification","permission"=>"notification.list");



        $v_menu_array[] = (object) array("url"=> "users","name"=> "User","icon"=> "users","slug"=> "users","permission"=>"user.list");
       



        /*

       
        $v_menu_array[] = (object) array("url"=> "games","name"=> "Game","icon"=> "circle","slug"=> "games","permission"=>"game.list");
        $v_menu_array[] = (object) array("name"=> "Commission","icon"=> "circle","slug"=> "","permission"=>"commission.direct","submenu"=> array((object) array("url"=> "commission/direct","name"=> "Direct","icon"=> "circle","slug"=> "direct","permission"=>"commission.direct"),(object) array("url"=> "commission/indirect","name"=> "Indirect","icon"=> "circle","slug"=> "indirect","permission"=>"commission.indirect")));
        
    */




         $v_menu_array[] = (object) array("name"=> "Settings","icon"=> "circle","slug"=> "","permission"=>"settings.company","submenu"=> array((object) array("url"=> "settings/company","name"=> "Company","icon"=> "circle","slug"=> "company","permission"=>"settings.company")));


        $v_obj = (object) array('menu' => $v_menu_array);
        $verticalMenuData = $v_obj;



         // Share all menuData to all the views
        \View::share('menuData',[$verticalMenuData, $horizontalMenuData]);
    }
}
