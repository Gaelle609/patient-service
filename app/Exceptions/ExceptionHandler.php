<?php

namespace App\Exceptions;

use App\Traits\ApiResponserTrait;
use Exception;
use Throwable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use UnexpectedValueException;

class ExceptionHandler
{
    use ApiResponserTrait;


    public static function render(Exception $e, Request $request)
    {
        $self = new self();

        if ($e instanceof ModelNotFoundException) {
            $model = strtolower(class_basename($e->getModel()));
            return $self->sendError("Aucune instance de {$model} trouvée.", [
                'error_type' => 'ModelNotFoundException',
            ], 404);
        }

        if ($e instanceof HttpException) {

            if ($e instanceof MethodNotAllowedHttpException) {
                $code = $e->getStatusCode();
                return $self->sendError(Response::$statusTexts[$code], [
                    'error_type' => 'MethodNotAllowedHttpException',
                ], $code);
            }

            if ($e instanceof NotFoundHttpException) {

                if ($e->getPrevious() instanceof ModelNotFoundException) {
                    $model = ucfirst(class_basename($e->getPrevious()->getModel()));
                    return $self->sendError("Aucune instance du model {$model} trouvée.", [
                        'error_type' => 'ModelNotFoundException',
                    ], Response::HTTP_NOT_FOUND);
                }


                return $self->sendError($e->getMessage(), [
                    'error_type' => 'NotFoundHttpException',
                ], Response::HTTP_NOT_FOUND);
            }


            $code = $e->getStatusCode();
            return $self->sendError(Response::$statusTexts[$code], [
                'error_type' => 'HttpException',
            ], $code);
        }


        if ($e instanceof AuthorizationException) {
            return $self->sendError('Vous n\'êtes pas autorisé à effectuer cette action.', [
                'error_type' => 'AuthorizationException',
            ], Response::HTTP_FORBIDDEN);
        }

        if ($e instanceof AuthenticationException) {
            return $self->sendError($e->getMessage(), [
                'error_type' => 'AuthenticationException',
            ], Response::HTTP_UNAUTHORIZED);
        }

        if ($e instanceof ValidationException) {
            return $self->sendError('Erreurs de validation.', $e->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($e instanceof UnexpectedValueException) {
            return $self->sendError('Valeur inattendue.', [
                'error_type' => 'UnexpectedValueException',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }


        // Guzzle - erreur de connexion réseau
        if ($e instanceof \GuzzleHttp\Exception\ConnectException) {
            return $self->sendError("Connexion impossible au service distant.", [
                'error_type' => 'ConnectException',
                'reason' => $e->getMessage(),
            ], 504);
        }

        // Guzzle - erreur client (ex: 404, 400)
        if ($e instanceof \GuzzleHttp\Exception\ClientException) {
            $response = $e->getResponse();
            $statusCode = $response ? $response->getStatusCode() : 400;
            $body = $response ? json_decode($response->getBody()->getContents(), true) : null;

            return $self->sendError("Erreur côté client distant.", [
                'error_type' => 'ClientException',
                'remote_error' => $body,
            ], $statusCode);
        }

        // Guzzle - erreur serveur distant (ex: 500)
        if ($e instanceof \GuzzleHttp\Exception\ServerException) {
            $response = $e->getResponse();
            $statusCode = $response ? $response->getStatusCode() : 502;
            $body = $response ? json_decode($response->getBody()->getContents(), true) : null;

            return $self->sendError("Erreur serveur du service distant.", [
                'error_type' => 'ServerException',
                'remote_error' => $body,
            ], $statusCode);
        }

        // Guzzle - autres
        if ($e instanceof \GuzzleHttp\Exception\GuzzleException) {
            return $self->sendError("Erreur Guzzle non classée.", [
                'error_type' => 'GuzzleException',
                'message' => $e->getMessage(),
            ], 500);
        }


        $statusCode = method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 500;
        $message = app()->environment('production') ? 'Erreur interne du serveur.' : $e->getMessage();
        $type = get_class($e);

        return $self->sendError($message, [$type], $statusCode);
    }
}
