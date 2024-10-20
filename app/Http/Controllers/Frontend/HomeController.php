<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Tenant;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index(){
        $domain = request()->getHost();

        $tenant = Tenant::where('domain', $domain)->first();

        dd($domain, $tenant);

        return view('welcome');
    }
}
