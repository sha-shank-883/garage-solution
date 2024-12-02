<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Supplier;
use DB;
use App\HeaderLink;

use Illuminate\Support\Facades\Validator;
// use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;


class SupplierController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');

	}
	public function save(Request $request, $id = null)
	{
		$viewData['pageTitle'] = 'Supplier Dretail';
		$viewData['pageTitle'] = 'Add Purchase Detail';
		$viewData['option1'] = 'Add Supplier';
		$viewData['optionValue1'] = "AutoCare/supplier/add";
		$viewData['option2'] = 'Add Product Detail';
		$viewData['optionValue2'] = "AutoCare/product/add";
		$viewData['header_link'] = HeaderLink::where("menu_id", '3')->select("link_title", "link_name")->orderBy('id', 'desc')->get();
		// This if condition for fill detail for update otherwise for save and update 
		if (isset($id) && $id != null) {
			$getFormAutoFillup = Supplier::whereId($id)->first()->toArray();
			return view('AutoCare.supplier.add', $viewData)->with($getFormAutoFillup);
		} else if ((!isset($id) && $id == null) && !$request->isMethod('post')) {
			return view('AutoCare.supplier.add', $viewData);
		} else {
			// This if condition for fill detail for  update otherwise for  save 
			if ($request->isMethod('post')) {
				$getFormAutoFillup = array();
				if (isset($request->id) && $request->id != null) {
					if ($request->isMethod('post')) {
						$supplierManame = request()->except(['_token']);
						if (Supplier::where([['id', '=', $request->id]])->update($supplierManame)) {
							$request->session()->flash('message.level', 'success');
							$request->session()->flash('message.content', 'Supplier updated Successfully!');
						}
					}
					return redirect('/AutoCare/supplier/add/' . $request->id);
				} else {
					$supplierManame = $request->all();
					//print_r($supplierManame);
					///exit;
					$supplierManame = new Supplier($supplierManame);

					if ($supplierManame->save()) {
						$request->session()->flash('message.level', 'success');
						$request->session()->flash('message.content', 'Supplier Saved Successfully!');
					}
					return view('AutoCare.supplier.add', $viewData);
				}
			}
		}
	}
	public function view(Request $request)
	{
		if ($request->isMethod('post')) {
			$viewData['pageTitle'] = 'Supplier';
			$viewData['header_link'] = HeaderLink::where("menu_id", '3')->select("link_title", "link_name")->orderBy('id', 'desc')->get();
			$Supplier = DB::table('suppliers');
			if ($request->has('id') && $request->id != '') {
				$Supplier->where('id', '=', $request->id);
			}
			if ($request->has('supplier_name') && $request->supplier_name != '') {
				$Supplier->where('supplier_name', 'like', '%' . $request->supplier_name . '%');
			}
			if ($request->has('created_at_from') && $request->created_at_from != '') {
				$Supplier->whereDate('created_at', '<=', $request->created_at_from);
			}
			if ($request->has('created_at_to') && $request->created_at_to != '') {
				$Supplier->whereDate('created_at', '>=', $request->created_at_to);
			}
			if ($request->has('mobile') && $request->mobile != '') {
				$Supplier->where('mobile', '=', $request->mobile);
			}
			if ($request->has('email') && $request->email != '') {
				$Supplier->where('email', '=', $request->email);
			}
			$Supplier->orderBy('id', 'desc');
			$Supplier = $Supplier->get();
			$viewData['supplier'] = json_decode(json_encode($Supplier), true);
			return view('AutoCare.supplier.search', $viewData);

		} else {
			$viewData['pageTitle'] = 'Supplier';
			$viewData['supplier'] = Supplier::orderBy('id', 'desc')->get();
			//	$Supplier= DB::table('Suppliers');
			//$Supplier->orderBy('id','desc');
			//$Supplier= $Supplier->get();
			//$viewData['Supplier']=json_decode(json_encode($Supplier), true);
			return view('AutoCare.supplier.search', $viewData);
		}

	}
	public function trash(Request $request, $id)
	{
		$viewData['header_link'] = HeaderLink::where("menu_id", '3')->select("link_title", "link_name")->orderBy('id', 'desc')->get();
		if (($id != null) && (Supplier::where('id', $id)->delete())) {
			$request->session()->flash('message.level', 'warning');
			$request->session()->flash('message.content', 'Supplier was Trashed!');
			$viewData['pageTitle'] = 'Supplier';
			$viewData['supplier'] = Supplier::paginate(10);
			return view('AutoCare.supplier.search', $viewData);
		} else {
			session()->flash('status', ['danger', 'Operation was Failed!']);
			$viewData['pageTitle'] = 'Supplier';
			$viewData['supplier'] = Supplier::paginate(10);
			return view('AutoCare.supplier.search', $viewData);
		}

	}
	public function trashedList()
	{
		$TrashedParty = Supplier::orderBy('deleted_at', 'desc')->onlyTrashed()->simplePaginate(10);
		// $TrashedParty=$TrashedParty
		return view('AutoCare.supplier.delete', compact('TrashedParty', 'TrashedParty'));
	}
	public function permanemetDelete(Request $request, $id)
	{
		$viewData['header_link'] = HeaderLink::where("menu_id", '3')->select("link_title", "link_name")->orderBy('id', 'desc')->get();
		if (($id != null) && (Supplier::where('id', $id)->forceDelete())) {
			$request->session()->flash('message.level', 'warning');
			$request->session()->flash('message.content', "Supplier was deleted Permanently and Can't rollback in Future!");
		} else {
			session()->flash('status', ['danger', 'Operation was Failed!']);
		}

		$TrashedParty = Supplier::orderBy('deleted_at', 'desc')->onlyTrashed()->simplePaginate(10);
		return view('AutoCare.supplier.delete', compact('TrashedParty', 'TrashedParty'));
	}




	public function importTyres(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'csv_file' => 'required|file|mimes:csv,txt|max:22048',
		]);

		if ($validator->fails()) {
			return redirect()->back()->withErrors($validator)->withInput();
		}

		$file = $request->file('csv_file');
		$data = array_map('str_getcsv', file($file->getRealPath()));

		$header = array_shift($data);
		$rows = $data;
		$insertData = [];
		foreach ($rows as $row) {
			$row = array_combine($header, $row);

			$insertData[] = [
				'sku' => $row['SKU'] ?? null,
				'ean' => $row['EAN'] ?? null,
				'quantity' => $row['STOCKBAL'] ?? null,
				'price' => $row['COST_PRICE'] ?? null,
				'price_fullyfitted' => $row['PRICE_FULLYFITTED'] ?? null,
				'price_type' => $row['PRICE_FULLYFITTED'] ?? 0,
				'offerprice' => $row['offerprice'] ?? 0,
				'tax_class_id' => $row['tax_class_id'] ?? 9,
				'description' => $row['DESC'] ?? null,
				// 'name' => $row['BRAND'] ?? null,
				'model' => $row['PATTERN'] ?? null,
				'tyre_width' => $row['SECTION'] ?? null,
				'tyre_profile' => $row['PROFILE'] ?? null,
				'tyre_diameter' => $row['RIM'] ?? null,
				'tyre_loadindex' => $row['LOAD_INDEX'] ?? null,
				'tyre_speed' => $row['SPEED'] ?? null,
				// 'xl' => $row['XL'] ?? null,
				// 'tyre_antiflat' => $row['RFT'] ?? null,
				'tyre_antiflat' => is_numeric($row['RFT']) ? $row['RFT'] : null,
				'name' => $row['SEASON'] ?? null,
				'tyre_eco' => $row['FUEL'] ?? null,
				'tyre_disfr' => $row['WET'] ?? null,
				'tyre_db' => $row['NOISE'] ?? null,
				'image' => $row['IMAGE'] ?? null,
				'stock_status_id' => $row['stock_status_id'] ?? 1,
				'manufacturer_id' => $row['manufacturer_id'] ?? 1,

				'service_category_id' => $row['service_category_id'] ?? 0,
				'supplier_id' => $row['supplier_id'] ?? 50,

				'date_available' => isset($row['DATE_AVAILABLE']) ? $row['DATE_AVAILABLE'] : now()->toDateString(),

				'date_added' => now(),
				'date_modified' => now(),
			];
		}

		if (!empty($insertData)) {
			DB::table('tyres_product')->insert($insertData);
			return redirect()->back()->with('message.level', 'success')->with('message.content', 'Tyres imported successfully!');
		}

		return redirect()->back()->with('message.level', 'danger')->with('message.content', 'No valid data found in the CSV file.');
	}


}
