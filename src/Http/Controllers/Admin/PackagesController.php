<?php
namespace NexaMerchant\Apps\Http\Controllers\Admin;

use Illuminate\Http\Request;

class PackagesController extends Controller
{
    public function index(Request $request)
    {
        return view('apps::admin.packages.index');
    }
}