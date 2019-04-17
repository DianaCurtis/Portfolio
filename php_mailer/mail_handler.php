<?php
require_once('email_config.php');
require_once('phpmailer/PHPMailer/src/Exception.php');
require_once('phpmailer/PHPMailer/src/PHPMailer.php');
require_once('phpmailer/PHPMailer/src/SMTP.php');



$formName = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$formEmail = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$formPhone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_SPECIAL_CHARS);
$formMessage = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);



$mail = new PHPMailer\PHPMailer\PHPMailer;
$mail->SMTPDebug = 0;           // Enable verbose debug output. Change to 0 to disable debugging output.

$mail->isSMTP();                // Set mailer to use SMTP.
$mail->Host = 'smtp.gmail.com'; // Specify main and backup SMTP servers.
$mail->SMTPAuth = true;         // Enable SMTP authentication


$mail->Username = EMAIL_USER;   // SMTP username
$mail->Password = EMAIL_PASS;   // SMTP password
$mail->SMTPSecure = 'tls';      // Enable TLS encryption, `ssl` also accepted, but TLS is a newer more-secure encryption
$mail->Port = 587;              // TCP port to connect to
$options = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);
$mail->smtpConnect($options);
$mail->From = $formEmail;  // sender's email address (shows in "From" field)
$mail->FromName = $formName;   // sender's name (shows in "From" field)
$mail->addAddress('dianacurtisdev@gmail.com', 'Diana');  // Add a recipient (name is optional)
//$mail->addAddress('ellen@example.com');                        // Add a second recipient
$mail->addReplyTo($formEmail);                          // Add a reply-to address
//$mail->addCC('cc@example.com');
//$mail->addBCC('bcc@example.com');

//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'mailer message from '.$formName;
$mail->Body    = "
        time: ".date('Y-m-d H:i:s')."<br>
        from: {$_SERVER['REMOTE_ADDR']} <br>
        name: {$formName} <br>
        email: {$formEmail} <br>
        phone: {$formPhone}<br>
        message: {$formMessage}<br>
";
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;

} else {
    echo 'Message has been sent';
}
?>
