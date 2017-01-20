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
    private $config;

    public function __construct()
    {
        $this->config = &Data::get('config')['csrf'];
    }

    /**
     * Sprawdza czy token został już zarejestrowany
     */
    public function isRegistered()
    {
        if (!isset($_COOKIE[$this->config['cookieName']])) {
            return false;
        }

        if (!isset($_SESSION['csrfToken'])) {
            return false;
        }

        return true;
    }

    /**
     * Tworzy token i dodaje ciasteczko przeglądarce
     */
    public function register()
    {
        $builder = new Builder();
        $signer = new Sha256();

        $tokenString = (string)$builder
            ->setIssuer(server('SERVER_NAME')) // Configures the issuer (iss claim)
            ->setIssuedAt(time()) // Configures the time that the token was issue (iat claim)
            ->setExpiration(time() + $this->config['expires']) // Configures the expiration time of the token (exp claim)
            ->setId(session_id())
            ->sign($signer, $this->config['secretKey']) // creates a signature using "testing" as key
            ->getToken(); // Retrieves the generated token

        setcookie(
            $this->config['cookieName'], # cookie name
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
     * Weryfikuje poprawność tokenu, rzuca wyjątek jeżeli nieprawidłowy
     */
    public function assert()
    {
        if (!$this->validate()) {
            throw new ValidCSRFTokenException();
        }
    }

    /**
     * Weryfikuje poprawność tokenu
     */
    public function validate()
    {
        $logger = Data::get('logger');
        $tokenString = def($_COOKIE, $this->config['cookieName'], null);

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

        if (!$token->verify($signer, $this->config['secretKey'])) {
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
