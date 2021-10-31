<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use App\Barang;
use App\Permission;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Validator;
use DB;

class UserController extends Controller
{

    public $successStatus = 200;

    public function login(){
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('nApp')->accessToken;

            $user = User::find($user->id);
            
            // if ( $user->scope == 1 ){
            //     return response()->json(['error'=>'Akun ini tidak berlaku untuk Mobile'], 401);
            // }else {
            // }

            $user->api_token = $success['token'];
            $user->expired_at = Carbon::now()->addMinutes(5);
            $user->save();
            
            $user = DB::table('users')->select(['id', 'name', 'role_id', 'id_gudang', 'api_token'])->where('id', $user->id)->first();
			$role = Role::select(['id', 'name'])->where('id', $user->role_id)->with(['permissions'])->first();
			//$user = User::select(['id', 'name', 'role_id', 'id_gudang', 'api_token'])->where('id', $user->id)->with(['permissions'])->first();
            return response()->json(['user' => $user, 'role' => $role], $this->successStatus);
        }
        else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $input += ['role_id' => 2];
        $user = User::create($input);
        $success['token'] =  $user->createToken('nApp')->accessToken;
        $success['name'] =  $user->name;

        return response()->json(['success'=>$success], $this->successStatus);
    }

    public function logout(Request $request)
    {
        $logout = User::find($request->user()->id);
        $logout->api_token = null;
        $logout->expired_at = null;
        $logout->save();

        if($logout){
            return response()->json([
                'message' => 'Successfully logged out'
            ]);
        }
    }

    public function details()
    {
        $user = Auth::user();
        return response()->json(['success' => $user], $this->successStatus);
    }
} 