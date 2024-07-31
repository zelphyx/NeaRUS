<?php

namespace App\Http\Controllers\API\User;

use App\Events\ownerrequest;
use App\Http\Controllers\Controller;
use App\Mail\OwnerApproved;
use App\Mail\OwnerRejected;
use App\Models\Owner;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use App\Events\OwnerRequestUpdated;
use App\Notifications\ApprovalDeleted;

class AuthOwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }


    public function daftarowner(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email:dns|unique:users,email',
            'phonenumber' => 'numeric|nullable',
            'password' => 'required',
            'confirmpassword' => 'same:password',
            'jenis_kelamin' => 'nullable',
            'buktiimage' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tanggal_lahir' => 'nullable|date',
            'alamat_rumah' => 'nullable',
            'urgent_fullname' => 'nullable',
            'urgent_status' => 'nullable',
            'urgent_phonenumber' => 'numeric|nullable'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->all()
            ], 422);
        }

        try {
            $input = $request->all();
            $input['websiterole'] = 'Owner Request';
            if ($request->hasFile('buktiimage')) {
                $image = $request->file('buktiimage');
                $new_name = rand() . '.' . $image->extension();
                $image->move(public_path('storage/bukti-images'), $new_name);
                $input['buktiimage'] = config("app.url") . '/storage/bukti-images/' . $new_name;
            }
            User::create($input);

            return $this->succesRes([
                'success' => true,
                'message' => 'Owner Requested'
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email already exists'
                ], 422);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Database error: ' . $e->getMessage()
                ], 500);
            }
        }
    }
    public function showOwnerRequests()
    {
        $users = User::where('websiterole', 'Owner Request')->get();
        return view('owner_requests', compact('users'));
    }

    public function approveOwner($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->websiterole = 'Owner';
            $user->email_verified_at = now();
            $user->update(['image' => null]);

            $user->save();
            event(new ownerrequest($user));

            Mail::to($user->email)->send(new OwnerApproved($user));
            return redirect()->route('owner.requests')->with('success', 'Owner approved successfully.');
        } catch (\Exception $e) {
            return redirect()->route('owner.requests')->with('error', 'Failed to approve owner.');
        }
    }
    public function showOwners()
    {
        $owners = User::where('websiterole', 'Owner')->get();
        return view('owner_role', compact('owners'));
    }
    public function deleteOwner($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            Mail::to($user->email)->send(new OwnerRejected($user));
            return redirect()->route('owner.requests')->with('success', 'Owner deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('owner.requests')->with('error', 'Failed to delete owner.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Owner $owner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Owner $owner)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Owner $owner)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Owner $owner)
    {
        //
    }
}
