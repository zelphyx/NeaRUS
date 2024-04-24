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

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email:dns|unique:users,email',
            'phonenumber' => 'numeric',
            'password' => 'required',
            'confirmpassword' => 'required|same:password'
        ]);
        if ($validator->fails()) {
            return $this->invalidRes($validator->getMessageBag());
        }
        $input = $request->all();
        $input['websiterole'] = 'User';
        User::create($input);


        return $this->succesRes([
            'success' => true,
            'message' => 'User Registered'
        ]);
    }

    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            "email" => "required|email:dns",
            "password" => "required"
        ]);

        if ($validator->fails()) {
            return $this->invalidRes($validator->getMessageBag());
        }

        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

            return $this->UnathorizeRes("Email or Password Incorrect");
        }


        $user = Auth::user();
        $success['name'] = $user->name;
        $success['token'] = $user->createToken('auth_token')->plainTextToken;


        return $this->succesRes([
            'success' => true,
            'data' => $success,
            'message' => 'User Logged In'
        ]);
    }

    public function logout()
    {
        if (!auth("sanctum")->check()) {
            return $this->UnathorizeRes("Unauthenticated");
        }

        auth('sanctum')->user()->tokens()->delete();
        return $this->succesRes([
            'success' => true,
            'data' => null,
            'message' => 'Logout Success'
        ]);
    }
}
