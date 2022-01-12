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
        $verticalMenuJson = file_get_contents(base_path('resources/data/menu-data/verticalMenu.json'));
        $verticalMenuData = json_decode($verticalMenuJson);
        $horizontalMenuJson = file_get_contents(base_path('resources/data/menu-data/horizontalMenu.json'));
        $horizontalMenuData = json_decode($horizontalMenuJson);

        //echo $verticalMenuJson;
        
        $v_menu_array = array();
        //$v_menu_array[] = (object) array("url"=> "dashboard","name"=> "Dashboards","icon"=> "home","slug"=> "");
        $v_menu_array[] = (object) array("url"=> "users","name"=> "User","icon"=> "users","slug"=> "users","permission"=>"user.list");
        $v_menu_array[] = (object) array("url"=> "games","name"=> "Game","icon"=> "circle","slug"=> "games","permission"=>"game.list");
        $v_menu_array[] = (object) array("name"=> "Commission","icon"=> "circle","slug"=> "","permission"=>"commission.direct","submenu"=> array((object) array("url"=> "commission/direct","name"=> "Direct","icon"=> "circle","slug"=> "direct","permission"=>"commission.direct"),(object) array("url"=> "commission/indirect","name"=> "Indirect","icon"=> "circle","slug"=> "indirect","permission"=>"commission.indirect")));

         $v_menu_array[] = (object) array("name"=> "Settings","icon"=> "circle","slug"=> "","permission"=>"settings.company","submenu"=> array((object) array("url"=> "settings/company","name"=> "Company","icon"=> "circle","slug"=> "company","permission"=>"settings.company")));


        $v_obj = (object) array('menu' => $v_menu_array);
        $verticalMenuData = $v_obj;


        //dd($v_obj);

         // Share all menuData to all the views
        \View::share('menuData',[$verticalMenuData, $horizontalMenuData]);
    }
}
