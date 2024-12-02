<?php

namespace App\Http\Controllers\ViewController;

use App\Http\Controllers\Controller; // Import the base Controller class
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function home()
    {
        $data = [
            'title' => 'Home',
            'content' => 'Welcome to our Garage Management System!',
        ];
        // Reference the view in the 'view' folder
        return view('view.home', compact('data'));
    }
    // public function aboutUs()
    // {
    //     return view('about');
    // }

    public function contact()
    {
        return view('contact');
    }

    public function services()
    {
        return view('services');
    }

    public function tyres()
    {
        return view('tyres');
    }
}

