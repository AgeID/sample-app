<?php namespace App\AgeID;

use AgeId\EncryptionHelper;
use Illuminate\Contracts\Encryption\Encrypter;

class PayloadEncrypter implements Encrypter
{

    /** @var string */
    protected $key;

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
     * @param  bool   $serialize
     *
     * @throws \AgeId\AgeIdException
     * @return string
     */
    public function encrypt($value, $serialize = true): string
    {

        $encrypter = new EncryptionHelper($this->key);

        if ($serialize) $value = serialize($value);
        $encrypted = $encrypter->encrypt($value);
        return urlencode($encrypted);
    }


     /**
     * Decrypt the given value.
     *
     * @param  string $payload
     * @param  bool   $unserialize
     *
     * @throws \AgeId\AgeIdException
     * @return mixed
     */
    public function decrypt($payload, $unserialize = true)
    {
        $decrypter = new EncryptionHelper($this->key);
        $decrypted = $decrypter->decrypt($payload);


        if ($unserialize) $decrypted = unserialize($decrypted);
        return $decrypted;

    }
}
