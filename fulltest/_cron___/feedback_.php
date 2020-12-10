<?
use PHPMailer\PHPMailer;
//use PHPMailer\PHPMailer\Exception;
require_once('php_mailer\src\PHPMailer.php');
echo "4 \n";
echo "0";
require_once('..\atena.ini.php');
echo "1 \n";
require_once("lib\atena.php");
echo "2 \n";
//require_once("../ext/email/smtp.class.php");
//require_once("../ext/email/Email.php");

//require_once("../ext/php_mailer/src/PHPMailer.php");

//require_once("../ext/php_mailer/src/Exception.php");
//require ('php_mailer/src/Exception.php');
//echo "3 \n";

//require 'php_mailer/src/SMTP.php';
//echo "5 \n";

//use php_mailer\src\CPHPMailer;

//use php_mailer\src\Exception;
//echo "4 \n";
//Esta rotina � responsavel por verificar eventos n�o baixados

//$atena = new atena();
//$atena->EnviaEmailFeedbackTeste();
$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
echo "6";
try {
    //Server settings
    $mail->SMTPDebug = 2;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.fulltime.com.br';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'fernando.lopes@fulltime.com.br';                 // SMTP username
    $mail->Password = 'ft12dt28';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('fernando.lopes@fulltime.com.br', 'Fernando');
    $mail->addAddress('flopesjunior@gmail.com', 'Fernando');     // Add a recipient
//    $mail->addAddress('ellen@example.com');               // Name is optional
//    $mail->addReplyTo('info@example.com', 'Information');
//    $mail->addCC('cc@example.com');
//    $mail->addBCC('bcc@example.com');

    //Attachments
//    $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Here is the subject';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
}


?>