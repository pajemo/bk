<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AdminContent;
use App\Models\Content;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Fetch counts for dashboard statistics
        $totalUsers = User::count();
        $totalSuperAdmins = User::where('role', 'super_admin')->count();
        $totalContents = Content::count();

        // Fetch paginated contents and admin contents for the dashboard view
        $contents = Content::orderBy('created_at', 'desc')->paginate(10);
        $adminContents = AdminContent::orderBy('created_at', 'desc')->paginate(10);

        // Return the admin dashboard view with data
        return view('admin.dashboard', compact('totalUsers', 'totalSuperAdmins', 'totalContents', 'contents', 'adminContents'));
    }

    // Add the missing adminContents method to handle the admin contents index route
    public function adminContents()
    {
        $adminContents = AdminContent::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.contents.index', compact('adminContents'));
    }

    // Add createAdminContent method to handle the create admin content route
    public function createAdminContent()
    {
        return view('admin.contents.create');
    }
}
