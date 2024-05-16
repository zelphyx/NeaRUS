<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;


class ProfileController extends Controller
{
    public function updateProfile(Request $request)
    {
        $user = $request->user();
        if (is_null($user)) {
            return response()->json([
                'message' => 'User not authenticated',
            ], 401);
        }
        $validator = Validator::make($request->all(), [
            'email' => 'email|unique:users,email,' . $user->email,
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

            // Delete old profile photo if exists
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

        $user->update($userData);

        return $this->succesRes([
            'success' => true,
            'data' => $userData,
            'message' => 'User data updated successfully',
        ]);
    }
}
