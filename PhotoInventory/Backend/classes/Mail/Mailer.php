<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require "vendor/autoload.php";

class Mailer
{
  //Create an instance; passing `true` enables exceptions

  public function __construct()
  {
  }
  public function sendEmailLink($tokenKey, $apiURL, $email)
  {
    // $apiURL = "https://findplacement.org";
    $mail = new PHPMailer(true);
    try {
      //Server settings
      // $mail->SMTPDebug = SMTP::DEBUG_SERVER; //Enable verbose debug output
      $mail->SMTPDebug = 0;
      $mail->isSMTP(); //Send using SMTP
      $mail->Host = "mail.privateemail.com"; //Set the SMTP server to send through
      $mail->SMTPAuth = true; //Enable SMTP authentication
      $mail->Username = "support@findplacement.org"; //SMTP username
      $mail->Password = "xyz@mailJacker3.14!"; //SMTP password
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //Enable implicit TLS encryption
      $mail->Port = 465; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

      //Recipients
      $mail->setFrom("support@findplacement.org", "Find Placement");
      $mail->addAddress($email); //Add a recipient
      /* $mail->addAddress('ellen@example.com');               //Name is optional
    $mail->addReplyTo('info@example.com', 'Information');
    $mail->addCC('cc@example.com');
    $mail->addBCC('bcc@example.com');

    //Attachments
    $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name */

      //Content
      $year = date("Y");
      $body = <<<STR
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta name="x-apple-disable-message-reformatting" />
    <title>Forget Password</title>

    <style>
      body {
        font-family: Arial, sans-serif;
        border: 2px solid #000000;
      }
      img {
        align-self: center;
      }
      pre {
        white-space: pre-wrap;       /* Since CSS 2.1 */
        white-space: -moz-pre-wrap;  /* Mozilla, since 1999 */
        white-space: -pre-wrap;      /* Opera 4-6 */
        white-space: -o-pre-wrap;    /* Opera 7 */
        word-wrap: break-word;       /* Internet Explorer 5.5+ */
      }
    </style>
  </head>
  <body style="margin: 10px; padding: 10px">
    <img src="cid:logo-img" />
    <h1>Reset Password</h1>
    <h2>This Password Reset Link will Expire in 15 minutes.</h2>
    <div>Click the Link Below to Reset Password.</div>
    <pre><a href="$apiURL/ResetPassword/$tokenKey" target="_blank"
      >$apiURL/ResetPassword/$tokenKey</a
    ></pre>
    <p>Do NOT share this link. Do NOT reply to this email.</p>
  </body>
  <footer>Find Placement &copy; $year</footer>
</html>
STR;
      $altBody = <<<TEXT
Reset Password.\n\n
This Password Reset Link will Expire in 15 minutes.\n\n
Open the Link Below to Reset Password.\n\n
$apiURL/ResetPassword/$tokenKey
\n\n
Do NOT share this link.
\n\n
Find Placement © $year
TEXT;

      // echo $altBody;
      // echo $body;

      $mail->isHTML(true); //Set email format to HTML
      $mail->Subject = "Reset Password";
      $mail->Body = $body;
      $mail->AddEmbeddedImage("logo.png", "logo-img", "logo.png");
      $mail->AltBody = $altBody;

      $mail->send();
      return true;
    } catch (Exception $e) {
      echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
      return false;
    }
  }
}
