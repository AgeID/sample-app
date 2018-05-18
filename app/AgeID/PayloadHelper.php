<?php namespace App\AgeID;

use Carbon\Carbon;

class PayloadHelper
{

    /** @var int */
    public $clientId;

    /** @var int */
    protected $timeout;

    /** @var PayloadEncrypter */
    protected $payloadEncrypter;

    /**
     * Create a new encrypter instance.
     *
     * @param string $timeoutInMinutes
     * @param string $encryptionKey
     * @param int $clientId
     */
    public function __construct($timeoutInMinutes = null, $encryptionKey = null, $clientId = null)
    {
        $this->clientId = $clientId ? $clientId : \Config::get('ageId.clientId');
        $this->timeout = $timeoutInMinutes ? $timeoutInMinutes : \Config::get('ageId.TimeoutInMinutes');
        $this->payloadEncrypter = new PayloadEncrypter();
        $this->payloadEncrypter->useKey($encryptionKey ? $encryptionKey : \Config::get('ageId.EncryptionKey'));
    }

    /**
     * @param string $code
     * @param string $ip
     * @return string
     */
    public function generateWithCode(string $code, string $ip): string
    {
        return $this->payloadEncrypter->encrypt([
            'expires_at'=> Carbon::now()->addMinutes($this->timeout),
            'user_addr' => $ip,
            'code'      => $code
        ]);
    }

    /**
     * @param string $token
     * @return string
     */
    public function generateWithToken(string $token): string
    {
        return $this->payloadEncrypter->encrypt([
            'expires_at' => Carbon::now()->addMinutes($this->timeout),
            'token'      => $token
        ]);
    }

    /**
     * @return string
     */
    public function generateForRedirectHandshake(): string
    {
        return $this->payloadEncrypter->encrypt([
            'expires_at' => Carbon::now()->addMinutes($this->timeout),
            'redirect_uri' => \Config::get('ageId.redirectURL')
        ]);
    }

    /**
     * @return string
     */
    public function generateForModalHandshake(): string
    {
        return $this->payloadEncrypter->encrypt([
            'expires_at' => Carbon::now()->addMinutes($this->timeout),
        ]);
    }

    /**
     * @param string $payload
     * @return array
     */
    public function wrapPayload(string $payload): array
    {
        return [
            'client_id' => $this->clientId,
            'payload' => $payload            
        ];
    }
}
