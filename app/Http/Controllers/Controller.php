<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Return a '200 - OK' HTTP response.
     * Return a '204 - No Content' HTTP response.
     *
     * @param mixed $resource Resource to be returned
     *
     * @return Illuminate\Http\Response JSON response
     */
    protected function success($resource = null)
    {
        if (empty($resource)) {
            return response()->json($resource, 204);
        }

        return response()->json($resource, 200);
    }

    /**
     * Return a '201 - Created' HTTP response.
     *
     * @param mixed $resource Resource to be returned
     *
     * @return Illuminate\Http\Response JSON response
     */
    protected function created($resource)
    {
        return response()->json($resource, 201);
    }

    /**
     * Return a custom HTTP error response.
     *
     * @param string $message    Message to be displayed
     * @param int    $statusCode HTTP status code
     *
     * @return Illuminate\Http\Response JSON response
     */
    protected function error($message = null, $statusCode = 500)
    {
        // Provide a default message just in case
        if (!$message) {
            $message = 'An unknown error occurred';
        }

        // Return a JSON response indicating that an error occurred
        $response = [
            'message' => $message,
        ];

        return response()->json($response, $statusCode);
    }

    /**
     * Return a '404 - Not Found' HTTP response.
     *
     * @param string $message Message to be displayed
     *
     * @return Illuminate\Http\Response JSON response
     */
    protected function notFound($message = null, ?int $code = null)
    {
        // Provide a default message just in case
        if (!$message) {
            $message = 'Resource not found';
        }

        return response()->json([
            'message' => $message,
            'code' => $code,
        ], 404);
    }

    /**
     * Return a '400 - Bad request' HTTP response.
     *
     * @param string $message Message to be displayed
     *
     * @return Illuminate\Http\Response JSON response
     */
    protected function badRequest($message = null)
    {
        // Provide a default message just in case
        if (!$message) {
            $message = __('app.request.bad_request');
        }

        return $this->error($message, 400);
    }

    /**
     * Return a '422 - Unprocessable Entity' HTTP response.
     *
     * @param string $message Message to be displayed
     *
     * @return Illuminate\Http\Response JSON response
     */
    protected function unprocessableEntity($message = null)
    {
        // Provide a default message just in case
        if (!$message) {
            $message = 'Unprocessable entity';
        }

        return $this->error($message, 422);
    }

    protected function addWarningToResponse($result, $warning = '')
    {
        $content = collect(['warning' => $warning]);

        return $content->merge($result);
    }
}
