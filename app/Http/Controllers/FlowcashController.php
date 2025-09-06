<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Flowcash;
use App\Models\User;
use Illuminate\Http\Request;

class FlowcashController extends Controller
{
    public function index() {
        $flowcash = Flowcash::paginate(20);
        $categories = Category::all();
        $users = User::all();
        return view("main-view.flowcash", compact('flowcash', 'categories', 'users'));
    }
}
