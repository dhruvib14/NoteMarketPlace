<?php
include "db.php";
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
$id = $_GET['id'];
$id = mysqli_real_escape_string($connection, $id);
$publish_note = mysqli_query($connection, "UPDATE downloads SET IsSellerHasAllowedDownload=1 WHERE ID=$id");

if ($publish_note){
    
$query="SELECT SellerID,Note_Title FROM notes where ID=$id";
	$result= mysqli_query($connection, $query);
	while($row=mysqli_fetch_assoc($result)){
		$sellerid=$row['SellerID'];
		$title=$row['Note_Title'];
	}
	$query="SELECT FirstName, LastName, EmailID FROM users where ID=$sellerid";
	$result=mysqli_query($connection,$query);
	while($row=mysqli_fetch_array($result)){	  
		$sellername=$row['FirstName'];
	}
	
	$query="SELECT DownloaderID FROM downloads WHERE ID=$id";
	$result= mysqli_query($connection, $query);
	while($row=mysqli_fetch_assoc($result)){
	$downloaderid=$row['DownloaderID'];
	}
	
	$query="SELECT FirstName, LastName, EmailID FROM users where ID=$downloaderid";
	$result=mysqli_query($connection,$query);
	while($row=mysqli_fetch_array($result)){
		
		$fname=$row['FirstName'];
		$email=$row['EmailID'];
    echo $email;
	}
	$mail_sent=false;


	
	require 'PHPMailer/Exception.php';
        require 'PHPMailer/PHPMailer.php';
        require 'PHPMailer/SMTP.php';

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

             $config_email = 'trainingm08@gmail.com ';
            $mail->Username = $config_email;
            $mail->Password = 'abc@08(mail)';

            // Sender and recipient settings
            $mail->setFrom($config_email, $fname);

            $mail->addAddress($email);
            $mail->addReplyTo($email, $fname);

            $mail->IsHTML(true);
            $mail->Subject = "$fname  Allows you to download a note";
            $mail->Body = "Hello Admins,  $fname
 <br><br>
We would like to inform you that, $sellername Allows you to download a note. Please login and see My Download tabs to download particular note. 
  <br><br>
Regards,  Notes Marketplace";
								
            $mail->AltBody = '';
            $mail->send();
            $mail_sent = true;
            header('Location:dashboard.php');    } catch (Exception $e) {
            echo "Error in sending email. Mailer Error: {$mail->ErrorInfo}";
        }
	
		  }	  
 else {
   echo "please try again";
}