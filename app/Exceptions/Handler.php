<?php

declare(strict_types=1);

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class Handler extends ExceptionHandler
{
    /**
     * Render an exception into an HTTP response.
     * @param \Illuminate\Http\Request $request
     * @param \Throwable $exception
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Throwable $exception): Response
    {
        // Generar un código de error único para soporte
        $errorId = uniqid('err_');
        // Loguear el error con el ID
        Log::error('Error ID: ' . $errorId, [
            'exception' => $exception,
            'url' => $request->fullUrl(),
        ]);

        // Detectar código de error
        $status = $this->isHttpException($exception) ? $exception->getStatusCode() : 500;
        $view = "errors.{$status}";
        if (view()->exists($view)) {
            return response()->view($view, [
                'errorId' => $errorId,
            ], $status);
        }
        return parent::render($request, $exception);
    }
}
