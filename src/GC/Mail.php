<?php

declare(strict_types=1);

namespace GC;

use GC\Auth\Password;
use GC\Model\Mail\Sent;
use GC\Model\Mail\ToSend;
use PHPMailer;
use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;

class Mail extends PHPMailer
{
    private $hash = null;

    public function __construct()
    {
        parent::__construct(true);

        try {
            $emailConfig = $GLOBALS['config']['mailer'];
            $this->SMTPDebug = 3;

            if ($emailConfig['smtp']) {
                $this->isSMTP();
                $this->Host = $emailConfig['host'];
                $this->SMTPAuth = true;
                $this->Username = $emailConfig['username'];
                $this->Password = $emailConfig['password'];
                $this->SMTPSecure = $emailConfig['SMTPsecure'];
                $this->Port = $emailConfig['port'];
            }

            $this->setFrom($emailConfig['fromEmail'], $emailConfig['fromName']);
            $this->CharSet = 'UTF-8';
            $this->isHTML(true);
        } catch (phpmailerException $exception) {
            throw $exception;
        }
    }

    public function buildTemplate($templateEmailPath, $stylePath, array $viewArgs = [])
    {
        $viewArgs['mail'] = $this;

        $html = render($templateEmailPath, $viewArgs);
        $css = render($stylePath);
        $compressed = compressHtml(removeOrphan($html));

        $cssToInlineStyles = new CssToInlineStyles();
        $this->Body = $cssToInlineStyles->convert($compressed, $css);
        $this->buildAltBody($html);
    }

    public function buildAltBody($htmlContent)
    {
        $altBody = strip_tags($htmlContent);
        $altBody = explode("\n", $altBody);
        $altBody = array_map(function ($line) {
            return trim($line);
        }, $altBody);
        $altBody = implode("\n", $altBody);
        $altBody = preg_replace("~\n{3,}~", "\n\n", $altBody);
        $this->AltBody = $altBody;
    }

    public function push()
    {
        $this->hash = random(40);
        ToSend::insert([
            'mail_hash' => $this->hash,
            'receivers' => implode('; ', array_keys($this->all_recipients)),
            'subject' => $this->Subject,
            'content' => serialize($this),
        ]);

        logger(
            "[EMAIL-PUSH] {$this->hash} {$this->Subject}",
            array_keys($this->all_recipients)
        );
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
            ]);

            logger(
                "[EMAIL-SENT] {$this->hash} {$this->Subject}",
                array_keys($this->all_recipients)
            );

            return true;
        } catch (phpmailerException $exception) {
            throw $exception;
        }

        return false;
    }
}
