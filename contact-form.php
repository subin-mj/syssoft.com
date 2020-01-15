<?php 
                    use PHPMailer\PHPMailer\PHPMailer;
                    use PHPMailer\PHPMailer\Exception;
                    require 'PHPMailer/src/Exception.php';
                    require 'PHPMailer/src/PHPMailer.php';
                    require 'PHPMailer/src/SMTP.php';
                    // Instantiation and passing `true` enables exceptions
                    $mail = new PHPMailer(true);
                    if(isset($_POST['email'])) {
                        $to = "subin@sysgsoft.com";
                        $subject="Message From SysGSoft Website";
                        $sender_name = $_POST['name'];	
                        $from = $_POST['email'];    
                        $phone = $_POST['phone'];    
                        $msg = $_POST['message'];  
                        $message ="------Sender Details------\n\n";
                        $message .="Name: ".$sender_name."\n";
                        $message .="Phone No: ".$phone."\n";
                        $message .="Email: ".$from."\n";
                        $message .="Message: ".$msg."\n";	
                    
                        $headers = "From:".$sender_name."<" . $from.">";
                        
                        $secretkey="6LcyKc8UAAAAAE2rqG8KYO3h2JEQ0UV5WIMLT9YV";
                        $responsekey=$_POST['g-recaptcha-response'];
                        $UserIp = $_SERVER['REMOTE_ADDR'];
                        $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretkey&response=$responsekey&remoteip=$UserIp";
                    
                        $response= file_get_contents($url);
                        $response= json_decode($response);
                    
                        if($response-> success)
                        {
                            mail($to,$subject,$message,$headers); 
                            echo "Message Sent Successfully";	
                        }
                        else{
                            echo "<span>Invalid Captcha, Please Try Again </span>";	
                        }
                    }	
                                  
?>