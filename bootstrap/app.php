<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

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

        // Redirect guest (belum login) ke halaman login
        $middleware->redirectGuestsTo('/login');

        // Redirect user yang sudah login (ketika akses halaman guest seperti /login, /register)
        $middleware->redirectUsersTo(function ($request) {
            $user = $request->user();

            if (!$user) {
                return '/';
            }

            return match($user->role) {
                'admin' => route('admin.dashboard'),
                'interviewer' => route('interviewer.dashboard'),
                default => route('student.dashboard'),
            };
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
