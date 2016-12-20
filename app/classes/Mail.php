<?php

namespace GC;

use GC\Model\MailSent;
use GC\Model\MailToSend;
use GC\Logger;
use PHPMailer;
use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;

class Mail extends PHPMailer
{
    private $hash = null;

    public function __construct()
    {
        parent::__construct(true);
        $this->bindMailerFromConfig(getConfig());
    }

    protected function bindMailerFromConfig(array $config)
    {
        try {
            $this->SMTPDebug = false;

            if ($config['email']['smtp']) {
                $this->isSMTP();
                $this->Host = $config['email']['host'];
                $this->SMTPAuth = true;
                $this->Username = $config['email']['username'];
                $this->Password = $config['email']['password'];
                $this->SMTPSecure = $config['email']['SMTPsecure'];
                $this->Port = $config['email']['port'];
            }

            $this->setFrom($config['email']['fromEmail'], $config['email']['fromName']);
            $this->CharSet = 'UTF-8';
            $this->isHTML(true);

        } catch (phpmailerException $exception) {
            Logger::logException($exception);
        }
    }

    public function buildTemplate($templateEmailPath, $stylePath, array $viewArgs = [])
    {
        $cssToInlineStyles = new CssToInlineStyles();
        $viewArgs['mail'] = $this;
        $viewArgs['config'] = getConfig();
        $html = view($templateEmailPath, $viewArgs);
        $css = view($stylePath);
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
        $this->hash = pseudoRandom(40);
        MailToSend::insert([
            'mail_hash' => $this->hash,
            'receivers' => implode('; ', array_keys($this->all_recipients)),
            'subject' => $this->Subject,
            'content' => serialize($this),
        ]);

        Logger::emailPush("$this->hash $this->Subject", array_keys($this->all_recipients));
    }

    public function send()
    {
        if ($this->hash === null) {
            $this->push();
        }

        try {
            parent::send();

            MailToSend::deleteAllBy('mail_hash', $this->hash);
            MailSent::insert([
                'mail_hash' => $this->hash,
                'receivers' => implode('; ', array_keys($this->all_recipients)),
                'subject' => $this->Subject,
                'content' => serialize($this),
            ]);

            Logger::emailSent("$this->hash $this->Subject", array_keys($this->all_recipients));

            return true;

        } catch (phpmailerException $exception) {
            Logger::logException($exception);
        }

        return false;
    }

    public static function sendScheduled()
    {
        $limitPerOnce = getConfig()['email']['limitPerOnce'];
        $emails = MailToSend::selectLatest($limitPerOnce);
        foreach($emails as $email) {
            $email->send();
        }
    }
}
