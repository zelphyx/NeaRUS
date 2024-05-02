<?php

namespace App\Http\Controllers\API\User;
use Illuminate\Auth\Events\Registered;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthUserController extends Controller
{
    public function index()
    {
        $users = User::all();

        $formattedUsers = $users->map(function ($user) {
            return [
                'ownerId' => $user->ownerId,
                'name' => $user->name,
                'websiterole' => $user->websiterole,
                'email' => $user->email,
                'phonenumber' => $user->phonenumber,
                'Data Pribadi' => [
                    'Jenis Kelamin' => $user->jenis_kelamin,
                    'Tanggal Lahir' => $user->tanggal_lahir,
                    'Alamat Rumah' => $user->alamat_rumah
                ],
                'Kontak Darurat' => [
                    'Nama Lengkap' => $user->urgent_fullname,
                    'Status' => $user->urgent_status,
                    'Nomor Telepon' => $user-> urgent_phonenumber
                ],
                'email_verified_at' => $user->email_verified_at,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
            ];
        });

        return response()->json($formattedUsers);
    }


    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email:dns|unique:users,email',
            'phonenumber' => 'numeric',
            'password' => 'required',
            'confirmpassword' => 'required|same:password',
            'jenis_kelamin' => 'nullable',
            'tanggal_lahir' => 'nullable|date',
            'alamat_rumah' => 'nullable',
            'urgent_fullname' => 'nullable',
            'urgent_status' => 'nullable',
            'urgent_phonenumber' => 'numeric'
        ]);

        if ($validator->fails()) {
            return $this->invalidRes($validator->getMessageBag());
        }

        $input = $request->all();
        $input['websiterole'] = 'User';

        $user = User::create($input);

        // Prepare user data for response
        $userData = [
            'ownerId' => $user->ownerId, // Changed from $user->ownerId to $user->id
            'name' => $user->name,
            'websiterole' => $user->websiterole,
            'email' => $user->email,
            'phonenumber' => $user->phonenumber,
            'Data Pribadi' => [
                'Jenis Kelamin' => $user->jenis_kelamin,
                'Tanggal Lahir' => $user->tanggal_lahir,
                'Alamat Rumah' => $user-> alamat_rumah
            ],
            'Kontak Darurat' => [
                'Nama Lengkap' => $user->urgent_fullname,
                'Status' => $user->urgent_status,
                'Nomor Telepon' => $user-> urgent_phonenumber
            ],
            'email_verified_at' => $user->email_verified_at,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
        ];

        if ($request->filled(['jenis_kelamin', 'tanggal_lahir', 'alamat_rumah'])) {
            $userData['Data Pribadi']['Jenis Kelamin'] = $input['jenis_kelamin'];
            $userData['Data Pribadi']['Tanggal Lahir'] = $input['tanggal_lahir'];
            $userData['Data Pribadi']['Alamat Rumah'] = $input['alamat_rumah'];
        }
        if ($request->filled(['urgent_fullname', 'urgent_status', 'urgent_phonenumber'])) {
            $userData['Kontak Darurat']['Nama Lengkap'] = $input['urgent_fullname'];
            $userData['Kontak Darurat']['Status'] = $input['urgent_status'];
            $userData['Kontak Darurat']['Nomor Telepon'] = $input['urgent_phonenumber'];
        }

        return $this->succesRes([
            'success' => true,
            'data' => $userData,
            'message' => 'User Registered',
        ]);
    }





    public function addPersonalData(Request $request, $ownerId)
    {
        $validator = Validator::make($request->all(), [
            'jenis_kelamin' => 'nullable',
            'tanggal_lahir' => 'nullable|date',
            'alamat_rumah' => 'nullable',
            'urgent_fullname' => 'nullable',
            'urgent_status' => 'nullable',
            'urgent_phonenumber' => 'numeric'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $user = User::find($ownerId);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $userData = $user->toArray();

        if ($request->has('jenis_kelamin')) {
            $userData['jenis_kelamin'] = $request->input('jenis_kelamin');
        }

        if ($request->has('tanggal_lahir')) {
            $userData['tanggal_lahir'] = $request->input('tanggal_lahir');
        }

        if ($request->has('alamat_rumah')) {
            $userData['alamat_rumah'] = $request->input('alamat_rumah');
        }

        if ($request->has('urgent_fullname')) {
            $userData['urgent_fullname'] = $request->input('urgent_fullname');
        }
        if ($request->has('urgent_status')) {
            $userData['urgent_status'] = $request->input('urgent_status');
        }
        if ($request->has('urgent_phonenumber')) {
        $userData['urgent_phonenumber'] = $request->input('urgent_phonenumber');
    }

        // Update the user with the new data
        $user->update($userData);

        return $this->succesRes([
            'success' => true,
            'data' => $userData,
            'message' => 'User data updated successfully',
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
