<?php

namespace App\Http\Controllers;

use DB;
use App\Role;
use App\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ( request()->ajax() ){
            $data = Role::get();
            return datatables()->of($data)
                ->addColumn('actions', function($data){
                    if ( (Gate::allows('roles.update') || Gate::allows('roles.delete')) || Gate::allows('roles.give_permission') ){
                        if ( $data->id <= auth()->user()->role_id ) {
                            return "";
                        }

                        $html = "";

                        if ( Gate::allows('roles.update') && ( !in_array($data->id, [1, 1]) ) ){
                            $btnUpdate = '<button type="button" class="btn btn-warning btn-round btn-sm m-1" data-toggle="modal" data-target="#edit-role" data-id="' . $data->id . '" data-name="' .  $data->name . '"><i class="ti-pencil-alt"></i>' . __('Edit') . '</button>';
                        }

                        if ( Gate::allows('roles.give_permission')  ){
                            $btnPermission = '<a href="' . route('role.give_permissions', ['id' => $data->id]) . '"><button type="button" class="btn btn-primary btn-round btn-sm m-1"><i class="ti-key "></i>' . __('Permissions') . '</button>';
                        }

                        if ( Gate::allows('roles.delete') && ( !in_array($data->id, [1, 1]) ) ){
                            if ( isset($btnUpdate) ){
                                if ( isset($btnPermission) ){
                                    $html = '<form action="' . route('role.destroy', ['id' => $data->id]) . '" method="POST">' . csrf_field() . $btnUpdate .'
                
                                    <button class="btn btn-danger btn-round btn-sm m-1 destroy" data-user="' . $data->name . '" type="submit"><i class="ti-trash"></i>' . __('Delete') . '</button>' . $btnPermission . '
                                </form>';
                                }else {
                                    $html = '<form action="' . route('role.destroy', ['id' => $data->id]) . '" method="POST">' . csrf_field() . $btnUpdate .'
                
                                    <button class="btn btn-danger btn-round btn-sm m-1 destroy" data-user="' . $data->name . '" type="submit"><i class="ti-trash"></i>' . __('Delete') . '</button>
                                </form>';
                                }
                            }else {
                                if ( isset($btnPermission) ){
                                    $html = '<form action="' . route('role.destroy', ['id' => $data->id]) . '" method="POST">' . csrf_field() . '
                
                                    <button class="btn btn-danger btn-round btn-sm m-1 destroy" data-user="' . $data->name . '" type="submit"><i class="ti-trash"></i>' . __('Delete') . '</button>' . $btnPermission . '
                                </form>';
                                }else{
                                    $html = '<form action="' . route('role.destroy', ['id' => $data->id]) . '" method="POST">' . csrf_field() . '
                
                                    <button class="btn btn-danger btn-round btn-sm m-1 destroy" data-user="' . $data->name . '" type="submit"><i class="ti-trash"></i>' . __('Delete') . '</button>
                                </form>';

                                }

                            }
                        }else {
                            if ( isset($btnUpdate) ){
                                $html .= $btnUpdate;
                            }

                            if ( isset($btnPermission) ){
                                $html .= $btnPermission;
                            }
                        }
                    }else {
                        $html = '';
                    }
                        return $html;
                    })
                ->rawColumns(['actions'])
                ->addIndexColumn()
                ->make(true);
        }
        $title = "Role";
        return view('role.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role = new Role;

        $role->name = $request->name;
        
        $role->save();

        if ( !empty($role->id) ){
            toastr()->success('Role has been created.');
            return redirect()->route('role.index');
        }else {
            toastr()->error('Opss!... something wrong.');
            return redirect()->route('role.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $role = Role::find($request->id);

        $role->name = $request->name;
        
        if ( $role->save() ){
            toastr()->success('Role has been updated.');
            return redirect()->route('role.index');
        }else {
            toastr()->error('Opss!... something wrong.');
            return redirect()->route('role.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role, $id)
    {
        if ( Role::destroy($id) ){
            toastr()->success('Role has been deleted.');
            return redirect()->route('role.index');
        }else {
            toastr()->error('Opss!... something wrong.');
            return redirect()->route('role.index');
        }
    }

    public function permissions($id)
    {
        if ( !Gate::allows('roles.give_permission') ){
            return abort(403);
        }

        $permissions = Permission::get();
        $modul = [];

        foreach( $permissions as $permission ){
            $arr = explode('.', $permission->name);
            $key = $arr[0];
            if ( array_key_exists($key, $modul) ){
                array_push($modul[$key], [
                    'id' => $permission->id,
                    'name' => $permission->name,
                ]);
            }else {
                $arr = explode('.', $permission->name);
                $key = $arr[0];
                $modul["$key"] = array([
                    'id' => $permission->id,
                    'name' => $permission->name,
                ]);

            }
        }

        $role_has_permissions = Role::find($id);
        $title = 'Permission Role';
        return view('role.permission', compact('title', 'modul', 'role_has_permissions'));
    }

    public function givePermissions (Request $request, $id)
    {
        if ( !Gate::allows('roles.give_permission') ){
            return abort(403);
        }

        $permission_role = DB::table('permission_role')->where('role_id', $id)->delete();
        
        $role = Role::where('id', $id)->first();
        $role->permissions()->attach(array_map('intval', $request->permissions));
        
        $count = DB::table('permission_role')->where('role_id', $id)->get()->count();
        if ( $count == count($request->permissions) ){
            toastr()->success("Permission has been Updated for Role " . ucwords($role->name) . " .");
            return redirect()->route('role.index');
        }else {
            toastr()->error('Opss!... something wrong.');
            return redirect()->route('role.index');
        }

    }
}
