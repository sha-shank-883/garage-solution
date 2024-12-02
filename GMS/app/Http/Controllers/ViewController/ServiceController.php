<?php
namespace App\Http\Controllers\ViewController;

use App\Http\Controllers\Controller;
use App\Service; // Correct import of the Service model
use Illuminate\Http\Request;

class ServiceController extends Controller
{

    public function services()
    {
        $services = \DB::table('services')->where('status', 1)->get();
        // dd($services);

        return view('view.service', compact('services'));
    }

    public function show($id)
    {

        $service = \DB::table('services')->where('id', $id)->first();
        return view('view.serviceDetails', compact('service'));
    }

}





