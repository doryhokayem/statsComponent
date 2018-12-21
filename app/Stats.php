<?php
/**
 * @author dory 12/12/18
 */

namespace App;

use App\Services\ApiResponse;
use Reqwest\Requests\JSONRequest;

class Stats
{
    /**
     * The request handler.
     *
     * @var \Reqwest\Requests\JSONRequest
     */
    protected $request;

    /**
     * Create a new stats model.
     *
     * @return void
     */
    public function __construct()
    {
        $this->request = new JSONRequest;
    }

    /**
     * Get depth zero.
     *
     * @param string $url
     *
     * @return array
     */
    public function getDepthZero(string $url)
    {
        $response = $this->request
            ->addHeader('Content-Type', 'application/json')
            ->get($url);
        switch($response->getStatusCode()) {
            case 200:
               return ApiResponse::success($response->get('total'));
            default:
                $message = "Couldn't fetch stats(status_code="
                    . $response->getStatusCode() . ").";
                if(count($response->all()))
                    $message .= " [" . json_encode($response->all()) . "].";
                \Log::info($message);
                return [];
        }
    }

    /**
     * Get depth one.
     *
     * @param string $url
     *
     * @return string
     */
    public function getDepthOne(string $url)
    {
        $response = $this->request
            ->addHeader('Content-Type', 'application/json')
            ->get($url);
        switch($response->getStatusCode()) {
            case 200:
                return ApiResponse::success($response->all());
            default:
                $message = "Couldn't fetch stats(status_code="
                    . $response->getStatusCode() . ").";
                if(count($response->all()))
                    $message .= " [" . json_encode($response->all()) . "].";
                \Log::info($message);
                return [];
        }
    }

    /**
     * Get depth two.
     *
     * @param string $url
     *
     * @return array
     */
    public function getDepthTwo(string $url)
    {
        $response = $this->request
            ->addHeader('Content-Type', 'application/json')
            ->get($url);

           switch($response->getStatusCode()) {
               case 200:
                  return ApiResponse::success($response->get('details'));
               default:
                   $message = "Couldn't fetch stats(status_code="
                       . $response->getStatusCode() . ").";
                   if(count($response->all()))
                       $message .= " [" . json_encode($response->all()) . "].";
                   \Log::info($message);
                   return [];
           }
    }
}
