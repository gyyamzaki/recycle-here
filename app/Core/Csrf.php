<?php

declare(strict_types=1);

namespace App\Core;

final class Csrf
{
    private const SESSION_KEY =
        '_csrf_token';


    public static function token(): string
    {
        $token =
            Session::get(
                self::SESSION_KEY
            );


        if (!is_string($token)) {

            $token =
                bin2hex(
                    random_bytes(32)
                );


            Session::put(
                self::SESSION_KEY,
                $token
            );
        }


        return $token;
    }


    public static function validate(
        ?string $token
    ): bool {

        $storedToken =
            Session::get(
                self::SESSION_KEY
            );


        if (
            !is_string($storedToken) ||
            !is_string($token)
        ) {
            return false;
        }


        return hash_equals(
            $storedToken,
            $token
        );
    }
}