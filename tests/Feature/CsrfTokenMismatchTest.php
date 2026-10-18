<?php

namespace Tests\Feature;

use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;
use Tests\TestCase;

class CsrfTokenMismatchTest extends TestCase
{
    /**
     * Test endpoint /csrf-token mengembalikan JSON token yang valid.
     */
    public function test_csrf_token_endpoint_returns_json_with_token(): void
    {
        $response = $this->getJson('/csrf-token');

        $response->assertStatus(200);
        $response->assertJsonStructure(['token']);
    }

    /**
     * Test jika submit web portal login mengalami TokenMismatchException,
     * dialihkan kembali ke portal.login (302) dengan input dan warning flash, bukan error 419.
     */
    public function test_portal_login_token_mismatch_redirects_to_portal_login(): void
    {
        $request = Request::create('/portal/login', 'POST', [
            'login' => '123456',
            'phone' => '081234567890',
        ]);
        $request->setLaravelSession($this->app['session.store']);

        $handler = app(\Illuminate\Contracts\Debug\ExceptionHandler::class);
        $response = $handler->render($request, new TokenMismatchException('CSRF token mismatch.'));

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertEquals(route('portal.login'), $response->headers->get('Location'));
        $this->assertTrue(session()->has('warning'));
    }

    /**
     * Test jika admin login mengalami TokenMismatchException,
     * dialihkan kembali ke admin.login (302) dengan input dan warning flash.
     */
    public function test_admin_login_token_mismatch_redirects_to_admin_login(): void
    {
        $request = Request::create('/admin/login', 'POST', [
            'email' => 'admin@ptmsn.co.id',
        ]);
        $request->setLaravelSession($this->app['session.store']);

        $handler = app(\Illuminate\Contracts\Debug\ExceptionHandler::class);
        $response = $handler->render($request, new TokenMismatchException('CSRF token mismatch.'));

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertEquals(route('admin.login'), $response->headers->get('Location'));
        $this->assertTrue(session()->has('warning'));
    }

    /**
     * Test jika request AJAX / JSON mengalami TokenMismatchException,
     * mengembalikan JSON terstruktur dengan status 419 dan flag csrf_expired: true.
     */
    public function test_ajax_post_token_mismatch_returns_structured_json(): void
    {
        $request = Request::create('/portal/login/send-otp', 'POST', [
            'phone' => '081234567890',
        ]);
        $request->headers->set('Accept', 'application/json');
        $request->headers->set('X-Requested-With', 'XMLHttpRequest');
        $request->setLaravelSession($this->app['session.store']);

        $handler = app(\Illuminate\Contracts\Debug\ExceptionHandler::class);
        $response = $handler->render($request, new TokenMismatchException('CSRF token mismatch.'));

        $this->assertEquals(419, $response->getStatusCode());
        $data = json_decode($response->getContent(), true);
        $this->assertFalse($data['success']);
        $this->assertTrue($data['csrf_expired']);
        $this->assertNotEmpty($data['token']);
    }
}
