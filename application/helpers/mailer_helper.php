<?php
/**
 * Created by PhpStorm.
 * User: geekerbyte
 * Date: 10/3/15
 * Time: 2:11 PM
 */
?>
<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Mailer {
    public $mail_error = NULL;
    public function __construct() {
        date_default_timezone_set('Etc/UTC');
        require_once('../application/libraries/PHPMailer/PHPMailerAutoload.php');
    }
    public function send_mail($to = "", $subject = "", $body = ""){
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->Mailer = 'smtp';
        $mail->SMTPAuth = true;

//        $mail->Host = "email-smtp.us-west-2.amazonaws.com";
        $mail->Host = "smtp.sendgrid.net";
         // "ssl://smtp.gmail.com" didn't worked
        //$mail->Port = 465;
        //$mail->SMTPSecure = 'ssl';
        // or try these settings (worked on XAMPP and WAMP):
        $mail->Port = 587;
        $mail->SMTPSecure = 'tls';
    
        $mail->SMTPDebug = 0;
//        $mail->SMTPDebug = 2;
        $mail->Debugoutput = 'html';

        $mail->Username = "triplea";
        $mail->Password = "triplea@451m1";

//        $mail->Username = "geekerbyter";
//        $mail->Password = "roseontheline7";
//        $mail->Username = "AKIAJLMTCO4NJY5KTKOQ";
//        $mail->Password = "AmNgP1JwqyzpJbQSCV5oJhHjvAi8MDTMyiagyJQe+CbV";

        $mail->IsHTML(true); // if you are going to send HTML formatted emails
        $mail->SingleTo = true; // if you want to send a same email to multiple users. multiple emails will be sent one-by-one.

        $mail->From = "triplekinsola@gmail.com";
        $mail->FromName = "upin5.net";
         $mail->addAddress($to,"User 1");
        // $mail->addAddress("user.2@gmail.com","User 2");

        // $mail->addCC("user.3@ymail.com","User 3");
        // $mail->addBCC("user.4@in.com","User 4");

        $mail->Subject = $subject;
        $mail->Body = $body;

        if(!$mail->Send()) {
            log_message('error', 'Mailer Error: '.$mail->ErrorInfo);
            return false;
        }else{
            return true;
        }
    }
}