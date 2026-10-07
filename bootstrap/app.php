<?php

use App\Http\Middleware\EnsureUserIsAdmin;
use App\Http\Middleware\SecurityHeaders;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->redirectUsersTo(fn () => route('dashboard.posts.index'));

        $middleware->alias([
            'admin' => EnsureUserIsAdmin::class,
        ]);

        $middleware->append(SecurityHeaders::class);

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Always answer API routes with JSON errors, never HTML pages
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );

        // 404: "Post not found." instead of "No query results for model [App\Models\Post]"
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if (! $request->is('api/*')) {
                return null;   // website: keep the normal 404 page
            }

            $previous = $e->getPrevious();

            if ($previous instanceof ModelNotFoundException) {
                $model = class_basename($previous->getModel());   // "App\Models\Post" -> "Post"

                return response()->json(['message' => $model.' not found.'], 404);
            }

            return response()->json(['message' => 'Endpoint not found.'], 404);
        });

        // 405: wrong HTTP method (for example GET on /login)
        $exceptions->render(function (MethodNotAllowedHttpException $e, Request $request) {
            if (! $request->is('api/*')) {
                return null;
            }

            return response()->json(
                ['message' => 'This endpoint does not support the '.$request->method().' method.'],
                405,
                $e->getHeaders(),
            );
        });

        // 429: too many requests (throttle)
        $exceptions->render(function (ThrottleRequestsException $e, Request $request) {
            if (! $request->is('api/*')) {
                return null;
            }

            return response()->json(
                ['message' => 'Too many requests. Please wait a moment and try again.'],
                429,
                $e->getHeaders(),
            );
        });
    })->create();
