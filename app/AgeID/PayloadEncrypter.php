<?php namespace App\AgeID;

use AgeId\EncryptionHelper;
use Illuminate\Contracts\Encryption\Encrypter;

class PayloadEncrypter implements Encrypter
{

    /** @var string */
    protected $key;

    /** @var string */
    protected $cipher;


    /**
     * Create a new encrypter instance.
     *
     * @param string $cipher
     */
    public function __construct($cipher = 'AES-256-CBC')
    {
        $this->cipher = $cipher;


    }

    /**
     * @param string $key
     *
     * @return PayloadEncrypter
     */
    public function useKey(string $key): PayloadEncrypter
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Encrypt the given value.
     *
     * @param  string $value
     * @param  bool   $json
     *
     * @return string
     */
    public function encrypt($value, $json = true): string
    {

        $encrypter = new EncryptionHelper($this->key, null, \Config::get('ageId.version'));

        if ($json) $value = json_encode($value);
        $encrypted = $encrypter->encrypt($value);

        return urlencode($encrypted);
    }

    /**
     * Decrypt the given value.
     *
     * @param  string $payload
     * @param  bool   $json
     *
     * @return mixed
     */
    public function decrypt($payload, $json = true)
    {
        $decrypter = new EncryptionHelper($this->key, null, \Config::get('ageId.version'));
        $decrypted = $decrypter->decrypt($payload);

        if ($json) $decrypted = json_decode($decrypted, true);

        return $decrypted;

    }
}
