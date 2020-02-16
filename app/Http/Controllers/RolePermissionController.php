<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

Use Redirect;
use Datatables;
use Auth;
use DB;
use Hash;
use Mail;
use Session;
use Storage;

class RolePermissionController extends Controller
{
    public function permissionData(Request $request){

    	$permissions = Permission::all();

    	return Datatables::of($permissions)
        ->addIndexColumn()
        ->addColumn('created_at',function($model){
            return date("d-m-Y, D", strtotime($model->created_at));
        })
        ->addColumn('name', function ($model) {
            return '<input type="hidden" name="name_'.$model->id.'" id="name_'.$model->id.'" class="name_'.$model->id.'" value="'.$model->name.'">'.$model->name;
        })
        ->addColumn('guard_name', function ($model) {
            return '<input type="hidden" name="guard_name_'.$model->id.'" id="guard_name_'.$model->id.'" class="guard_name_'.$model->id.'" value="'.$model->guard_name.'">'.$model->guard_name;
        })
        ->addColumn('action', function ($model) {
            if (request()->has('guard')) {
                    $edit = '<button type="button" class="btn btn-info btn-xs btnEdit" name="btnEdit" id="btnEdit" data-target="#editPermission" data-toggle="modal" value="'.$model->id.'" >Edit</button>';
                    $delete = '<a class="btn btn-danger btn-xs btnDelete" href="'.url('/user_management/permission/'.$model->id.'/delete').'" id="btnDelete" data-toggle="tooltip" data-original-title="Delete" data-style="zoom-out">Delete</a>';

                    return $edit.' '.$delete;
            }
        })
        ->escapeColumns([])
        ->make(true);
    }

    public function permissionNew(Request $request){
    	if(request()->has('permission')){
    		$permissions = New Permission;
    		$permissions->name = $request->permission;
			$permissions->guard_name = $request->guard_name;
			$permissions->save();
			// dd($permissions);
			return Redirect::back()->with('message','Permission has been added');
    	}
    	return Redirect::back()->with('message','Permission failed to be added');

    }

    public function permissionDelete(Request $request, $id){
        
        DB::BeginTransaction();
        try{
            $permissions = Permission::destroy($id);
            DB::commit();
        
        }catch(\Exception $e){

            DB::rollback();
        }

        return redirect()->back()->with('message','Successfully Deleted');
    }

    public function permissionEdit(Request $request){

            $permissions = Permission::find($request->id);
            $permissions->name = $request->edit_name;
            $permissions->save();
            // dd($permissions);
            return redirect()->back()->with('message','Successfully Edited');           

    }
}
