<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function AllPermission(){
        $permissions = Permission::all();
        return view('admin.backend.pages.permission.all_permission',
    compact('permissions'));
    }//endd

    public function AddPermission()
    {
        $permissions = Permission::all();
        return view('admin.backend.pages.permission.add_permission');
    }//endd

    public function StorePermission(Request $request)
    {
        Permission::create([
            'name' => $request->name,
            'group_name' => $request->group_name,
            'guard_name' => 'admin'
        ]);

        $notification = array(
            'message' => 'Permission created Succesfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.permission')->with($notification);
    }//endd
        
    public function EditPermission($id){
        $permission = Permission::find($id);
        return view('admin.backend.pages.permission.edit_permission',
        compact('permission'));

    }//end

    public function UpdatePermission(Request $request)
    {
        $per_id = $request->id;
        Permission::find($per_id)->update([
            'name' => $request->name,
            'group_name' => $request->group_name,
        ]);

        $notification = array(
            'message' => 'Permission updated Succesfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.permission')->with($notification);
    }//endd

    public function DeletePermission($id){
        Permission::find($id)->delete();

        $notification = array(
            'message' => 'Permission Deleted Succesfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }//endd
}
