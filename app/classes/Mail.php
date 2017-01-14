<?php

namespace GC;

use GC\Model\Mail\Sent;
use GC\Model\Mail\ToSend;
use GC\Logger;
use GC\Render;
use GC\Password;
use PHPMailer;
use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;

class Mail extends PHPMailer
{
    private $hash = null;

    public function __construct()
    {
        parent::__construct(true);
        $this->bindMailerFromConfig(\GC\Data::get('config'));
    }

    protected function bindMailerFromConfig(array $config)
    {
        try {
            $this->SMTPDebug = false;

            if (GC\Data::get('config')['email']['smtp']) {
                $this->isSMTP();
                $this->Host = GC\Data::get('config')['email']['host'];
                $this->SMTPAuth = true;
                $this->Username = GC\Data::get('config')['email']['username'];
                $this->Password = GC\Data::get('config')['email']['password'];
                $this->SMTPSecure = GC\Data::get('config')['email']['SMTPsecure'];
                $this->Port = GC\Data::get('config')['email']['port'];
            }

            $this->setFrom(GC\Data::get('config')['email.fromEmail'), GC\Config::get('email']['fromName']);
            $this->CharSet = 'UTF-8';
            $this->isHTML(true);

        } catch (phpmailerException $exception) {
            Data::get('logger')->logException($exception);
        }
    }

    public function buildTemplate($templateEmailPath, $stylePath, array $viewArgs = [])
    {
        $cssToInlineStyles = new CssToInlineStyles();
        $viewArgs['mail'] = $this;
        $viewArgs['config'] = \GC\Data::get('config');
        $html = Render::action($templateEmailPath, $viewArgs);
        $css = Render::action($stylePath);
        $content = $cssToInlineStyles->convert($html, $css);
        $this->Body = $content;
        $this->buildAltBody($content);
    }

    public function buildAltBody($htmlContent)
    {
        $altBody = strip_tags($htmlContent);
        $altBody = explode("\n", $altBody);
        $altBody = array_map(function($line){
            return trim($line);
        }, $altBody);
        $altBody = implode("\n", $altBody);
        $altBody = preg_replace("~\n{3,}~", "\n\n", $altBody);
        $this->AltBody = $altBody;
    }

    public function push()
    {
        $this->hash = Auth\Password::random(40);
        ToSend::insert([
            'mail_hash' => $this->hash,
            'receivers' => implode('; ', array_keys($this->all_recipients)),
            'subject' => $this->Subject,
            'content' => serialize($this),
        ]);

        Data::get('logger')->emailPush("$this->hash $this->Subject", array_keys($this->all_recipients));
    }

    public function send()
    {
        if ($this->hash === null) {
            $this->push();
        }

        try {
            parent::send();

            ToSend::delete()->equals('mail_hash', $this->hash)->execute();
            Sent::insert([
                'mail_hash' => $this->hash,
                'receivers' => implode('; ', array_keys($this->all_recipients)),
                'subject' => $this->Subject,
                'content' => serialize($this),
            ]);

            Data::get('logger')->emailSent("$this->hash $this->Subject", array_keys($this->all_recipients));

            return true;

        } catch (phpmailerException $exception) {
            Data::get('logger')->logException($exception);
        }

        return false;
    }
}
