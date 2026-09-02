<?php

namespace App\Http\Controllers;

use App\Mail\AccountApprovedMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Throwable;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $this->ensureSysadmin();

        $search = trim((string) $request->input('search'));
        $role = (string) $request->input('role');
        $status = (string) $request->input('status');
        $search = addcslashes($search, '\\%_');

        $usersQuery = User::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('first_name', 'like', "%{$search}%")
                        ->orWhere('middle_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($role, fn ($query) => $query->where('usergroup', $role))
            ->when(in_array($status, ['active', 'inactive'], true), fn ($query) => $query->where('status', $status))
            ->orderBy('first_name')
            ->orderBy('last_name');

        $users = $usersQuery->paginate(10)->withQueryString();

        return view('authpage.admin.users', [
            'users' => $users,
            'totalUsers' => User::count(),
            'verifiedUsers' => User::whereNotNull('email_verified_at')->count(),
            'pendingUsers' => User::whereNull('approved_at')->count(),
            'roles' => User::query()->whereNotNull('usergroup')->distinct()->orderBy('usergroup')->pluck('usergroup'),
            'filters' => compact('search', 'role', 'status'),
        ]);
    }

    public function approvalIndex(Request $request)
    {
        $this->ensureSysadmin();

        $pendingUsers = User::query()
            ->whereNull('approved_at')
            ->orderBy('created_at')
            ->paginate(10);

        return view('authpage.admin.user-approvals', compact('pendingUsers'));
    }

    public function approve(User $user)
    {
        $this->ensureSysadmin();

        $temporaryPassword = $user->auth_provider === 'google' ? Str::random(12) : null;

        $attributes = [
            'approved_at' => now(),
            'approved_by' => Auth::id(),
            'status' => 'active',
        ];

        if ($temporaryPassword !== null) {
            $attributes['password'] = Hash::make($temporaryPassword);
        }

        $user->update($attributes);

        if ($temporaryPassword !== null) {
            try {
                Mail::to($user->email)->send(new AccountApprovedMail(
                    $user->name,
                    $user->email,
                    $temporaryPassword,
                ));
            } catch (Throwable $exception) {
                report($exception);
            }
        }

        return back()->with('approval_success', 'The account has been approved.');
    }

    public function toggleStatus(User $user)
    {
        $this->ensureSysadmin();

        abort_if($user->is(Auth::user()), 403, 'You cannot change your own account status.');

        $user->update([
            'status' => $user->status === 'active' ? 'inactive' : 'active',
        ]);

        return back()->with('status_success', 'The account status has been updated.');
    }

    private function ensureSysadmin(): void
    {
        abort_unless(Auth::user()?->usergroup === 'sysadmin', 403);
    }
}