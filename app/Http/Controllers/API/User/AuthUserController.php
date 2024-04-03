<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthUserController extends Controller
{
    public function index()
    {
        $properties = User::all();
        return response()->json($properties);
    }

    public function register(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email',
            'phonenumber' => 'required',
            'password' => 'required',
            'confirmpassword' => 'required|same:password'
        ]);
        if($validator -> fails()){
            $response = [

            ];
            return response()->json($response,400);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        $success['token'] = $user->createToken('MyApp')->plainTextToken;
        $success['name'] = $user->name;

        $response = [
            'success' => true,
            'data' => $success,
            'message' => 'User Registered'
        ];
        return response()->json($response,200);
    }

    public function login(Request $request){
        if(Auth::attempt(['email'=>$request->email,'password'=>$request->password])){
            $user = Auth::user();
            $success['token'] = $user->createToken('MyApp')->plainTextToken;
            $success['name'] =  $user->name;

            $response = [
                'success' => true,
                'data' => $success,
                'message' => 'User Logged In'
            ];
            return response()->json($response,200);
        }else{
            $response = [
                'success' => false,
                'message' => 'Unauthorized'
            ];
            return response()->json($response,);
        }
    }
}
