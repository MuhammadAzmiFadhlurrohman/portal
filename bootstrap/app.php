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
        $middleware->redirectTo(
            guests: function (\Illuminate\Http\Request $request) {
                if ($request->is('portal*')) {
                    return route('portal.login');
                }
                return route('admin.login');
            }
        );

        $middleware->alias([
            'portal.timeout' => \App\Http\Middleware\CustomerPortalSessionTimeout::class,
        ]);

        $middleware->validateCsrfTokens(except: [
            'coverage/check',
            'contact',
            'portal/logout',
            'portal/logout/*',
            'admin/logout',
            'logout',
            'midtrans/notification',
            'midtrans/*',
            'api/midtrans/*',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\HttpException $e, \Illuminate\Http\Request $request) {
            if ($e->getStatusCode() === 419 || $e->getPrevious() instanceof \Illuminate\Session\TokenMismatchException) {
                // Jika request AJAX atau JSON (misal API atau fetch kirim OTP)
                if ($request->expectsJson() || $request->ajax()) {
                    if ($request->hasSession() && empty($request->session()->token())) {
                        $request->session()->regenerateToken();
                    }

                    return response()->json([
                        'success' => false,
                        'csrf_expired' => true,
                        'message' => 'Sesi keamanan halaman telah kedaluwarsa. Memperbarui sesi...',
                        'token' => csrf_token() ?: ($request->hasSession() ? $request->session()->token() : ''),
                    ], 419);
                }

                // Jika rute portal pelanggan
                if ($request->is('portal*')) {
                    return redirect()->route('portal.login')
                        ->withInput($request->only('login', 'phone'))
                        ->with('warning', 'Sesi halaman Anda telah kedaluwarsa karena tidak ada aktivitas. Halaman telah disegarkan, silakan masuk kembali.');
                }

                // Jika rute admin
                if ($request->is('admin*') || $request->is('login')) {
                    return redirect()->route('admin.login')
                        ->withInput($request->only('email', 'username'))
                        ->with('warning', 'Sesi halaman Anda telah kedaluwarsa karena tidak ada aktivitas. Silakan masuk kembali.');
                }

                // Fallback untuk formulir lainnya
                return redirect()->back()
                    ->withInput($request->except(['_token', 'password', 'password_confirmation']))
                    ->with('warning', 'Sesi formulir telah kedaluwarsa. Silakan coba kirim kembali.');
            }
        });
    })->create();
