<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use App\Models\Module;

class RoleAndPermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::where('name', '!=', 'Super Admin')
            ->where('name', '!=', 'Customer')
            ->get();
        $modules = Module::get();

        return view('roles-and-permissions.index', compact('roles', 'modules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $role = Role::find($request->role_id);

        if($request->permissions) {
            foreach($request->permissions as $permission){
                $existingPermission = Permission::where('name', $permission)->first();
                if(!$existingPermission){
                    Permission::create(['name' => $permission]);

                    $super_admin_role = Role::where('name', 'Super Admin')->first();
                    $super_admin_role->givePermissionTo($permission);
                }
            }
        }
        $role->syncPermissions($request->permissions);

        return redirect()->to(route('roles-and-permissions.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        //
    }
}
