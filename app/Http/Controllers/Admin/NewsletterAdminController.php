<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use Illuminate\Http\Request;

class NewsletterAdminController extends Controller
{
    public function index()
    {
        $subscribers = Newsletter::latest()->get();
        return view('admin.newsletters.index', compact('subscribers'));
    }
}
