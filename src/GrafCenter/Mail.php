<?php

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

    public function compileTemplate($templateEmailFolder, array $viewArgs = [])
    {
        $cssToInlineStyles = new TijsVerkoyen\CssToInlineStyles\CssToInlineStyles();
        $viewArgs['mail'] = $this;
        $html = view($templateEmailFolder."/body.html.php", $viewArgs);
        $css = view($templateEmailFolder."/styles.css", $viewArgs);
        $content = $cssToInlineStyles->convert($html, $css);
        $this->Body = $content;

        $altBody = strip_tags($content);
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
        $this->hash = randomSha1();
        MailToSend::insert([
            'mail_hash' => $this->hash,
            'to' => implode('; ', array_keys($this->all_recipients)),
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
                'to' => implode('; ', array_keys($this->all_recipients)),
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
    }
}
