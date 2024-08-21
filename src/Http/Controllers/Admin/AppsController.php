<?php
namespace NexaMerchant\Apps\Http\Controllers\Admin;

use Illuminate\Http\Request;

class AppsController extends Controller
{
    public function demo(Request $request)
    {
        return view('apps::admin.example.demo');
    }
}