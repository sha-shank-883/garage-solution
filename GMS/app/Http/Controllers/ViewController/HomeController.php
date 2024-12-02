<?php
namespace App\Http\Controllers\ViewController;

use App\Http\Controllers\Controller;
use App\Service;
use App\AboutUs; // Correct import of the Service model
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Fetch all services
        // $services = Service::where('status', 1)->get();
        $services = \DB::table('services')->where('status', 1)->get();
        $aboutUs = AboutUs::first();

        // Pass services to the home view
        return view('view.home', compact('services', 'aboutUs'));
    }

    public function AboutUs()
    {
        $aboutUs = AboutUs::first(); // Fetch the first record
        return view('view.about', compact('aboutUs'));
    }

}





