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
        $user = $request->user();
        if (is_null($user)) {
            return response()->json([
                'message' => 'User not authenticated',
            ], 401);
        }
        $validator = Validator::make($request->all(), [
            'email' => 'email|unique:users,email' . $user->ownerId . ',ownerId',
            'name' => 'string|max:255',
            'phonenumber' => 'numeric',
            'photoprofile' => 'image',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation fails',
                'errors' => $validator->errors()
            ], 422);
        }

        if ($request->hasFile('photoprofile')) {
            $image = $request->file('photoprofile');
            $new_name = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/photo_profile'), $new_name);
            $newImagePath = '/storage/photo_profile/' . $new_name;

            if ($user->photoprofile) {
                $oldImagePath = str_replace('/storage', 'public', $user->photoprofile);
                Storage::delete($oldImagePath);
            }
        } else {
            $newImagePath = $user->photoprofile;
        }

        $user->update([
            'email' => $request->get('email', $user->email),
            'name' => $request->get('name', $user->name),
            'phonenumber' => $request->get('phonenumber', $user->phonenumber),
            'photoprofile' => $newImagePath,
        ]);

        return response()->json([
            'message' => 'Profile updated successfully',
            'user' => $user
        ], 200);
    }




    public function addPersonalData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'nullable',
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

        $user = Auth::user();
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

    public function profileresetpass(Request $request){
        $user = Auth::user();

        // Validate input
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Check if current password matches
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['error' => 'Current password does not match.'], 400);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Password updated successfully.',
        ], 200);
    }
}
