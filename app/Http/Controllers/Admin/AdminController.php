<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;

class AdminController extends CrudController
{
    public function dashboard()
    {
        // Get the number of users
        $userCount = User::count();

        // Pass the user count to the view
        return view(backpack_view('dashboard'), compact('userCount'));
    }
}
