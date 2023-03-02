<?php
namespace system\lib\mail;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use system\core\config\config;
use system\lib\mail\mailLayout;


require_once ROOT ."/system/lib/mail/vendor/autoload.php";

class mail_smtp{

    use mailLayout;
    
    private $alternative;
    private $attachment;
    private $replyTo;
    private $body;
    private $subject;
    private $fromMail;
    private $fromName;

    public function attachment(array $attachment)
    {
        $this->attachment = $attachment;
        return $this;
    }

    public function alternative(string $alternative)
    {
        $this->alternative = $alternative;
        return $this;
    }

    public function reply(string $replyTo)
    {
        $this->replyTo = $replyTo;
        return $this;
    }

    public function subject(string $subject)
    {
        $this->subject = $subject;
        return $this;
    }

    public function body(string $body)
    {
        $this->body = $body;
        return $this;
    }

    public function fromName($name)
    {
        $this->fromName = $name;
        return $this;
    }


    public function send($mailUser, $name, $subject = '', $body = '', $alternative = '', $attachment = null)
    {
        ob_start();
        $mail = new PHPMailer();

        $mail->isSMTP();
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->Host = config::mail('host');
        $mail->Port = config::mail('port');
        $mail->SMTPAuth = true;
        $mail->Username = config::mail('userName');
        $mail->Password = config::mail('password');
        $mail->CharSet = "utf-8";

        if($this->fromName){
            $mail->setFrom(config::mail('fromEmail'), htmlspecialchars_decode($this->fromName)); // от кого (email и имя)
        }else{
            $mail->setFrom(config::mail('fromEmail'), config::globals('siteName')); // от кого (email и имя)
        }

        if($this->replyTo){
            $mail->addReplyTo($this->replyTo);
        }

        $mail->addAddress($mailUser, $name); // кому (email и имя)

        $mail->Subject = $this->subject ? $this->subject : $subject;
        $mail->msgHTML($this->body ? $this->body : $body);
        $mail->AltBody = $this->alternative;
        
        if($this->attachment){
            foreach($this->attachment as $i){
                $mail->addAttachment($i);
            }
        }

        // send the message, check for errors
        if (!$mail->send()) {
            //  echo 'Mailer Error: ' . $mail->ErrorInfo;
             if(!file_exists(ROOT . '/app/cache/logs')){
                mkdir(ROOT . '/app/cache/logs', 0755, true);
            } 
            $error = PHP_EOL . date('Y-m-d H:s') .  ' ' .  $mail->ErrorInfo;
            file_put_contents(ROOT . '/app/cache/logs/mail_smtp-' . date('Y-m') . '.log', $error, FILE_APPEND);
        } else {
            // echo 'Message sent!';
        } 
        $content = ob_get_contents();
        ob_end_clean();  
    }


}
