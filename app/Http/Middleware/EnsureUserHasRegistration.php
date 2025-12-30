<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Registration;

class EnsureUserHasRegistration
{
    /**
     * Handle an incoming request.
     * Middleware ini memastikan user sudah melakukan registrasi
     * Gunakan untuk routes yang membutuhkan registrasi (payment, documents, dll)
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Cek apakah user sudah registrasi
        $registration = Registration::where('user_id', $user->id)->first();

        if (!$registration) {
            return redirect()->route('student.register')
                ->with('error', 'Anda harus melakukan registrasi terlebih dahulu.');
        }

        return $next($request);
    }
}
