<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use DataTables;
use Hash;
use DB;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $user = \Auth::user();

        $is_role = false;
        if ($user->can('create', [Role::class, $request->staff_id])) {
            $is_role = true;
        }

        if ($is_role) {
            $validate = [
                'email' => 'nullable|email|unique:users',
                'name' => 'required|max:255',
                'phone' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|min:9|max:15',
                'account' => 'required|max:50|unique:users',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ];

            if ($request->is_store == 'create') {
                $validate['user_code'] = 'required|unique:roles|max:10';
            }

            if($request->staff_id) {
                $validate['email'] = 'nullable|email|unique:users,email,'.$request->staff_id;
                $validate['account'] = 'required|max:50|unique:users,account,'.$request->staff_id;
            }

            $validated = $request->validate($validate);

            $data = [   
                'email' => $request->email,
                'phone' => $request->phone,
                'account' => $request->account,
                'name' => $request->name,
            ];

            $data['password'] =  Hash::make('123456');
            if(isset($request->password)) {
                $data['password'] = $request->password; 
            }

            if ($request->file('image')) {
                $imagePath = $request->file('image');
                $fileName = time() . '.' . $imagePath->getClientOriginalExtension();
                $request->image->storeAs(
                    'public/user',$fileName
                );
                $data['image'] = $fileName;
            }
            DB::beginTransaction();

            try {

                $getId = User::updateOrCreate(['id' => $request->staff_id], $data);
                if ($request->is_store == 'create') {
                    Role::create([
                        'user_id' => $getId['id'],
                        'user_code' => $request->user_code,
                        'status' => 2
                    ]);
                }
                
                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();
                throw new Exception($e->getMessage());
            }

            return response()->json(['success'=>'Product saved successfully.']);
        }    
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('auth_id', function ($row) { 
                        return  $row['auth_id'] =  \Auth::user()->id;
                    })
                    ->addColumn('auth_role', function ($row) { 
                        return  $row['auth_role'] =  \Auth::user()->role_status;
                    })
                    ->rawColumns(['auth_id', 'auth_role'])
                    ->make(true);
        }
        return view('admin.user.index');
    }

    public function edit($id)
    {
        $staff = User::find($id);
        // dd($staff);
        return response()->json($staff);
    }

    public function destroy($id)
    {
        $user = \Auth::user();

        $is_role = false;
        if ($user->can('create', [Role::class, $id])) {
            $is_role = true;
        }

        User::find($id)->delete();
     
        return response()->json(['success'=>'User deleted successfully.']);
    }
}
