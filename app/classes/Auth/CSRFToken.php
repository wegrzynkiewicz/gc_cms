<?php

namespace GC\Auth;

use GC\Data;
use GC\Exception\ValidCSRFTokenException;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\ValidationData;
use Lcobucci\JWT\Signer\Hmac\Sha256;

class CSRFToken
{
    /**
     * Tworzy token i dodaje ciasteczko przeglądarce
     */
    public static function register()
    {
        $csrfConfig = &Data::get('config')['csrf'];

        $builder = new Builder();
        $signer = new Sha256();

        $tokenString = (string)$builder
            ->setIssuer(server('SERVER_NAME')) // Configures the issuer (iss claim)
            ->setIssuedAt(time()) // Configures the time that the token was issue (iat claim)
            ->setExpiration(time() + $csrfConfig['expires']) // Configures the expiration time of the token (exp claim)
            ->setId(session_id())
            ->sign($signer, $csrfConfig['secretKey']) // creates a signature using "testing" as key
            ->getToken(); // Retrieves the generated token

        setcookie(
            $csrfConfig['cookieName'], # cookie name
            $tokenString, # value
            0, # expires
            '/', # path
            '', # domain
            false, # secure
            true # httpOnly
        );

        $_SESSION['csrfToken'] = $tokenString;
    }

    /**
     * Weryfikuje poprawność tokenu
     */
    public static function assert()
    {
        if (!static::validate()) {
            throw new ValidCSRFTokenException();
        }
    }

    /**
     * Weryfikuje poprawność tokenu
     */
    public static function validate()
    {
        $logger = Data::get('logger');
        $csrfConfig = &Data::get('config')['csrf'];
        $tokenString = def($_COOKIE, $csrfConfig['cookieName'], null);

        if ($tokenString === null) {
            $logger->csrf('Cookie failed');

            return false;
        }

        $signer = new Sha256();
        $parser = new Parser();
        $token = $parser->parse($tokenString);

        if (!$token) {
            $logger->csrf('Parsing failed');

            return false;
        }

        $data = new ValidationData();
        $data->setIssuer(server('SERVER_NAME'));
        $data->setId(session_id());

        if (!$token->validate($data)) {
            $logger->csrf('Validating failed');

            return false;
        }

        if (!$token->verify($signer, $csrfConfig['secretKey'])) {
            $logger->csrf('Encrypting failed');

            return false;
        }

        if ($tokenString !== def($_SESSION, 'csrfToken', null)) {
            $logger->csrf('Session failed');
            return false;
        }

        $logger->csrf('OK', [$tokenString]);

        return true;
    }
}
