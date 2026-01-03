<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function show(): View
    {
        $user = Auth::user();

        $registration = Registration::with(['major', 'personalDetail'])
            ->where('user_id', $user->id)
            ->first();

        $personalDetail = $registration?->personalDetail;

        return view('student.profile.show', [
            'user' => $user,
            'registration' => $registration,
            'personalDetail' => $personalDetail,
        ]);
    }

    /**
     * Display the user's profile form for editing.
     */
    public function edit(): View
    {
        $user = Auth::user();

        $registration = Registration::with(['personalDetail'])
            ->where('user_id', $user->id)
            ->first();

        return view('student.profile.edit', [
            'user' => $user,
            'registration' => $registration,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('student.profile.show')->with('success', 'Profil berhasil diperbarui.');
    }
}
