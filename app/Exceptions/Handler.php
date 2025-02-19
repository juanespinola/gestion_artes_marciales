<?php

namespace App\Exceptions;

use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof QueryException && $exception->getCode() == "23000") {
            $errorMessage = $exception->getMessage();

            if (str_contains($errorMessage, '1451')) {
                return response()->json([
                    'messages' => 'No se puede eliminar el registro porque está relacionado con otros datos.'
                ], 409);
            }

            if (str_contains($errorMessage, '1452')) {
                return response()->json([
                    'messages' => 'No se puede crear o actualizar el registro porque la clave foránea no existe.'
                ], 409);
            }
        }

        if ($exception instanceof QueryException && $exception->getCode() == "23503") {
            return response()->json([
                'messages' => 'No se puede eliminar el registro porque está relacionado con otros datos.'
            ], 409);
        }

        return parent::render($request, $exception);
    }
}
