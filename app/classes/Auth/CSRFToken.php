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

        # sprawdzenie poprawności tokenu csrf, tylko gdy metoda post
        if (Data::get('request')->isMethod('POST')) {
            $this->assert();
        }

        # utworzenie nowego JWT, jeżeli nie został zarejestrowany
        if (!$this->isRegistered()) {
            $this->register();
        }
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
            time() + $this->config['expires'], # expires
            '/', # path
            '', # domain
            false, # secure
            true # httpOnly
        );

        $_SESSION['csrfToken'] = $tokenString;

        Data::get('logger')->csrf('Register', [$tokenString]);
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
        $tokenString = def($_COOKIE, $this->config['cookieName'], null);

        if ($tokenString === null) {
            return $this->abort('Cookie failed');
        }

        $signer = new Sha256();
        $parser = new Parser();
        $token = $parser->parse($tokenString);

        if (!$token) {
            return $this->abort('Parsing failed');
        }

        $data = new ValidationData();
        $data->setIssuer(server('SERVER_NAME'));
        $data->setId(session_id());

        if (!$token->validate($data)) {
            return $this->abort('Validating failed');
        }

        if (!$token->verify($signer, $this->config['secretKey'])) {
            return $this->abort('Encrypting failed');
        }

        if ($tokenString !== def($_SESSION, 'csrfToken', null)) {
            return $this->abort('Session failed');
        }

        Data::get('logger')->csrf('OK');

        return true;
    }

    /**
     * Niszczy dane tokenu
     */
    public function abort($message)
    {
        Data::get('logger')->csrf($message);
        setcookie($this->config['cookieName'], null);
        unset($_SESSION['csrfToken']);

        return false;
    }
}
