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
     * Default page size (pagination purposes).
     */
    const DEFAULT_PAGE_SIZE = 25;
    const PAGE_SIZE_OPTIONS = [25, 100, 1000, 10000];

    /**
     * Category (for logging purposes).
     */
    protected $category;

    /**
     * Return a warning for a missing page size.
     */
    public static function missingPageSize(): string
    {
        return 'No param "maxResults" received. Default value '.strval(self::DEFAULT_PAGE_SIZE).' assumed.';
    }

    /**
     * Return a warning for an invalid page size.
     */
    public static function invalidPageSize(): string
    {
        return 'Invalid param "maxResults" received. Default value '.strval(self::DEFAULT_PAGE_SIZE).' assumed. Options: '.implode(', ', self::PAGE_SIZE_OPTIONS).'.';
    }

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
     * @param array  $context    Logging context (objects, arrays, etc)
     * @param int    $statusCode HTTP status code
     * @param int    $level      Logging level (ex: INFO, NOTICE, ERROR...)
     * @param int    $code       Execution status code
     *
     * @return Illuminate\Http\Response JSON response
     */
    protected function error($message = null, array $context = [], $statusCode = 500, $level = \Monolog\Logger::ERROR, ?int $code = null)
    {
        // Provide a default message just in case
        if (!$message) {
            $message = 'An unknown error occurred';
        }

        // Return a JSON response indicating that an error occurred
        $response = [
            'message' => $message,
        ];

        if ($code) {
            $response['code'] = $code;
        }

        return response()->json($response, $statusCode);
    }

    /**
     * Return a '404 - Not Found' HTTP response.
     *
     * @param string $message Message to be displayed
     * @param array  $context Logging context (objects, arrays, etc)
     * @param int    $level   Logging level (ex: INFO, NOTICE, ERROR...)
     *
     * @return Illuminate\Http\Response JSON response
     */
    protected function notFound($message = null, array $context = [], $level = \Monolog\Logger::INFO, ?int $code = null)
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
     * @param array  $context Logging context (objects, arrays, etc)
     * @param int    $level   Logging level (ex: INFO, NOTICE, ERROR...)
     * @param int    $code    Execution status code
     *
     * @return Illuminate\Http\Response JSON response
     */
    protected function badRequest($message = null, array $context = [], $level = \Monolog\Logger::INFO, ?int $code = null)
    {
        // Provide a default message just in case
        if (!$message) {
            $message = __('app.request.bad_request');
        }

        return $this->error($message, $context, 400, $level, $code);
    }

    /**
     * Return a '422 - Unprocessable Entity' HTTP response.
     *
     * @param string $message Message to be displayed
     * @param array  $context Logging context (objects, arrays, etc)
     * @param int    $level   Logging level (ex: INFO, NOTICE, ERROR...)
     *
     * @return Illuminate\Http\Response JSON response
     */
    protected function unprocessableEntity($message = null, array $context = [], $level = \Monolog\Logger::INFO)
    {
        // Provide a default message just in case
        if (!$message) {
            $message = 'Unprocessable entity';
        }

        return $this->error($message, $context, 422, $level);
    }

    protected function addWarningToResponse($result, $warning = '')
    {
        $content = collect(['warning' => $warning]);

        return $content->merge($result);
    }

    /**
     * Return the default page size when paginating.
     *
     * @param mixed $page_size
     */
    protected function getPageSize($page_size)
    {
        if (!$page_size) {
            return [self::DEFAULT_PAGE_SIZE, self::missingPageSize()];
        }
        if (in_array($page_size, self::PAGE_SIZE_OPTIONS)) {
            return [$page_size, null];
        }

        return [self::DEFAULT_PAGE_SIZE, self::invalidPageSize()];
    }

    /**
     * Define a custom pagination to listing pages. Add a warning
     * message if param 'maxResults' was not found or contains an invalid
     * value.
     *
     * @param mixed $modelQuery
     * @param mixed $request
     */
    protected function customPagination($modelQuery, $request)
    {
        [$perPage, $warning] = self::getPageSize($request->maxResults);

        if ($warning) {
            return self::addWarningToResponse(
                $modelQuery->paginate($perPage),
                $warning
            );
        }

        return $modelQuery->paginate($perPage);
    }
}
