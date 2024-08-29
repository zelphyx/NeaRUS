<?php

namespace App\Http\Controllers\API\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Str;
use App\Mail\VerificationMail;
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
            'name' => '',
            'email' => 'email:dns|unique:users,email',
            'phonenumber' => 'numeric',
            'password' => '',
            'confirmpassword' => 'same:password',
            'jenis_kelamin' => 'nullable',
            'tanggal_lahir' => 'nullable|date',
            'alamat_rumah' => 'nullable',
            'urgent_fullname' => 'nullable',
            'urgent_status' => 'nullable',
            'urgent_phonenumber' => 'numeric'
        ]);


        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->all()
            ], 422);
        }

        $input = $request->all();
        $input['websiterole'] = 'User';

        $user = User::create($input);
        $verificationToken = Str::random(60);
        $user->update(['email_verification_token' => $verificationToken]);

        Mail::to($user->email)->send(new VerificationMail($user, $verificationToken));

        $userData = [
            'ownerId' => $user->ownerId,
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
            'token' => $verificationToken,
            'message' => 'User Registered',
        ]);
    }
    public function verifyEmail(Request $request, $token)
    {
        $user = User::where('email_verification_token', $token)->first();

        if (!$user) {
            return view(
                'afterlink'
            );
        }

        $user->email_verified_at = now();
        $user->email_verification_token = null;
        $user->save();

        return view(
            'afterlink'
        );
    }

    public function resendVerification(Request $request )
    {

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        if ($user->email_verified_at) {
            return response()->json(['message' => 'Email already verified'], 400);
        }
        $user->update(['email_verification_token' => null]);
        $verificationToken = Str::random(60);
        $user->update(['email_verification_token' => $verificationToken]);

        Mail::to($user->email)->send(new VerificationMail($user, $verificationToken));

        return response()->json(['message' => 'Verification email resent successfully']);
    }

    public function apiVerifyEmail(Request $request, $token)
    {
        $user = User::where('email_verification_token', $token)->first();

        if (!$user) {
            return response()->json(['message' => 'Invalid verification token'], 404);
        }

        $user->email_verified_at = now();
        $user->email_verification_token = null;
        $user->save();

        return response()->json(['message' => 'Email verified successfully']);
    }

    public function sendResetPasswordEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'Email not found'], 404);
        }

        $token = Str::random(60);
        $user->reset_password_token = $token;
        $user->save();

        $resetLink = url('/reset-password/' . $token);
        Mail::to($user->email)->send(new ResetPasswordMail($user, $resetLink));

        return response()->json(['message' => 'Reset password email sent']);
    }
    public function resetpassprofile(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'Email not found'], 404);
        }

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['message' => 'Current password is incorrect'], 403);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['message' => 'Password has been updated successfully']);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            'password' => 'required|string|min:8',
        ]);

        $user = User::where('reset_password_token', $request->token)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Invalid reset token.');
        }

        $user->password = Hash::make($request->password);
        $user->reset_password_token = null;
        $user->save();



        return view('completeresetpass');
    }


    public function addPersonalData(Request $request, $ownerId)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:255',
            'phonenumber' => 'nullable|numeric',
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

        $user->update($userData);

        return $this->succesRes([
            'success' => true,
            'data' => $userData,
            'message' => 'User data updated successfully',
        ]);
    }
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'photoprofile' => 'nullable|image|max:2048',
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users,email,ownerId',
            'phonenumber' => 'nullable|numeric',
            'password' => 'nullable|string|min:8|confirmed',
            'jenis_kelamin' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'alamat_rumah' => 'nullable|string',
            'urgent_fullname' => 'nullable|string',
            'urgent_status' => 'nullable|string',
            'urgent_phonenumber' => 'nullable|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->only([
            'name',
            'email',
            'phonenumber',
            'jenis_kelamin',
            'tanggal_lahir',
            'alamat_rumah',
            'urgent_fullname',
            'urgent_status',
            'urgent_phonenumber'
        ]);
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        if ($request->hasFile('photoprofile')) {
            if ($user->photoprofile) {
                Storage::disk('public')->delete($user->photoprofile);
            }

            $imagePath = $request->file('photoprofile')->store('profile_pics', 'public');
            $data['photoprofile'] = $imagePath;
        }
        $user->update($data);
        return response()->json(['message' => 'Profile updated successfully', 'data' => $user]);
    }




    public function loginuserowner(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" => "required|email:dns",
            "password" => "required"
        ]);

        if ($validator->fails()) {
            return $this->invalidRes($validator->getMessageBag());
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');
        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();
            if($user->email_verified_at === null){
                Auth::logout();
                return $this->UnathorizeRes([
                    'message' => 'Email Not Verified'
                ]);
            }

                $success['name'] = $user->name;
            $success['ownerId'] = $user->ownerId;
            $success['email'] = $user->email;
            $success['phonenumber'] = $user->phonenumber;
            $success['websiterole'] = $user->websiterole;
            $token = $user->createToken('user')->plainTextToken;

            return $this->succesRes([
                'success' => true,
                'data' => $success,
                'token' => $token,
                'message' => 'User Logged In'
            ]);
        } else {
            return $this->UnathorizeRes("Email or Password Incorrect");
        }
    }


    public function logoutuserowner(Request $request)
    {
        if (auth()->check()) {
            $user = auth()->user();
            $user->tokens()->delete();
            return response()->json(['message' => 'Logout successful.']);
        } else {
            return response()->json(['message' => 'User not authenticated.'], 401);
        }
    }



}
