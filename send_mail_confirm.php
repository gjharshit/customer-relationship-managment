<!DOCTYPE html>
<head>
    <title>Email Confirmation</title>
</head>

<?php
    require ('../includes/PHPMailer/PHPMailerAutoload.php');

    // Grab the username which contains the sender's email address
    // Grab the password for the user's account

    $username = $_POST["username"];
    $recepient = $_POST["recepient"];
    $password = $_POST["password"];
    $subject = $_POST["subject"];
    $body = $_POST["body"];

    $mail = new PHPMailer();

    // $mail->SMTPDebug = 1;                               // Enable verbose debug output

    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';                 // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = $username;                 // SMTP username
    $mail->Password = $password;                           // SMTP password
    $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 465;                                    // TCP port to connect to

    $mail->setFrom('sujaysanjeev.patil@gmail.com');
    // $mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
    $mail->addAddress("$recepient");               // Name is optional
    // $mail->addReplyTo('arjun@xcode.in', 'Information');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
    $mail->isHTML(true);                                  // Set email format to HTML

    $mail->Subject = "$subject";
    $mail->Body    = "$body" . '<br><b>Works perfectly well!</b>';
    $mail->AltBody = "$body";

    if(!$mail->send()) {
        echo '<html>Message could not be sent.<html>';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'Congratulations, Your message has been sent!';

        echo "<link href=\"https://fonts.googleapis.com/css?family=Josefin+Sans:400,400i,700,700i\" rel=\"stylesheet\">";
        echo "<style type=\"text/css\">";
        echo "html, body { font-family: Josefin Sans; text-align: center; font-size: 50px;}";
        echo "</style>";
    }
?>
