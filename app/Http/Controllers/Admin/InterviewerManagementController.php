<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class InterviewerManagementController extends Controller
{
    /**
     * Display a listing of interviewers.
     */
    public function index()
    {
        $interviewers = User::where('role', 'interviewer')->paginate(10);
        return view('admin.interviewers.index', compact('interviewers'));
    }

    /**
     * Show the form for creating a new interviewer.
     */
    public function create()
    {
        return view('admin.interviewers.create');
    }

    /**
     * Store a newly created interviewer in database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            User::create([
                'name'     => $validated['name'],
                'email'    => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role'     => 'interviewer',
            ]);

            return redirect()->route('admin.interviewers.index')
                ->with('success', 'Akun Interviewer berhasil dibuat.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membuat akun: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified interviewer.
     */
    public function show(User $interviewer)
    {
        if ($interviewer->role !== 'interviewer') {
            return redirect()->route('admin.interviewers.index')
                ->with('error', 'User bukan interviewer.');
        }

        // Hitung statistik interviewer
        $exam_results = $interviewer->examResults()->count();
        $students_interviewed = $interviewer->examResults()->distinct('registration_id')->count();

        return view('admin.interviewers.show', compact('interviewer', 'exam_results', 'students_interviewed'));
    }

    /**
     * Show the form for editing the specified interviewer.
     */
    public function edit(User $interviewer)
    {
        if ($interviewer->role !== 'interviewer') {
            return redirect()->route('admin.interviewers.index')
                ->with('error', 'User bukan interviewer.');
        }

        return view('admin.interviewers.edit', compact('interviewer'));
    }

    /**
     * Update the specified interviewer in database.
     */
    public function update(Request $request, User $interviewer)
    {
        if ($interviewer->role !== 'interviewer') {
            return redirect()->route('admin.interviewers.index')
                ->with('error', 'User bukan interviewer.');
        }

        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $interviewer->id,
        ]);

        try {
            $interviewer->update($validated);

            return redirect()->route('admin.interviewers.index')
                ->with('success', 'Data Interviewer berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    /**
     * Reset password for the specified interviewer.
     */
    public function resetPassword(Request $request, User $interviewer)
    {
        if ($interviewer->role !== 'interviewer') {
            return redirect()->route('admin.interviewers.index')
                ->with('error', 'User bukan interviewer.');
        }

        $validated = $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            $interviewer->update([
                'password' => Hash::make($validated['password']),
            ]);

            return back()->with('success', 'Password interviewer berhasil direset.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mereset password: ' . $e->getMessage());
        }
    }

    /**
     * Delete the specified interviewer.
     */
    public function destroy(User $interviewer)
    {
        if ($interviewer->role !== 'interviewer') {
            return redirect()->route('admin.interviewers.index')
                ->with('error', 'User bukan interviewer.');
        }

        try {
            $interviewer->delete();

            return redirect()->route('admin.interviewers.index')
                ->with('success', 'Akun Interviewer berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus akun: ' . $e->getMessage());
        }
    }
}
