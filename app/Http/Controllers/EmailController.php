<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class EmailController extends Controller
{
    public function index()
    {
        return inertia::render('Admin/EmailsAndNotifications', [


            ]);

    }
}
