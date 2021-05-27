<?php


class Token
{
    private $secretKey;
    
    public function __construct()
    {
        if (\Session::getToken())
        {
            $this->secretKey = \Session::getToken();
        }
        else {
           $this->secretKey = md5(bin2hex(openssl_random_pseudo_bytes(6)));
        \Session::setToken($this->secretKey); 
        }
    }
    
    public function encode($string):string 
    {
        return openssl_encrypt($string, "AES-128-ECB", $this->secretKey);
    }
    
    public function decode(string $hash)
    {
        return openssl_decrypt($hash, "AES-128-ECB", $this->secretKey);
    }

}
