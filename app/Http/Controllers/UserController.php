<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function allStaff()
    {
     return   inertia::render('Admin/Staff', [
            'staff' => User::orderBy('created_at', 'DESC')->get(),
        ]);
    }
    public function storeStaff(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Create user
        $user = \App\Models\User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        return response()->json([
            'message' => 'Staff created successfully',
            'staff' => $user
        ]);
    }

    public function updateStaff(Request $request, User $staff)
    {
        // Validate input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $staff->id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        // Update user
        $staff->name = $validated['name'];
        $staff->email = $validated['email'];
        if (!empty($validated['password'])) {
            $staff->password = bcrypt($validated['password']);
        }
        $staff->save();

        return response()->json([
            'message' => 'Staff updated successfully',
            'staff' => $staff
        ]);
    }

    public function storeSubscriber(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:subscribers,email',
        ]);

        Subscriber::create($data);

        return response()->json(['message' => 'Subscription successful'], 201);

    }
    public function allSubscribers()
    {
     return   inertia::render('Admin/Subscribers', [
                'subscribers' => Subscriber::all(),
        ]);
    }
    public function destroyStaff(User $staff)
    {
        try {
            $staff->delete();

            return response()->json([
                'success' => true,
                'message' => 'Staff member deleted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting staff member. Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }




}
