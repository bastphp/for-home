<?php


namespace App\tools;


use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\ValidationData;

class Jwt
{
    public static function makeToken($uid,$user)
    {
        //由于老项目和lumen框架内部部分类冲突,无法无缝接入,所以在这个方法里env函数获取不到值,只会使用第二个参数就是默认值
        $time   = time();
        $signer = new Sha256();
        $token  = (new Builder())->issuedBy(config('app.app_url'))
            ->permittedFor(config('app.app_url'))
            ->identifiedBy(self::randomString(), true)
            ->issuedAt($time)
            ->canOnlyBeUsedAfter($time)
            ->expiresAt($time + config('app.exp_time'))
            ->withClaim('uid', $uid)
            ->withClaim('user', $user)
            ->getToken($signer,new Key(config('app.jwt_key')));
        return (string)$token;
    }

    public static function checkToken($token) :bool
    {
        try {
            $token = (new Parser())->parse($token);
            $data  = new ValidationData();
            if (!$token->validate($data)){
                return false;
            }

            $signer = new Sha256();
            if (!$token->verify($signer,new Key(config('app.jwt_key')))){
                return false;
            }
            return true;
        }catch (\Exception $e){
            return false;
        }

    }

    public static function parserToken($token,$field='uid')
    {
        $token = (new Parser())->parse($token);
        return $token->getClaim($field);
    }

    public static function randomString()
    {
        return str_random(10);
    }
}