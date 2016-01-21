<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use Validator;
use Illuminate\Http\Request;
use Hash;
use Redirect;
use Session;
use Storage;
class UserController extends Controller {

	public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $message = Auth::attempt(['email' => $email, 'password' => $password]);

        if($message){
            Auth::user();
            return response()->json([
                'success'=>true,
                'message'=>"Logged in successfully.",
                'user'=> Auth::getUser(),
            ]);

        }
        else{
            return response()->json([
                'success'=>false,
                'message'=>"Couldn't login"
            ]);
        }
    }

    public function logout(){
        Auth::logout();
        Session::flush();
        Session::regenerate();
        return response()->json([
            'success'=>true,
            'message'=>"Logged out successfully."
        ]);
    }

    public function register(Request $request){
        $name = $request->input('name');
        $email = $request->input('email');
        $password = Hash::make($request->input('password'));

        $validator = Validator::make($request->all(), array(
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8'

        ));
        if ($validator->fails()){
            return response()->json([
                'success'=>false,
                'message'=>"Couldn't register user",
                'error'=> $validator->messages()
            ]);
        }
        else{
            $user = User::create(['name'=>$name, 'email'=> $email, 'password'=> $password]);
            return response()->json([
                'success'=>true,
                'message'=>"User created successfully.",
                'user'=> $user
            ]);
        }
    }

    //Get logged in user info.
    public function user(){
        return response()->json([
            'success'=>true,
            'message'=>"Found current user.",
            'user'=> Auth::User(),
        ]);
    }



}
