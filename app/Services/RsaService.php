<?php
/**
 * Created by PhpStorm.
 * User: lotiger
 * Date: 17-12-4
 * Time: 下午10:59
 */

namespace App\Services;

class RsaService extends Service
{
    public $config,$keypath, $prikey_path, $pubkey_path, $prikey, $pubkey , $private_key_size;

    /**
     * 选择方式并初始化公钥私钥和配置项
     * @param string $select
     * @return $this|bool
     */
    public function select($select = 'rsa_api')
    {
        $config = config('crypt');
        if (array_key_exists($select, $config)) {
            $this->config = $config[$select];
            $this->private_key_size = $this->config['openssl_config']['private_key_bits'];
        } else {
            return false;
        }
        $this->keypath = $this->config['path'];

        if(!file_exists($this->keypath)){
            mkdir($this->keypath,"0777",true);
        }
        $this->prikey_path = $this->keypath . $this->config['private_key_file_name'];
        $this->pubkey_path = $this->keypath . $this->config['public_key_file_name'];
        if (file_exists($this->prikey_path))
            $this->prikey = file_get_contents($this->prikey_path);
        if (file_exists($this->pubkey_path))
            $this->pubkey = file_get_contents($this->pubkey_path);
        return $this;
    }

    public function makeKey()
    {
        $res = openssl_pkey_new($this->config['openssl_config']);
        openssl_pkey_export($res, $this->prikey);
        file_put_contents($this->prikey_path, $this->prikey);
        $pubkey = openssl_pkey_get_details($res);
        $this->pubkey = $pubkey['key'];
        file_put_contents($this->pubkey_path, $this->pubkey);
        return $test = ['prikey' => $this->prikey, 'pubkey' => $this->pubkey];
    }

    public function encryptPrivate($data){
        $crypted =base64_encode($this->doEncryptPrivate($data));
        return $crypted;
    }
    public function encryptPublic($data){
        $crypted=base64_encode($this->doEncryptPublic($data));
        return $crypted;
    }

    public function decryptPublic($data){
        $decrypted = $this->doDecryptPublic(base64_decode($data));
        return $decrypted;
    }
    public function decryptPrivate($data){
        $decrypted = $this->doDecryptPrivate(base64_decode($data));
        return $decrypted;
    }
    private function encrypt_split($data){
        $crypt=[];$index=0;
        for($i=0; $i<strlen($data); $i+=117){
            $src = substr($data, $i, 117);
            $crypt[$index] = $src;
            $index++;
        }
        return $crypt;
    }
    private function doEncryptPrivate($data)
    {
        $rs = '';
        if (@openssl_private_encrypt($data, $rs, $this->prikey) === FALSE) {
            return NULL;
        }
        return $rs;
    }

    private function doDecryptPrivate($data)
    {
        $rs = '';
        if (@openssl_private_decrypt($data, $rs, $this->prikey) === FALSE) {
            return null;
        }
        return $rs;
    }
    private function doEncryptPublic($data){
        $rs = '';
        if (@openssl_public_encrypt($data, $rs, $this->pubkey) === FALSE) {
            return NULL;
        }
        return $rs;
    }
    private function doDecryptPublic($data)
    {
        $rs = '';
        if (@openssl_public_decrypt($data, $rs, $this->pubkey) === FALSE) {
            return null;
        }
        return $rs;
    }
}