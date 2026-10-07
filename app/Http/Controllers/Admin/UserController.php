<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Role;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // All users with their post counts
    public function index()
    {
        $users = User::withCount('posts')
            ->orderBy('name')
            ->paginate(20);

        return view('admin.users.index', [
            'users' => $users,
            'roles' => Role::cases(),
        ]);
    }

    // Change one user's role
    public function updateRole(Request $request, User $user)
    {
        $data = $request->validate([
            'role' => ['required', Rule::enum(Role::class)],
        ]);

        // An admin must not lock themselves out by removing their own admin role
        if ($user->is($request->user())) {
            return back()->with('error', "You can't change your own role.");
        }

        $user->role = Role::from($data['role']);
        $user->save();

        return back()->with('success', $user->name.' is now '.$user->role->label().'.');
    }
}
