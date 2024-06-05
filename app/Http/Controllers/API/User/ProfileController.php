<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class ProfileController extends Controller
{
    public function updateprofilebackup(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'phonenumber' => 'numeric',
            'photoprofile' => 'image',
        ]);

        $user = $request->user();
        $oldprofilepict = $user->photoprofile;

        if ($request->hasFile('photoprofile')){
            $image = $request->file('photoprofile');
            $new_name = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/photo_profile'), $new_name);
            $newImagePath = '/storage/photo_profile/' . $new_name;

            // Update the path to the new image
            $path = $newImagePath;
            $user->photoprofile = $path;
        }

        $user->name = $request->name;
        $user->phonenumber = $request->phonenumber;

        if ($user->save()){
            if ($oldprofilepict != $user->photoprofile){
                Storage::delete($oldprofilepict);
            }
            return response()->json($user, 200);
        } else {
            return response()->json([
                'message' => 'Error Occurred'
            ], 500);
        }
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        if (is_null($user)) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        // Validation
        $validator = Validator::make($request->all(), [
            'email' => 'nullable|email|unique:users,email,' . $user->ownerId,
            'name' => 'nullable|string|max:255',
            'phonenumber' => 'nullable|numeric',
            'photoprofile' => 'nullable|image|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        // Gather data for update
        $data = $request->only(['email', 'name', 'phonenumber']);

        // Handle photo upload
        if ($request->hasFile('photoprofile')) {
            $image = $request->file('photoprofile');
            $new_name = rand() . '.' . $image->extension();
            $image->move(public_path('storage/profile-images'), $new_name);
            $data['photoprofile'] = '/storage/profile-images/' . $new_name;
        }

        // Update user
        $user->update($data);

        return response()->json(['message' => 'Profile updated successfully', 'user' => $user], 200);
    }





    public function addPersonalData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:255',
            'jenis_kelamin' => 'nullable|string|max:10',
            'tanggal_lahir' => 'nullable|date',
            'alamat_rumah' => 'nullable|string|max:255',
            'urgent_fullname' => 'nullable|string|max:255',
            'urgent_status' => 'nullable|string|max:50',
            'urgent_phonenumber' => 'nullable|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $userData = $request->only([
            'name',
            'jenis_kelamin',
            'tanggal_lahir',
            'alamat_rumah',
            'urgent_fullname',
            'urgent_status',
            'urgent_phonenumber'
        ]);

        $user->update($userData);

        // Return success response
        return response()->json([
            'success' => true,
            'data' => $user,
            'message' => 'User data updated successfully',
        ]);
    }


    public function profileresetpass(Request $request){
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
}
