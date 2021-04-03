<?php
include "db.php";
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
$id = $_GET['id'];
$id = mysqli_real_escape_string($connection, $id);
$publish_note = mysqli_query($connection, "UPDATE notes SET Status=7 WHERE ID=$id");

if ($publish_note){
    header('Location:dashboard.php');
$query="SELECT SellerID,Note_Title FROM notes where ID=$id";
	$result= mysqli_query($connection, $query);
	while($row=mysqli_fetch_assoc($result)){
		$sellerid=$row['SellerID'];
		$title=$row['Note_Title'];
		
	}
	$query="SELECT FirstName, LastName, EmailID FROM users where ID=$sellerid";
	$result=mysqli_query($connection,$query);
	while($row=mysqli_fetch_array($result)){	  
	$email=$row['EmailID'];
		$fname=$row['FirstName'];
		$lname=$row['LastName'];
	
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
            $mail->setFrom($email, $fname);

            $mail->addAddress('trainingm08@gmail.com ', 'NotesMarketPlace');
            $mail->addReplyTo($email, $fname);

            $mail->IsHTML(true);
            $mail->Subject = "$fname $lname sent his note for review ";
            $mail->Body = "Hello Admins,  <br><br>
 
We want to inform you that, $fname $lname sent his note  <br>$title for review. Please look at the notes and take required actions.   
 <br><br>
Regards,  Notes Marketplace ";
            $mail->AltBody = '';
            $mail->send();
            $mail_sent = true;
        } catch (Exception $e) {
            echo "Error in sending email. Mailer Error: {$mail->ErrorInfo}";
        }
	
		  }	  
 else {
   echo "please try again";
}