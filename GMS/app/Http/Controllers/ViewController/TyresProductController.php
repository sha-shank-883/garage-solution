<?php

namespace App\Http\Controllers\ViewController;
use App\TyresProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TyresProductController extends Controller
{
    // public function tyreslist()
    // {
    //     // $tyres = TyresProduct::all(); // Fetching all tyres from the database
    //     $tyres = \DB::table('tyres_product')->where('status', 1)->get();
    //     return view('view.tyreslist', compact('tyres')); // Passing data to the view
    // }
    public function tyreslist(Request $request)
    {
        // Fetch all brands dynamically (replace with actual brand logic)
        $brands = [
            1 => 'Brand 1',
            2 => 'Brand 2',
            3 => 'Brand 3',
        ];

        // Fetch distinct widths, profiles, and diameters for the filter dropdowns
        $widths = TyresProduct::select('tyre_width')->distinct()->pluck('tyre_width');
        $profiles = TyresProduct::select('tyre_profile')->distinct()->pluck('tyre_profile');
        $diameters = TyresProduct::select('tyre_diameter')->distinct()->pluck('tyre_diameter');
        $description = TyresProduct::select('description')->distinct()->pluck('description');

        // Build the query
        $query = TyresProduct::query();

        // Apply filters
        if ($request->filled('sku')) {
            $query->where('sku', 'like', '%' . $request->sku . '%');
        }
        if ($request->filled('ean')) {
            $query->where('ean', 'like', '%' . $request->sku . '%');
        }

        if ($request->filled('brand')) {
            $query->where('manufacturer_id', $request->brand);
        }

        if ($request->filled('width')) {
            $query->where('tyre_width', $request->width);
        }

        if ($request->filled('profile')) {
            $query->where('tyre_profile', $request->profile);
        }

        if ($request->filled('diameter')) {
            $query->where('tyre_diameter', $request->diameter);
        }

        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }

        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }

        // Get paginated results
        $tyres = $query->paginate(9); // 9 items per page

        // Pass data to the view
        return view('view.tyreslist', compact('tyres', 'brands', 'description', 'widths', 'profiles', 'diameters'));
    }
    public function getProfiles(Request $request)
    {
        $profiles = TyresProduct::where('tyre_width', $request->width)
            ->select('tyre_profile')
            ->distinct()
            ->pluck('tyre_profile');

        $options = '<option value="">Select Profile</option>';
        foreach ($profiles as $profile) {
            $options .= "<option value=\"$profile\">$profile</option>";
        }

        return $options;
    }

    // Fetch Diameters Based on Width and Profile
    public function getDiameters(Request $request)
    {
        $diameters = TyresProduct::where('tyre_width', $request->width)
            ->where('tyre_profile', $request->profile)
            ->select('tyre_diameter')
            ->distinct()
            ->pluck('tyre_diameter');

        $options = '<option value="">Select Diameter</option>';
        foreach ($diameters as $diameter) {
            $options .= "<option value=\"$diameter\">$diameter</option>";
        }

        return $options;
    }

    // Filter Tyres Based on Selection
    public function filter(Request $request)
    {
        $query = TyresProduct::query();

        if ($request->filled('width')) {
            $query->where('tyre_width', $request->width);
        }
        if ($request->filled('profile')) {
            $query->where('tyre_profile', $request->profile);
        }
        if ($request->filled('diameter')) {
            $query->where('tyre_diameter', $request->diameter);
        }

        \DB::enableQueryLog();
        $tyres = $query->paginate(9);
        \Log::info(\DB::getQueryLog());

        if ($tyres->isEmpty()) {
            return response()->json([
                'tyres' => '<p>No tyres found matching the criteria.</p>',
                'pagination' => ''
            ]);
        }

        try {
            $tyresHtml = view('view.tyre-cards', compact('tyres'))->render();
            $paginationHtml = $tyres->links();
        } catch (\Exception $e) {
            \Log::error('View Rendering Error: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to render view'], 500);
        }

        return response()->json([
            'tyres' => $tyresHtml,
            'pagination' => $paginationHtml
        ]);
    }

}

