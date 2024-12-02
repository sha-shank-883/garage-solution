<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\CreditDebitDetail;
use DB;

class CreditDebitDetailController extends Controller
{
   	public function __construct()
    {
        $this->middleware('auth');
    }
    public function save(Request $request, $id=null, $view = null)
    {
        $getMarketingDetails = array();
        /* Field specifiic Validations */   
        if(isset($request->id) && $request->id != null){
            $validationRules = [
                'item' => 'required'
            ];
        }else{
            $validationRules = [
                'item' => 'required'
            ];
        }
        $validator = Validator::make($request->all(), $validationRules);
        if(isset($id) && $id != null ){
           $getMarketingDetails=CreditDebitDetail::whereId($id)->first()->toArray();
        }
        else if((!isset($id) && $id == null) && !$request->isMethod('post') )
        {
            $getMarketingDetails = array();
        }
        else {
            if ($request->isMethod('post')){
                if($validator->fails()){
                    return back()->withErrors($validator)->withInput();
                }else{
                    if(isset($request->id) && $request->id != null)
                    {                       
                            $marketingManage=request()->except(['_token']);
                            $marketingManage['user_id']=Auth::user()->id;
                            if(CreditDebitDetail::where([['id', '=', $request->id]])->update($marketingManage)){
                                $request->session()->flash('message.level', 'success');
                                $request->session()->flash('message.content', 'Marketing Data updated Successfully!');
                            }                  
                    }
                    else
                    {
                        $marketingManage=$request->all();
                        $marketingManage = new CreditDebitDetail($marketingManage);
                        $marketingManage['user_id']=Auth::user()->id;
                        if($marketingManage->save()){
                            $request->session()->flash('message.level', 'success');
                            $request->session()->flash('message.content', 'Marketing Data Saved Successfully!');
                        }                    
                    }
            }
        }
    }
// $result = DB::select($sql)->get();
// $resultArray = json_decode(json_encode($result), true);
// $result = $result->toArray();

        $customFields['basic'] = array(
            'separator_1' => array('type' => 'separator_start', 'label' => 'Marketing Credit Debit Log'),
            'item'=>array('type' => 'text', 'label'=>'Item Name',  'mandatory'=>true),
            'item_discription'=>array('type' => 'textarea', 'label'=>'Item Dscripton','style'=>'height:40px',  'mandatory'=>true),
            'is_credit'=>array('type' => 'checkbox', 'label'=>'Credit','mandatory'=>false),
            'Amount'=>array('type' => 'number', 'label'=>'Total Price','mandatory'=>false),  
            'separator_2' => array('type' => 'separator_end', 'label' => 'Marketing Detail Details'),   
        );
        if(isset($view) && $view == 'view'){ $data['field_disable'] = true; }else{
        $data['field_disable'] = false;
        }
        $viewData=['customFields' => $customFields, 'data' => $data, 'formButton' => isset($id) ? 'Update Details' : 'Save Marketing Details', 'pageTitle' => isset($id) && $id != '' ? 'Edit Employee':'Add Employee'];
        $viewData['formHeaderMessage']="Please fill up necessary fields";
        return view('AutoCare.credit-debit-log.add',$viewData )->with($getMarketingDetails);
    }
   // this is for search
    public function view(Request $request)
    {
    	$getFormAutoFillup = array();
    	if($request->isMethod('post'))
    	{
    		$viewData['pageTitle'] = 'Credit Debit Log';       	
			$market= DB::table('credit_debit_details');
            $market->leftJoin('users','users.id','=','markets.user_id');
            $market->leftJoin('user_details','user_details.users_id','=','markets.user_id');
            $market->where('markets.deleted_at','=',null);
			if($request->has('id') && $request->id !=''){
				$getFormAutoFillup['id']=$request->id;
				$market->where('markets.id', '=', $request->id);
			}
			if($request->has('user_name') && $request->user_name !=''){
				$getFormAutoFillup['user_name']=$request->user_name;
				$market->where('users.name', 'like', '%'.$request->user_name.'%');
			}
			if($request->has('created_at_from') && $request->created_at_from !=''){
				$getFormAutoFillup['created_at_from']=$request->created_at_from;
				$market->where('created_at', '>=', $request->created_at_from);
			}
			if($request->has('created_at_to') && $request->created_at_to !=''){
				$getFormAutoFillup['created_at_to']=$request->created_at_to;
				$market->where('created_at', '<', $request->created_at_to);
			}
			if($request->has('user_id') && $request->user_id !=''){
				$getFormAutoFillup['user_id']=$request->user_id;
				$market->where('users.id', 'like', '%'.$request->product_name.'%');
			}

			$market->select('markets.*','users.name as user_name','users.email as user_email');
			$market->orderBy('id','desc');
       		$market= $market->get();
			$viewData['market']=json_decode(json_encode($market), true);
		    return view('AutoCare.credit-debit-log.search', $viewData)->with($getFormAutoFillup);;

    	}else
    	{
    		$viewData['pageTitle'] = 'Credit Debit Log';       	
			$market= DB::table('credit_debit_details');
            $market->leftJoin('users','users.id','=','markets.user_id');
            $market->leftJoin('user_details','user_details.users_id','=','markets.user_id');
            $market->where('markets.deleted_at','=',null);
            $market->select('markets.*','users.name as user_name','users.email as user_email');
            $market->orderBy('id','desc');
            $market= $market->get();
            $viewData['market']=json_decode(json_encode($market), true);
            // $viewData['purchase'] = $market;
		//	$market= DB::table('purchases');
			//$market->orderBy('id','desc');
       		//$market= $market->get();
			//$viewData['purchase']=json_decode(json_encode($market), true);
            //Ashu@97047$&(!   ca7zaoly6g7y
		    return view('AutoCare.credit-debit-log.search', $viewData);
    	}
      
    }
    public function trash(Request $request,$id)
    {
    	if(($id!=null) && (CreditDebitDetail::where('id',$id)->delete())){
            $request->session()->flash('message.level', 'warning');
            $request->session()->flash('message.content', 'Purchase was Trashed!');
            $viewData['pageTitle'] = 'Purchase';       	
			$market= DB::table('credit_debit_details');
            $market->leftJoin('users','users.id','=','markets.user_id');
            $market->leftJoin('user_details','user_details.users_id','=','markets.user_id');
            $market->where('markets.deleted_at','=',null);
            $market->select('markets.*','users.name as user_name','users.email as user_email');
            $market->orderBy('id','desc');
            $market= $market->get();
            $viewData['market']=json_decode(json_encode($market), true);
			return view('AutoCare.credit-debit-log.search', $viewData);
        }else{
            session()->flash('status', ['danger', 'Operation was Failed!']);
			 $viewData['pageTitle'] = 'Purchase';       	
			$market= DB::table('credit_debit_details');
            $market->leftJoin('users','users.id','=','markets.user_id');
            $market->leftJoin('user_details','user_details.users_id','=','markets.user_id');
            $market->where('markets.deleted_at','=',null);
            $market->select('markets.*','users.name as user_name','users.email as user_email');
            $market->orderBy('id','desc');
            $market= $market->get();
            $viewData['market']=json_decode(json_encode($market), true);
			return view('AutoCare.credit-debit-log.search', $viewData);
       }
    }
    public function trashedList()
    {

         $trashed = CreditDebitDetail::orderBy('deleted_at', 'desc')->onlyTrashed()->simplePaginate(10);
         return view('AutoCare.credit-debit-log.delete', compact('trashed', 'trashed'));
      
    }
    public function permanemetDelete(Request $request,$id)
    {
    	if(($id!=null) && (CreditDebitDetail::where('id',$id)->forceDelete())){
            $request->session()->flash('message.level', 'warning');
            $request->session()->flash('message.content', "Purchase was deleted Permanently and Can't rollback in Future!"); 
        }else{
            session()->flash('status', ['danger', 'Operation was Failed!']);
       }

    	 $trashed = CreditDebitDetail::orderBy('deleted_at', 'desc')->onlyTrashed()->simplePaginate(50);
         return view('AutoCare.credit-debit-log.delete', compact('trashed', 'trashed'));
    }
}
