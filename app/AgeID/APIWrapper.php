<?php namespace App\AgeID;

use Illuminate\Support\Facades\Cache;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Carbon\Carbon;

class APIWrapper
{
    /**
     * The http client.
     *
     * @var GuzzleHttp\Client
     */
    private $httpClient;

    /**
     * The AgeID Payload Encryption class.
     *
     * @var App\AgeID\PayloadHelper
     */
    private $payloadHelper;

    /**
     * The code endpoint.
     *
     * @var string
     */
    private $codeURL;

    /**
     * The token endpoint.
     *
     * @var string
     */
    private $tokenURL;

    /**
     * Create a new controller instance.
     */
    public function __construct(string $ageIdBaseURL = null, string $codeURL = null, string $tokenURL = null)
    {
        $this->codeURL = $codeURL ? $codeURL : \Config::get('ageId.codeURL');
        $this->tokenURL = $tokenURL ? $tokenURL : \Config::get('ageId.tokenURL');
        $this->httpClient = new Client([ 'base_uri' => $ageIdBaseURL ? $ageIdBaseURL : \Config::get('ageId.baseURL') ]);
        $this->payloadHelper = new PayloadHelper();
    }

    public function callWithCode(string $code, string $ip) {

        $payloadData = $this->payloadHelper->generateWithCode($code, $ip);

        $response = $this->httpClient->request('POST', $this->codeURL, [
            RequestOptions::JSON => $this->payloadHelper->wrapPayload($payloadData)
        ]);
        
        return json_decode($response->getBody(), true);
    }

    public function callWithToken(string $token) {

        $payloadData = $this->payloadHelper->generateWithToken($token);

        $response = $this->httpClient->request('POST', $this->tokenURL, [
            RequestOptions::JSON => $this->payloadHelper->wrapPayload($payloadData)
        ]);

        return json_decode($response->getBody(), true);        
    }
}
