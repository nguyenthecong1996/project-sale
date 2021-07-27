<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Customer::get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct"><i class="fas fa-edit"></i> Edit</a>';
   
                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct"><i class="fas fa-trash"></i> Delete</a>';
    
                            return $btn;
                    })
                    ->addColumn('status', function($row){
                        return $data = $row['status'] == config('common.customer_status.active') ? 'Active': 'Block';
                    })
                    ->rawColumns(['action', 'status'])
                    ->make(true);
        }
        return view('admin.customer.index');
    }

    public function edit($id)
    {
        $customer = Customer::find($id);
        return response()->json($customer);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validate = [
            'customer_code' => 'required|unique:customers|max:10',
            'name' => 'required',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:9|max:10',
        ];
        
        if($request->customer_id) {
            $validate['customer_code'] = 'required|max:10|unique:customers,customer_code,'.$request->customer_id;
        }
        $validated = $request->validate($validate);

        
        $data = [   
            'customer_code' => $request->customer_code, 
            'name' => $request->name,
            'phone' => $request->phone,
            'adrress' => $request->adrress,
        ];

        if(!$request->status) {
            $data['status'] = 0;
        }
        Customer::updateOrCreate(['id' => $request->customer_id], $data);        
   
        return response()->json(['success'=>'Customer saved successfully.']);
    }

    public function destroy($id)
    {
        Customer::find($id)->delete();
     
        return response()->json(['success'=>'Product deleted successfully.']);
    }
}
