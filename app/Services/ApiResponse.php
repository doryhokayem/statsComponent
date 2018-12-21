<?php
/**
 * @author dory 12/11/18
 */

namespace App\Services;

class ApiResponse
{
    /**
     * Return a successful response.
     *
     * @param string[] $data
     * @param int $status
     *
     * @return \Illuminate\Http\Response
     */
    public static function success($data = null, int $status = 200)
    {
        $return = [ 'status' => $status, 'success' => true ];
        if($data)
            $return['data'] = $data;
        return response()->json($return, $status);
    }

    /**
     * Return a failed response.
     *
     * @param int $status
     * @param mixed $message
     * @param string $type
     * @param string $trace_id
     *
     * @return \Illuminate\Http\Response
     */
    public static function fail(
        int $status,
        $message = null,
        string $type = '',
        string $trace_id = ''
    ) {
        $return = [ 'status' => $status, 'success' => false ];
        if(!empty($type))
            $return['error']['type'] = $type;
        if($message)
            $return['error']['message'] = $message;
        if(!empty($trace_id))
            $return['error']['trace_id'] = $trace_id;
        return response()->json($return, $status);
    }

    /**
     * Response for resource not found.
     *
     * @param string $message
     *
     * @return \Illuminate\Http\Response
     */
    public static function notFound(string $message = '')
    {
        $message = empty($message)
            ? __('api_response.not_found')
            : $message;
        return self::fail(404, $message, 'NotFoundException');
    }

    /**
     * Response for server error.
     *
     * @param string $message
     *
     * @return \Illuminate\Http\Response
     */
    public static function serverError(string $message = '')
    {
        $message = empty($message)
            ? __('api_response.server_error')
            : $message;
        return self::fail(500, $message,'ServerErrorException');
    }

    /**
     * Response for bad request.
     *
     * @param array $errors
     *
     * @return \Illuminate\Http\Response
     */
    public static function badRequest(array $errors = [])
    {
        $message = count($errors)
            ? $errors
            : __('api_response.bad_request');
        return self::fail(400, $message, 'BadRequestException');
    }

    /**
     * Response for unauthorized request.
     *
     * @param string $message
     *
     * @return \Illuminate\Http\Response
     */
    public static function unauthorized(string $message = '')
    {
        $message = empty($message)
            ? __('api_response.unauthorized')
            : $message;
        return self::fail(401, $message, 'UnauthorizedException');
    }

    /**
     * Response for unauthenticated request.
     *
     * @param string $message
     *
     * @return \Illuminate\Http\Response
     */
    public static function unauthenticated(string $message = '')
    {
        $message = empty($message)
            ? __('api_response.unauthenticated')
            : $message;
        return self::fail(403, $message, 'UnauthenticatedException');

    }
}