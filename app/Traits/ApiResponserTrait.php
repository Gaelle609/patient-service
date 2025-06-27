<?php

namespace App\Traits;

use Illuminate\Http\Response;

trait ApiResponserTrait
{
    /**
     * Build success response with datas
     * @param  array $data
     * @param  string $message
     * @param  int $code
     * @return Illuminate\Http\JsonResponse
     */
    public function sendResponse($data, $message = null, $code = Response::HTTP_OK)
    {
        $response = [
            'success' => true,
            'message' => $message,
            'data'    => $data,
        ];

        return response()->json($response, $code);
    }


    /**
     * Build success response without data
     * @param  string $message
     * @return Illuminate\Http\JsonResponse
     */
    public function sendSuccess($message)
    {
        $response = [
            'success' => true,
            'message' => $message,
        ];

        return response()->json($response, 200);
    }


    /**
     * Build error responses
     * @param  string $message
     * @param  array $errorMessages
     * @param  int $code
     * @return Illuminate\Http\JsonResponse
     */
    public function sendError($message, $errorMessages = [], $code = 403)
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }


    /**
     * Build error responses
     * @param  string $message
     * @param  array $errorMessages
     * @param  int $code
     * @return Illuminate\Http\JsonResponse
     */
    public function sendServiceError($message, $errorMessages = [], $code = 403)
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response($response, $code)->header('Content-Type', 'application/json');
    }

}
