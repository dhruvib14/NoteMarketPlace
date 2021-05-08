<?php
include "db.php";

//boolean for proper Password validation 
$upper_psd_check = true;
$lower_psd_check = true;
$number_psd_check = true;
$length_check = true;
$null_psd_check=true;
$old_password_match= false;
$password_match=false;
session_start();
if(isset($_SESSION["useremail"])){
  

if(isset($_POST['submit'])){
echo "submit pressed"; 


$email=$_SESSION["useremail"];

$oldpassword=$_POST['oldpsd'];
$newpassword=$_POST['newpsd'];
$confirmpassword=$_POST['confirmpsd'];
$oldpsd=md5($oldpassword);
$newpsd=md5($newpassword);
$query="SELECT * FROM users WHERE EmailID= '$email' ";
$result=mysqli_query($connection, $query);
if(!$result){
  echo mysqli_error($connection);
}
while($row=mysqli_fetch_array($result)){
$id=$row['ID'];
$password=$row['Password'];
}

if($password==$oldpsd){
  $old_password_match= true;
}


    $upper_psd = preg_match('@[A-Z]@', $newpassword);
    if (!$upper_psd)
        $upper_psd_check = false;

    $lower_psd = preg_match('@[a-z]@', $newpassword);
    if (!$lower_psd)
        $lower_psd_check = false;

    $number_check = preg_match('@[0-9]@', $newpassword);
    if (!$number_check)
        $number_psd_check = false;

    if (strlen($newpassword) < 6 && strlen($newpassword) < 24) {
          $length_check = false;
      }
    $null_check=preg_match('@ @',$newpassword);
    if($null_check)
    $null_psd_check=false;
    if($newpassword==$confirmpassword){
      $password_match=true;
    }
    

if($newpassword==$confirmpassword&&$old_password_match &&$upper_psd_check &&$lower_psd_check&&$number_psd_check&&$length_check&&$null_psd_check){
$query="UPDATE users SET Password='$newpsd' WHERE EmailID='$email'";
$result=mysqli_query($connection,$query);
if($result){
  echo "updated";
  echo '<script type="text/javascript"> alert("password has changed successfully")</script>';
	(header("Location:login1.php"));
}

}
else
{echo "password doesn't match";}


}
}
else
(header("Location:login1.php"));

?>



<!DOCTYPE html>
<html lang="en">


<head>
   
   <!--meta-->
   <meta http-equiv="X-UA-Compatible" content="IE=edge" />

   <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0 ,user-scalable=no">

    <title>Notes Marketplace </title>
    <!-- Favicon -->
	<link rel="shortcut icon" href="images/images/favicon.ico">
    <!--open sans font-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
     <!--font-awesome-->
     <link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">
     <!--bootstrap-->
     <link  rel="stylesheet" href="css/bootstrap/bootstrap.min.4.5.css">
     <!--css-->
     <link rel="stylesheet"  href="css/style.css">
       <!--responsive css-->
     <link rel="stylesheet"  href="css/responsive.css">
</head>


<body>
 <!--change-password page-->
 <div id="change-password-bg">
  <section id="change-password">
    
     <div class="container">
     
      <div class="row text-center">
            <div class="col-md-12">
          <img class="main-logo img-responsive " src="images/images/top-logo.png"></div></div>
      <div id="change-password-box"><div  class="row"><div class="col-md-12">
       <h3 > Change Password</h3>
      <h6>Enter your new password to change your password</h6>
      <form id="change-password-form" action="change-password.php" method="post">
  
  <div class="form-group">
    <label id="OldPassword1" for="exampleInputPassword1"> Old Password</label>
   
    <input type="password" class="form-control passwords" id="oldpassword" name="oldpsd"  placeholder="Enter your password" >
    <div class="eye"><img src="images/images/eye.png" alt="eye" onclick="Toggle1()"></div></div> 
<?php if(!$old_password_match){
  echo "<h5 style='color: red; padding-bottom:20px';>please enter the right old password</h5>";
}?>
  <div class="form-group">
    <label id="newpassword1" for="exampleInputPassword1"> New Password</label>
   
    <input type="password" class="form-control passwords" id="newpassword" name="newpsd" placeholder="Enter your new password" >
    <div class="eye"><img src="images/images/eye.png" alt="eye" onclick="Toggle2()"></div></div> 
    <?php if(!$length_check || !$lower_psd_check || !$number_psd_check || !$upper_psd_check || !$null_psd_check){
      echo "<h5 style='color: red; padding-bottom:20px';>please atleast 6 character,one capital letter, one small character, one special charater as a password</h5>";
    }?>
    <div class="form-group">
    <label id="confirmpassword1" for="InputPassword1"> Confirm Password</label>
   
    <input type="password" class="form-control passwords" id="confirmpassword" name="confirmpsd" placeholder="Enter your confirm password" >
    <div class="eye"><img src="images/images/eye.png" alt="eye" onclick="Toggle3()"></div></div> 
    <div class="password-match">
    <?php
    if(!$password_match)
    echo "<h5 style='color: red';>Password and confirm password should be match</h5>";
    ?>
    
    
    </div>
  <button type="submit" class="btn btn-primary" name="submit">submit</button>
  
		  </form></div>
</div></div>
                        </div>
     </section></div>
    !--jquery-->
  <script src="js/jquery.js"></script> 
  <!--bootstrap-->
    <script src="js/bootstrap/bootstrap.min.js"></script>
  
  <!--js-->
  <script src="js/script.js"></script></body></html>