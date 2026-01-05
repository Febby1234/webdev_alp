<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request; // <--- WAJIB DITAMBAHKAN (Import Request)

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->trustProxies(at: "*");
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
        ]);

        $middleware->redirectGuestsTo(function (Request $request) {
            $user = $request->user();

            if ($user) {
                // Cek Role dan arahkan ke dashboard masing-masing
                if ($user->role === 'admin') {
                    return route('admin.dashboard');
                } elseif ($user->role === 'interviewer') {
                    return route('interviewer.dashboard');
                } else {
                    return route('student.dashboard');
                }
            }

            return route('student.dashboard');
        });
        // === KODE BARU SELESAI ===

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
