<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TyresProduct; // Assuming you have a model for the table

class TyresController extends Controller
{
    public function search(Request $request)
    {
        $query = TyresProduct::query();

        // Filter by SKU
        if ($request->has('sku') && $request->sku != '') {
            $query->where('sku', 'like', '%' . $request->sku . '%');
        }

        // Filter by Brand
        if ($request->has('brand') && $request->brand != '') {
            $query->where('manufacturer_id', $request->brand);
        }

        // Filter by Price Range
        if ($request->has('price_min') && $request->price_min != '') {
            $query->where('price', '>=', $request->price_min);
        }
        if ($request->has('price_max') && $request->price_max != '') {
            $query->where('price', '<=', $request->price_max);
        }

        // New Filters for Width, Profile, Diameter
        if ($request->has('width') && $request->width != '') {
            $query->where('tyre_width', 'like', '%' . $request->width . '%');
        }
        if ($request->has('profile') && $request->profile != '') {
            $query->where('tyre_profile', 'like', '%' . $request->profile . '%');
        }
        if ($request->has('diameter') && $request->diameter != '') {
            $query->where('tyre_diameter', 'like', '%' . $request->diameter . '%');
        }

        // Get filtered tyres
        $tyres = $query->paginate(10);  // You can adjust pagination as needed

        return view('AutoCare.tyres.search', compact('tyres'));
    }
    public function edit($product_id)
    {
        $tyre = TyresProduct::where('product_id', $product_id)->firstOrFail(); // Fetch tyre by product_id
        return view('AutoCare.tyres.edit', compact('tyre'));
    }
    public function update(Request $request, $product_id)
    {
        $request->validate([
            'sku' => 'required',
            'price' => 'required',
            'model' => 'required',
            'tyre_width' => 'required',
            'tyre_profile' => 'required',
            'tyre_diameter' => 'required',
            // Add any other validation rules here
        ]);

        $tyre = TyresProduct::where('product_id', $product_id)->firstOrFail();
        $tyre->update($request->all()); // Update tyre with new data

        return redirect()->route('AutoCare.tyres.search')->with('success', 'Tyre updated successfully!');
    }


    // Method to delete a tyre
    public function destroy($product_id)
    {
        $tyre = TyresProduct::where('product_id', $product_id)->firstOrFail();
        $tyre->delete(); // Delete tyre record

        return redirect()->route('AutoCare.tyres.search')->with('success', 'Tyre deleted successfully!');
    }


}
