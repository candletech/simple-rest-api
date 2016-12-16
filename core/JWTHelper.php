<?php
use \Firebase\JWT\JWT;

class JWTHelper {
    /**
     * @var string|null
     */
    private static $secret = null;

    /**
     * @param array $data
     * @return string
     */
    public static function encode($data) {
        return JWT::encode($data, self::getSecret());
    }

    /**
     * @param string $jwt
     * @return array
     */
    public static function decode($jwt) {
        return (array) JWT::decode($jwt, self::getSecret(), array('HS256'));
    }

    /**
     * @return string
     */
    private static function getSecret() {
        if(self::$secret == null) {
            self::$secret = self::loadSecret();
        }

        return self::$secret;
    }

    /**
     * @return string
     */
    private static function loadSecret() {
        return parse_ini_file('jwt.ini')['secret'];
    }
}