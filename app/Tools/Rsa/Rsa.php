<?php
/**
 * Created by PhpStorm.
 * User: konghy
 * Date: 19-10-30
 * Time: 19-10-30
 */
namespace App\Tools;


/**
 * Class Rsa
 * @package App\Tools
 * rsa安全加密工具类
 */
class Rsa {

    /**
     * @var $publicKey
     * 公钥
     */
    public $publicKey;

    /**
     * @var $privateKey
     * 私钥
     */
    public $privateKey;

    /**
     * @return mixed
     * 获取公钥
     */
    public function getPublicKey() {
        return $this->publicKey;
    }

    /**
     * @return mixed
     * 获取私钥
     */
    public function getPrivateKey() {
        return $this->privateKey;
    }


    /**
     * @param $publicKey
     * 设置公钥
     */
    public function setPublicKey($publicKey) {
        $this->publicKey = $publicKey;
    }


    /**
     * @param $privateKey
     * 设置私钥
     */
    public function setPrivateKey($privateKey) {
        $this->privateKey = $privateKey;
    }


    /**
     * @param $data
     * @return bool|mixed|string
     * 公钥加密
     */
    public function enCryptByPublicKey($data) {
        //从证书或PEM格式的字符串中解析公钥
        $publicKey = openssl_pkey_get_public($this->publicKey);
        $enCrypted = '';
        openssl_public_encrypt($data,$enCrypted,$publicKey,OPENSSL_PKCS1_PADDING);
        $enCrypted = self::safeBase64Encode($enCrypted);
        return $enCrypted;
    }


    /**
     * @param $data
     * @return bool|mixed|string
     * 私钥加密
     */
    public function enCryptByPrivateKey($data) {
        $privateKey = openssl_pkey_get_private($this->privateKey);
        $enCrypted = '';
        openssl_private_encrypt($data,$enCrypted,$privateKey,OPENSSL_PKCS1_PADDING);
        $enCrypted = self::safeBase64Encode($enCrypted);
        return $enCrypted;
    }


    /**
     * @param $data
     * @return bool|string
     * 私钥解密
     */
    public function decrpytByPrivateKey($data) {
        $privateKey = openssl_pkey_get_private($this->privateKey);
        $desrypted = '';
        $data = self::safeBase64Decode($data);
        openssl_private_decrypt($data,$desrypted,$privateKey,OPENSSL_PKCS1_PADDING);
        return $desrypted;
    }


    /**
     * @param $data
     * @return bool|string
     * 通过公钥解密
     */
    public function decryptByPublicKey($data) {
        $publicKey = openssl_pkey_get_public($this->publicKey);
        $desrypted = '';
        $data = self::safeBase64Decode($data);
        openssl_public_decrypt($data,$desrypted,$publicKey,OPENSSL_PKCS1_PADDING);
        return $desrypted;
    }

    /**
     * @param $string
     * @return bool|mixed|string
     * 安全的base64编码解密
     */
    public static function safeBase64Encode($string) {
        $data = base64_encode($string);

        //由于base64加密过后的数据会出现+ / = 这种字符，为了防止被别人识别出来是base64编码，所以将这些base64编码后的关键字符替换为- _ @
        $data = str_replace(['+','/','='],['-','_','@'],$data);
        return $data;
    }


    /**
     * @param $string
     * @return bool|string
     * 安全的base64编码
     */
    public static function safeBase64Decode($string) {
        $string = str_replace(['-','_','@'],['+','/','='],$string);
        $mod4 = strlen($string) % 4;
        if($mod4) {
            $string .= substr('====',$mod4);
        }
        $data = base64_decode($string);
        return $data;
    }
}