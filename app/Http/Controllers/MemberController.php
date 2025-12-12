<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MemberDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            // USER VALIDATION
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',

            // MEMBER DETAIL VALIDATION
            'business_name' => 'nullable|string|max:255',
            'address'       => 'nullable|string',
            'city'          => 'nullable|string|max:255',
            'pincode'       => 'nullable|string|max:20',
            'phone'         => 'nullable|string|max:20',
            'referral_code' => 'nullable|string|max:100',
        ]);

        DB::transaction(function () use ($validated) {

            // Create USER
            $user = User::create([
                'name'     => $validated['name'],
                'email'    => $validated['email'],
                'password' => $validated['password'],  // auto-hashed by User model
                'role'     => 'member',
            ]);

            // Create MEMBER DETAILS
            $user->memberDetail()->create([
                'business_name' => $validated['business_name'] ?? null,
                'address'       => $validated['address'] ?? null,
                'city'          => $validated['city'] ?? null,
                'pincode'       => $validated['pincode'] ?? null,
                'phone'         => $validated['phone'] ?? null,
                'referral_code' => $validated['referral_code'] ?? null,
            ]);
        });

        return response()->json([
            'success' => true,
            'message' => 'Member created successfully'
        ], 201);
    }
}
