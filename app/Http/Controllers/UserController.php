<?php

namespace App\Http\Controllers;

use Validator;
use App\User;
use App\Role;
use App\Gudang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ( request()->ajax() ){
            $data = User::get();
            return datatables()->of($data)
                // ->editColumn('scope', function($data){
                //     if ( $data->scope == 0 ){
                //         return 'Mobile';
                //     }elseif ( $data->scope == 1 ){
                //         return 'Web';
                //     }elseif ( $data->scope == 2 ){
                //         return 'Mobile & Web';
                //     }
                // })

                ->addColumn('role.name', function($data){
                    return $data->role->name;
                })
                
                ->addColumn('nama_gudang', function($data){
                    if ( $data->id_gudang === 0 ){
                        return 'Semua Gudang' ;
                    }else {
                        return $data->gudang->nama ?? '-';
                    }
                })

                ->addColumn('actions', function($data){
                    if ( Gate::allows('users.update') || Gate::allows('users.delete') ){
                        if ( $data->role_id <= auth()->user()->role_id ) {
                            return "";
                        }

                        $html = "";
                        if ( Gate::allows('users.update') ){
                            $btnUpdate = '<button type="button" class="btn btn-warning btn-round btn-sm mb-1" data-toggle="modal" data-target="#edit-user" data-id="' . $data->id . '" data-name="' .  $data->name . '" data-email="' . $data->email . '" data-roleid="' . $data->role_id . '" data-idgudang="' . $data->id_gudang .'" data-scope="' . $data->scope . '" data-locationid="' . $data->location_id . '"><i class="ti-pencil-alt"></i>' . __('Edit') . '</button>';
                        }

                        if ( Gate::allows('users.delete') != false ){
                            if ( isset($btnUpdate) ){
                                $html = '<form action="' . route('user.destroy', ['id' => $data->id]) . '" method="POST">' . csrf_field() . $btnUpdate .'
            
                                <button class="btn btn-danger btn-round btn-sm mb-1 destroy" data-user="' . $data->name . '" type="submit"><i class="ti-trash"></i>' . __('Delete') . '</button>
                            </form>';
                            
                            }else {
                                $html = '<form action="' . route('user.destroy', ['id' => $data->id]) . '" method="POST">' . csrf_field() . '
            
                                <button class="btn btn-danger btn-round btn-sm mb-1 destroy" data-user="' . $data->name . '" type="submit" ><i class="ti-trash"></i>' . __('Delete') . '</button>
                            </form>';

                            }
                        }else {
                            if ( isset($btnUpdate) ){
                                $html .= $btnUpdate;
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
        $title = "User";
        $roles = Role::get();
        $gudang = Gudang::where('active' ,1)->get();
        return view('user.index', compact('title', 'roles', 'gudang'));
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:users,name',
            'email' => 'required|unique:users,email',
        ]);

        if ($validator->fails()) {
            foreach ( $validator->errors()->all() as $error ){
                toastr()->error($error);
            }
            return redirect()->back();
        }

        $user = new User;

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role;
        $user->id_gudang = $request->id_gudang ?? NULL;
        // $user->scope = $request->scope;
        // $user->location_id = $request->location;
        $user->password = Hash::make($request->password);
        
        $user->save();

        if ( !empty($user->id) ){
            toastr()->success('User has been created.');
            return redirect()->route('user.index');
        }else {
            toastr()->error('Opss!... Something wrong.');
            return redirect()->route('user.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:users,name,' . $request->id,
            'email' => 'required|unique:users,email,' . $request->id,
        ]);

        if ($validator->fails()) {
            foreach ( $validator->errors()->all() as $error ){
                toastr()->error($error);
            }
            return redirect()->back();
        }

        $user = User::find($request->id);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role;
        $user->id_gudang = $request->id_gudang ?? NULL;
        // $user->scope = $request->scope;
        // $user->location_id = $request->location;
        if ( $request->password != '' || !empty($request->password) ){
            $user->password = Hash::make($request->password);
        }
        
        if ( $user->save() ){
            toastr()->success('User has been updated.');
            return redirect()->route('user.index');
        }else {
            toastr()->error('Opss!... Something wrong.');
            return redirect()->route('user.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ( user::destroy($id) ){
            toastr()->success('User has been deleted.');
            return redirect()->route('user.index');
        }else {
            toastr()->error('Opss!... Something wrong.');
            return redirect()->route('user.index');
        }
    }

    public function profile()
    {
        $profile = User::find(auth()->user()->id);
        $title = "My Profile";
        return view('user.profile', compact('title', 'profile'));
    }

    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:users,name,' . auth()->user()->id,
            'email' => 'required|unique:users,email,' . auth()->user()->id,
        ]);

        if ($validator->fails()) {
            foreach ( $validator->errors()->all() as $error ){
                toastr()->error($error);
            }
            return redirect()->back();
        }

        $profile = User::find(auth()->user()->id);

        $profile->name = $request->name;
        $profile->email = $request->email;
        $profile->date_of_birth = $request->date_of_birth;
        $profile->gender = $request->gender;
        $profile->marital_status = $request->marital_status;
        $profile->blood_group = $request->blood_group;
        $profile->contact_number = $request->contact_number;

        if ( $request->hasFile('profile_photo') ){  
            $extensions = array('png', 'jpg', 'jpeg');
            $max_size = 1000000; // Bytes / 1 MB
            $file_name = $profile->id . '-' . time() . '.' . $request->file('profile_photo')->extension();
            
            if ( $max_size < $request->file('profile_photo')->getSize() ){
                toastr()->error('Opss!... File size is too large. (Max Size 1MB)');
                return redirect()->back();
            }
            
            if ( !in_array($request->file('profile_photo')->extension(), $extensions)  ){
                toastr()->error('Opss!... your file is not supported for Profile Photo. (Use .jpg, .jpeg,  .png)');
                return redirect()->back();
            }

            if ( ($request->profile_photo != '' || !is_null($request->profile_photo)) && (\File::exists(public_path('uploads/profile/' . $profile->profile_photo))) ){
                \File::delete(public_path('uploads/profile/' . $profile->profile_photo));
            }

            $request->file('profile_photo')->move('uploads/profile', $file_name);
            $profile->profile_photo = $file_name;
        }

        if ( $profile->save() ){
            toastr()->success('Your Profile has been updated.');
            return redirect()->route('profile');
        }else {
            toastr()->error('Opss!... Something wrong.');
            return redirect()->route('profile');
        }
    }
    
    public function changePasswordProfile(Request $request)
    {
        if ( !Hash::check($request->current_password, auth()->user()->password) ){
            toastr()->error('Sorry... Your password wrong.');
            return redirect()->route('profile');
        }

        $user = User::find(auth()->user()->id);

        $user->password = Hash::make($request->password);

        if ( $user->save() ){
            toastr()->success('Your Password has been updated.');
            return redirect()->route('profile');
        }else {
            toastr()->error('Opss!... Something wrong.');
            return redirect()->route('profile');
        }
    }
}
