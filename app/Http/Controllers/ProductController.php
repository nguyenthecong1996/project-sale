<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use DataTables;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Product::get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct"><i class="fas fa-edit"></i> Edit</a>';
   
                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct"><i class="fas fa-trash"></i> Delete</a>';
    
                            return $btn;
                    })
                    ->addColumn('image', function ($row) { 
                        $url= $row['image'];
                        return '<img src="'.$url.'" border="0" width="60" class="img-rounded" align="center" />';
                    })
                    ->addColumn('quantity', function ($row) { 
                        return  $row['quantity'].' '. config('common.product_unit.1');
                    })
                    ->addColumn('status', function($row){
                        return $data = $row['status'] == config('common.customer_status.active') ? 'Active': 'Block';
                    })
                    ->rawColumns(['action', 'status', 'image', 'quantity'])
                    ->make(true);
        }
        return view('admin.product.index');
    }

    public function edit($id)
    {
        $customer = Product::find($id);
        return response()->json($customer);
    }

    public function store(Request $request)
    {
        $validate = [
            'code_product' => 'required|unique:products|max:10',
            'name' => 'required|max:255',
            'quantity' => 'required|numeric',
            'price' => 'required|numeric',
            'unit' => 'required|numeric|between:1,2',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable',
        ];
        
        if($request->product_id) {
            $validate['code_product'] = 'required|max:10|unique:products,code_product,'.$request->product_id;
        }
        $validated = $request->validate($validate);

        $data = [   
            'code_product' => $request->code_product, 
            'name' => $request->name,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'unit' => $request->unit,
            'description' => $request->description
        ];

        if ($request->file('image')) {
            $imagePath = $request->file('image');
            $fileName = time() . '.' . $imagePath->getClientOriginalExtension();
            $request->image->storeAs(
                'public/product',$fileName
            );
            $data['image'] = $fileName;
        }
        // if(!$request->status) {
        //     $data['status'] = 0;
        // }
        Product::updateOrCreate(['id' => $request->product_id], $data);        
   
        return response()->json(['success'=>'Product saved successfully.']);
    }

    public function destroy($id)
    {
        Product::find($id)->delete();
     
        return response()->json(['success'=>'Product deleted successfully.']);
    }
}
