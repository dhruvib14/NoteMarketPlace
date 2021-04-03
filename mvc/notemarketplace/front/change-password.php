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
      <form id="change-password-form">
  
  <div class="form-group">
    <label id="OldPassword1" for="exampleInputPassword1"> Old Password</label>
   
    <input type="password" class="form-control passwords" id="oldpassword" placeholder="Enter your password" >
    <div class="eye"><img src="images/images/eye.png" alt="eye" onclick="Toggle1()"></div></div> 

  <div class="form-group">
    <label id="newpassword1" for="exampleInputPassword1"> New Password</label>
   
    <input type="password" class="form-control passwords" id="newpassword" placeholder="Enter your new password" >
    <div class="eye"><img src="images/images/eye.png" alt="eye" onclick="Toggle2()"></div></div> 
    
    <div class="form-group">
    <label id="confirmpassword1" for="InputPassword1"> Confirm Password</label>
   
    <input type="password" class="form-control passwords" id="confirmpassword" placeholder="Enter your confirm password" >
    <div class="eye"><img src="images/images/eye.png" alt="eye" onclick="Toggle3()"></div></div> 
  <button type="submit" class="btn btn-primary"><a href="login.html">submit</a></button>
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