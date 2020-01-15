<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

    $to = "info@sysgsoft.com";
    $subject="Message From SysGSoft Website";
    $sender_name = $_POST['name'];	
    $from = $_POST['email'];    
    $phone = $_POST['phone'];    
    $msg = $_POST['message'];  
    $message ="------Sender Details------ <br>";
    $message .="Name: ".$sender_name."<br>";
    $message .="Phone No: ".$phone."<br>";
    $message .="Email: ".$from."<br>";
    $message .="Message: ".$msg."<br>";	

    $secretkey="6LcyKc8UAAAAAE2rqG8KYO3h2JEQ0UV5WIMLT9YV";
    $responsekey=$_POST['g-recaptcha-response'];
    $UserIp = $_SERVER['REMOTE_ADDR'];
    $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretkey&response=$responsekey&remoteip=$UserIp";

    $response= file_get_contents($url);
    $response= json_decode($response);

	require 'PHPMailer/src/Exception.php';
	require 'PHPMailer/src/PHPMailer.php';
	require 'PHPMailer/src/SMTP.php';
	 
	
	// Instantiation and passing `true` enables exceptions
	$mail = new PHPMailer(true);
	
	try {
		//Server settings
		$mail->SMTPDebug = 0;                      // Enable verbose debug output
		$mail->isSMTP();                                            // Send using SMTP
		$mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
		$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
		$mail->Username   = 'infomail.sysg@gmail.com';                     // SMTP username
		$mail->Password   = 'sysgpass12345';                               // SMTP password
		$mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
		$mail->Port       = 587;                                    // TCP port to connect to
	
		//Recipients
		$mail->setFrom($from, $sender_name);
		$mail->addAddress($to, 'Admin');     // Add a recipient
		//$mail->addAddress('ellen@example.com');               // Name is optional
		//$mail->addReplyTo('info@example.com', 'Information');
		//$mail->addCC('cc@example.com');
		//$mail->addBCC('bcc@example.com');
	
		// Attachments
		//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
		//	$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
	
		// Content
		$mail->isHTML(true);                                  // Set email format to HTML
		$mail->Subject = 'Message From SysGSoft Website';
        $mail->Body    = $message;
		//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        if($response-> success)
        {
            $mail->send();
		    header("Location: index.html#SendEmail");
            echo "Message Sent Successfully";	
        }
        else{
            echo "Invalid Captcha, Please Try Again";	
        }
		
	} catch (Exception $e) {
		echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}


?>





