<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Team;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\CustomPermissionController;
use Illuminate\Http\Request;
use Auth;

class AppsController extends Controller
{
    // invoice list App
    public function invoice_list()
    {
        $pageConfigs = ['pageHeader' => false];

        return view('/content/apps/invoice/app-invoice-list', ['pageConfigs' => $pageConfigs]);
    }

    // invoice preview App
    public function invoice_preview()
    {
        $pageConfigs = ['pageHeader' => false];

        return view('/content/apps/invoice/app-invoice-preview', ['pageConfigs' => $pageConfigs]);
    }

    // invoice edit App
    public function invoice_edit()
    {
        $pageConfigs = ['pageHeader' => false];

        return view('/content/apps/invoice/app-invoice-edit', ['pageConfigs' => $pageConfigs]);
    }

    // invoice edit App
    public function invoice_add()
    {
        $pageConfigs = ['pageHeader' => false];

        return view('/content/apps/invoice/app-invoice-add', ['pageConfigs' => $pageConfigs]);
    }

    // invoice print App
    public function invoice_print()
    {
        $pageConfigs = ['pageHeader' => false];

        return view('/content/apps/invoice/app-invoice-print', ['pageConfigs' => $pageConfigs]);
    }

    // User List Page
    public function user_list()
    {
         $custom_permission_controller = new CustomPermissionController; 
        
        $custom_get_all_permissions_access = $custom_permission_controller->custom_get_all_permissions();

        $pageConfigs = ['pageHeader' => false];
         $current_user_id = Auth::id();
        return view('/content/apps/user/app-user-list', ['pageConfigs' => $pageConfigs,'current_user_id'=>$current_user_id,'custom_get_all_permissions_access'=>$custom_get_all_permissions_access]);
    }

    // User Account Page
    public function user_view_account()
    {
        $pageConfigs = ['pageHeader' => false];
        return view('/content/apps/user/app-user-view-account', ['pageConfigs' => $pageConfigs]);
    }

    // User Security Page
    public function user_view_security()
    {
        $pageConfigs = ['pageHeader' => false];
        return view('/content/apps/user/app-user-view-security', ['pageConfigs' => $pageConfigs]);
    }

    // User Billing and Plans Page
    public function user_view_billing()
    {
        $pageConfigs = ['pageHeader' => false];
        return view('/content/apps/user/app-user-view-billing', ['pageConfigs' => $pageConfigs]);
    }

    // User Notification Page
    public function user_view_notifications()
    {
        $pageConfigs = ['pageHeader' => false];
        return view('/content/apps/user/app-user-view-notifications', ['pageConfigs' => $pageConfigs]);
    }

    // User Connections Page
    public function user_view_connections()
    {
        $pageConfigs = ['pageHeader' => false];
        return view('/content/apps/user/app-user-view-connections', ['pageConfigs' => $pageConfigs]);
    }


    // Chat App
    public function chatApp()
    {
        $pageConfigs = [
            'pageHeader' => false,
            'contentLayout' => "content-left-sidebar",
            'pageClass' => 'chat-application',
        ];

        return view('/content/apps/chat/app-chat', [
            'pageConfigs' => $pageConfigs
        ]);
    }

    // Calender App
    public function calendarApp()
    {
        $pageConfigs = [
            'pageHeader' => false
        ];

        return view('/content/apps/calendar/app-calendar', [
            'pageConfigs' => $pageConfigs
        ]);
    }

    // Email App
    public function emailApp()
    {
        $pageConfigs = [
            'pageHeader' => false,
            'contentLayout' => "content-left-sidebar",
            'pageClass' => 'email-application',
        ];

        return view('/content/apps/email/app-email', ['pageConfigs' => $pageConfigs]);
    }
    // ToDo App
    public function todoApp()
    {
        $pageConfigs = [
            'pageHeader' => false,
            'contentLayout' => "content-left-sidebar",
            'pageClass' => 'todo-application',
        ];

        return view('/content/apps/todo/app-todo', [
            'pageConfigs' => $pageConfigs
        ]);
    }
    // File manager App
    public function file_manager()
    {
        $pageConfigs = [
            'pageHeader' => false,
            'contentLayout' => "content-left-sidebar",
            'pageClass' => 'file-manager-application',
        ];

        return view('/content/apps/fileManager/app-file-manager', ['pageConfigs' => $pageConfigs]);
    }

    // Access Roles App
    public function access_roles()
    {
        $pageConfigs = ['pageHeader' => false,];

        return view('/content/apps/rolesPermission/app-access-roles', ['pageConfigs' => $pageConfigs]);
    }

    // Access permission App
    public function access_permission()
    {
        $pageConfigs = ['pageHeader' => false,];

        return view('/content/apps/rolesPermission/app-access-permission', ['pageConfigs' => $pageConfigs]);
    }

    // Kanban App
    public function kanbanApp()
    {
        $pageConfigs = [
            'pageHeader' => false,
            'pageClass' => 'kanban-application',
        ];

        return view('/content/apps/kanban/app-kanban', ['pageConfigs' => $pageConfigs]);
    }

    // Ecommerce Shop
    public function ecommerce_shop()
    {
        $pageConfigs = [
            'contentLayout' => "content-detached-left-sidebar",
            'pageClass' => 'ecommerce-application',
        ];

        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"], ['link' => "javascript:void(0)", 'name' => "eCommerce"], ['name' => "Shop"]
        ];

        return view('/content/apps/ecommerce/app-ecommerce-shop', [
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    // Ecommerce Details
    public function ecommerce_details()
    {
        $pageConfigs = [
            'pageClass' => 'ecommerce-application',
        ];

        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"], ['link' => "javascript:void(0)", 'name' => "eCommerce"], ['link' => "/app/ecommerce/shop", 'name' => "Shop"], ['name' => "Details"]
        ];

        return view('/content/apps/ecommerce/app-ecommerce-details', [
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    // Ecommerce Wish List
    public function ecommerce_wishlist()
    {
        $pageConfigs = [
            'pageClass' => 'ecommerce-application',
        ];

        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"], ['link' => "javascript:void(0)", 'name' => "eCommerce"], ['name' => "Wish List"]
        ];

        return view('/content/apps/ecommerce/app-ecommerce-wishlist', [
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    // Ecommerce Checkout
    public function ecommerce_checkout()
    {
        $pageConfigs = [
            'pageClass' => 'ecommerce-application',
        ];

        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"], ['link' => "javascript:void(0)", 'name' => "eCommerce"], ['name' => "Checkout"]
        ];

        return view('/content/apps/ecommerce/app-ecommerce-checkout', [
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs
        ]);
    }
}
