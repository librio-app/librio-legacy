<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\CatalogController;
use App\Http\Controllers\Common\DashboardController;
use App\Http\Controllers\Opac\LendedController;
use App\Http\Controllers\Opac\OpacController;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Route;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        // No need to check for permission in console
        if (app()->runningInConsole()) {
            return;
        }

        $route = app(Route::class);

        // Get the controller array
        $uses = explode('@', $route->getAction()['uses'])[0];
        $arr = array_reverse(explode('\\', $uses));
        $controller = '';
        $controller .= strtolower($arr[1]) . '-';
        $controller .= str_replace('controller', '', strtolower($arr[0]));

        // Skip ACL TODO add controllers
        $skip = [
            DashboardController::class, // dashboard
            CatalogController::class, // API's

            // OPAC
            OpacController::class,
            LendedController::class
        ];
        if (in_array($uses, $skip)) {
            return;
        }

        // Add CRUD permission check
        $this->middleware('permission:create-' . $controller)->only(['create', 'store']);
        $this->middleware('permission:read-' . $controller)->only(['index', 'show', 'details', 'edit', 'search', 'download']);
        $this->middleware('permission:update-' . $controller)->only(['update', 'enable', 'disable', 'changeStatus', 'addBook']);
        $this->middleware('permission:delete-' . $controller)->only(['destroy', 'removeBook']);
    }
}
