<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageCategoriesController extends Controller
{
    public function getCategories()
    {
        return view('frontend.pages.category');
    }
}
