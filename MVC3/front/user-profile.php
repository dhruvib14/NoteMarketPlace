<?php 
include "db.php";

$exist=0;
session_start();
$number='/^[0-9]{10}$/';
$name_pattern = '/^[a-zA-Z ]{3,99}$/';
$fname_check = true;
$lname_check = true;
$number_check=true;
if(isset($_SESSION['useremail'])){
	$email=$_SESSION['useremail'];
	$query="SELECT * FROM users WHERE EmailID='$email'";
    $result=mysqli_query($connection,$query);
	while($row=mysqli_fetch_assoc($result)){
	$fname=$row['FirstName'];
	$lname=$row['LastName'];
	}
}
else{
	header("Location:login1.php");
}

$id=$_SESSION['user_id'];
$query="SELECT * FROM users_details WHERE UserID='$id'";
$result=mysqli_query($connection,$query);
if(!$result){
	echo mysqli_error($connection);
}
$exist=mysqli_num_rows($result);

while($row=mysqli_fetch_assoc($result)){
    $gender_id=$row['Gender'];
    $country_id=$row['Phone_No_Country_Code'];
    $country_ID=$row['Country'];
    $birthdate_1=$row['Dob'];
	$address_1=$row['Address_1'];
	$address_2=$row['Address_2'];
	$city=$row['City'];
	$college=$row['College'];
	$phone_number=$row['Phone_No'];
	$state=$row['State'];
	$zipcode=$row['Zip_Code'];
	$university=$row['University'];
	$path=$row['Profile_Pic'];
	
}



if($exist>0){
	$query="SELECT * FROM country WHERE Country_Code=$country_id";
	$result=mysqli_query($connection,$query);
	while($row=mysqli_fetch_assoc($result)){
    $code=$row['Country_Code']; 	}	
$query="SELECT * FROM referencedata WHERE ID=$gender_id";
	$result=mysqli_query($connection,$query);
	while($row=mysqli_fetch_assoc($result)){
    $gender=$row['Value']; 		
	}
	$query="SELECT * FROM country WHERE ID=$country_ID";
	$result=mysqli_query($connection,$query);
	while($row=mysqli_fetch_assoc($result)){
    $country=$row['Country_Name']; 		
	}	
}


if(isset($_POST['submit'])){
	$fname=$_POST['fname'];
	$lname=$_POST['lname'];
	$birthdate=$_POST['birthdate'];
	$gender=$_POST['gender'];
	$code=$_POST['code'];
	$phone_number=$_POST['phone_number'];
	$address_1=$_POST['address_1'];
	$address_2=$_POST['address_2'];
	$city=$_POST['city'];
	$state=$_POST['state'];
	$country=$_POST['country'];
	$zipcode=$_POST['zipcode'];
	$university=$_POST['university'];
	$college=$_POST['college'];
	$default_display_pic = "../members/default/reviewer1.png";
	$check_phonenumber = preg_match($number, $phone_number);
	if(!$check_phonenumber){
		$number_check=false;
	}
	$check_fname = preg_match($name_pattern, $fname);
    if (!$check_fname) {
        $fname_check = false;
    }

    $check_lname = preg_match($name_pattern, $lname);
    if (!$check_lname) {
        $lname_check = false;
    }

    if($number_check &&$lname_check&&$fname_check){
    if($exist==0){
		
	$query="INSERT INTO users_details(UserID, Dob,Address_1,Address_2,City,College,Country,Profile_Pic,Gender,Phone_No,Phone_No_Country_Code,State,University,Zip_Code,CreatedDate,CreatedBy,IsActive) 
	VALUES ('$id','$birthdate','$address_1','$address_2','$city','$college','$country','$default_display_pic','$gender','$phone_number','$code','$state','$university','$zipcode',NOW(),'$id',1)
";
    $user_profile_id = mysqli_insert_id($connection);
	
    $profile_pic=$_FILES["upload-profile"];
    $filename=$profile_pic['name'];
    $filetmp=$profile_pic['tmp_name'];
	$extension=explode('.',$filename);
	$filecheck=strtolower(end($extension));
	$fileextstored=array('jpg','png','jpeg');
	
		if (in_array($filecheck, $fileextstored)) {
            if (!is_dir("../members/")) {
                mkdir('../members/');
            }
            if (!is_dir("../members/" . $id)) {
                mkdir("../members/" . $id);
            }
            
            $destinationfile = '../members/' . $id .'/' . "DP_" . time() . '.' . $filecheck;
            move_uploaded_file($filetmp, $destinationfile);
            $query_pic = "UPDATE users_details SET Profile_Pic='$destinationfile' WHERE ID=$user_profile_id";
            $result_pic = mysqli_query($connection, $query_pic);
        } else {
            echo "upload failed".mysqli_error($connection);
			$profile_validation=false;
        }
$result=mysqli_query($connection,$query);
if (!$result) {
	echo mysqli_error($connection);
}else{
header("Location:search-notes.php");
}}
else{
	if(empty($birthdate)){
		$birthdate=$birthdate_1;
	}
	$query="UPDATE users_details SET Dob='$birthdate',Address_1='$address_1',Address_2='$address_2',City='$city',College='$college',Country='$country',Gender='$gender',Phone_No='$phone_number',Phone_No_Country_Code='$code',State='$state',University='$university',Zip_Code='$zipcode',ModifiedDate=NOW(),CreatedBy='$id'
	 WHERE UserID='$id'";
	 $result=mysqli_query($connection,$query);
	 if (!$result) {
		echo mysqli_error($connection);
	}else{
	header("Location:search-notes.php");
	}

	$profile_pic=$_FILES['upload-profile'];	
$filename=$profile_pic['name'];
$filetmp=$profile_pic['tmp_name'];
$extension=explode('.',$filename);
$filecheck=strtolower(end($extension));
$fileextstored=array('jpg','png','jpeg');

if (in_array($filecheck, $fileextstored)) {
	if (!is_dir("../members/")) {
		mkdir('../members/');
	}
	if (!is_dir("../members/" . $id)) {
		mkdir("../members/" . $id);
	}
	
	$destinationfile = '../members/' . $id .'/' . "DP_" . time() . '.' . $filecheck;
	move_uploaded_file($filetmp, $destinationfile);
	unlink($path);
	$query_pic = "UPDATE users_details SET Profile_Pic='$destinationfile' WHERE UserID=$id";
	$result_pic = mysqli_query($connection, $query_pic);
} else {
	echo "upload failed".mysqli_error($connection);
	$profile_validation=false;
}}
}}

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
	<link rel="stylesheet" href="css/bootstrap/bootstrap.min.4.5.css">
	<!--css-->
	<link rel="stylesheet" href="css/style.css">
	<!--responsive css-->
	<link rel="stylesheet" href="css/responsive.css">
</head>

<body>
	<!--header-->
	<header>
		<nav id="navuser" class="navbar nav-notes navbar-fixed-top navbar-expand-lg navbar-light  ">
			<div class="container-fluid ">
				<div class="site-nav-wrapper">
					<div class="navbar-header navbar-brand">
						<a href="home.php"><img src="images/images/logo.png"> </a><span id="mobile-nav-open-btn">
							&#9776;</span>
					</div>
					<!--main menu-->
					<div class="collapse navbar-collapse">

						<ul class="navbar-nav ">
							<li class="nav-item"><a class="smooth-scroll nav-link " href="search-notes.php">Search Notes</a>
							<li class="nav-item"><a class="smooth-scroll nav-link" href="dashboard.php">Sell Your Notes</a></li>
							<?php if(isset($_SESSION['useremail'])){
								echo "<li class='nav-item'><a class='smooth-scroll nav-link' href='buyer-request.php'>Buyer Request</a></li>";
							}
							?>
							<li class="nav-item"><a class="smooth-scroll nav-link" href="faq-page.php">FAQ</a></li>
							<li class="nav-item"><a class="smooth-scroll nav-link " href="contactus.php">Contact Us</a></li>
						
							<?php if(isset($_SESSION['useremail'])){
								$useremail=$_SESSION['useremail'];
								
                                $query_id=mysqli_query($connection,"SELECT ID FROM users WHERE EmailID='$useremail'");
								while($row=mysqli_fetch_assoc($query_id)){
									$userid=$row['ID'];
								}
								$query_profile=mysqli_query($connection,"SELECT Profile_Pic FROM users_details WHERE UserID='$userid'");
								if(!$query_profile){
									echo mysqli_error($connection);
								}
								$count=mysqli_num_rows($query_profile);
							
								while($row=mysqli_fetch_assoc($query_profile)){
									$profile_pic=$row['Profile_Pic'];
								}
							
						echo "	<li class='nav-item dropdown'><a class='smooth-scroll nav-link pic-nav ' href='#' id='navbardrop' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'><img src='$profile_pic' alt='profile'></a>
								<div class='dropdown-menu' aria-labelledby='dropdownMenuLink'>
									<a class='dropdown-item active' href='user-profile.php'>My Profile</a>
									<a class='dropdown-item' href='mydownloads.php'>My Downloads</a>
									<a class='dropdown-item' href='sold-notes.php'>My Sold Notes</a>
									<a class='dropdown-item' href='myrejectednotes.php'>My Rejected Notes</a>
									<a class='dropdown-item' href='change-password.php'>Change Password</a>
									<a class='dropdown-item dd-logout' onclick='javascript:logout($(this));return false;' href='logout.php'><p>Logout</p></a>
								</div>
							</li>";}
?>
<?php if(isset($_SESSION['useremail'])){echo "
							<li class='nav-item'><a class='smooth-scroll nav-link' onclick='javascript:logout($(this));return false;' id='button-nav' href='logout.php'>
									<p>Logout</p>
								</a></li>";}
								else
								{echo "
									<li class='nav-item'><a class='smooth-scroll nav-link' id='button-nav' href='login1.php'>
											<p>Login</p>
										</a></li>";}?>
						</ul>
					</div>
					<!--mobile menu-->
					<div id="mobile-nav">
						<div class="navbar-header">
							<a href="home.php"><img src="images/images/logo.png"></a>
							<!--mobile menu close button-->
							<span id="mobile-nav-close-btn">&times;</span>
						</div>

						<div id="mobile-nav-content">
							<ul class="navbar-nav">
							<li class="nav-item"><a class="smooth-scroll nav-link" href="search-notes.php">Search Notes</a>
							<li class="nav-item"><a class="smooth-scroll nav-link" href="dashboard.php">Sell Your Notes</a></li>
							<?php if(isset($_SESSION['useremail'])){
								echo "<li class='nav-item'><a class='smooth-scroll nav-link' href='buyer-request.php'>Buyer Request</a></li>";
							}
							?>
							<li class="nav-item"><a class="smooth-scroll nav-link" href="faq-page.php">FAQ</a></li>
							<li class="nav-item"><a class="smooth-scroll nav-link " href="contactus.php">Contact Us</a></li>
						
							<?php if(isset($_SESSION['useremail'])){
								$useremail=$_SESSION['useremail'];
								
                                $query_id=mysqli_query($connection,"SELECT ID FROM users WHERE EmailID='$useremail'");
								while($row=mysqli_fetch_assoc($query_id)){
									$userid=$row['ID'];
								}
								$query_profile=mysqli_query($connection,"SELECT Profile_Pic FROM users_details WHERE UserID='$userid'");
								if(!$query_profile){
									echo mysqli_error($connection);
								}
								$count=mysqli_num_rows($query_profile);
							
								while($row=mysqli_fetch_assoc($query_profile)){
									$profile_pic=$row['Profile_Pic'];
								}
						echo "	<li class='nav-item dropdown'><a class='smooth-scroll nav-link pic-nav ' href='#' id='navbardrop' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'><img src='$profile_pic'></a>
								<div class='dropdown-menu' aria-labelledby='dropdownMenuLink'>
									<a class='dropdown-item active' href='user-profile.php'>My Profile</a>
									<a class='dropdown-item' href='mydownloads.php'>My Downloads</a>
									<a class='dropdown-item' href='sold-notes.php'>My Sold Notes</a>
									<a class='dropdown-item' href='myrejectednotes.php'>My Rejected Notes</a>
									<a class='dropdown-item' href='change-password.php'>Change Password</a>
									<a class='dropdown-item dd-logout' onclick='javascript:logout($(this));return false;' href='logout.php'><p>Logout</p></a>
								</div>
							</li>";}
?>
<?php if(isset($_SESSION['useremail'])){echo "
							<li class='nav-item'><a class='smooth-scroll nav-link' onclick='javascript:logout($(this));return false;' id='button-nav' href='logout.php'>
									<p>Logout</p>
								</a></li>";}
								else
								{echo "
									<li class='nav-item'><a class='smooth-scroll nav-link' id='button-nav' href='login1.php'>
											<p>Login</p>
										</a></li>";}?>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</nav>

	</header>

	<!--header ends-->
	<section id="user-profile">

		<div class="row"><div class="col-12">
		<div class="logo ">
		
		<img src="images/images/banner-home.jpg">
		<h3 id="user-profile-logo" class="text-center">User Profile</h3>
								</div>
		</div></div>
			<div class="container">
				<h3> Basic Profile Details</h3>
				<form id="basic-profile-form" action="user-profile.php" method="post" enctype="multipart/form-data">
					<div class="form-group row">
						<div class="col-md-6 col-sm-12">
							<label id="fname" class="form-info" for="exampleInputName">First Name *</label>
							<input type="name" class="form-control input-field" name="fname" value="<?php echo $fname;?>" placeholder="Your First Name" required>
							<?php//check firstname
								if(!$fname_check){
echo "<h5 style='color:red'; style='margin-left:20px';> please enter a alphabetic vaalue between 4 to 100</h5>";
								}?>
						</div>
						
						<div class="form-group col-md-6 col-sm-12 col-xs-12">
							<label id="lname" for="exampleInputName ">Last Name *</label>
							<input type="name" class="form-control input-field" name="lname" value="<?php echo $lname;?>" placeholder="Your Last Name" required>
							<?php
								if(!$lname_check){
echo "<h5 style='color:red'; style='margin-left:20px';>please enter a alphabetic vaalue between 4 to 100</h5>";
								}?>
						</div>
						
					</div>
					<div class="form-group row">
						<div class="col-md-6 col-sm-12">
							<label id="email" for="exampleInputEmail1 ">Email </label>
							<input type="email" class="form-control input-field" name="email" aria-describedby="emailHelp" value="<?php echo $email;?>" required readonly>
						</div>
						<div class="col-md-6 col-sm-12">
							<label for="birthday">Date Of Birth </label>
							<input type="date" class="form-control input-field" id="birthdate" name="birthdate" value="<?php  if($exist>0) { echo date($birthdate); }?>" placeholder="Enter Your Date Of Birth">
						</div>

					</div>
					<div class="form-group row">
						<div class="col-md-6 col-sm-12">
							<label id="gender" for="gender">Gender </label>
							<select class="form-control options-arrow-down" name="gender">
							<?php 
	if($exist!=0){
		echo "<option selected value='$gender_id'>$gender</option>";
		$query = "SELECT ID ,Value FROM referencedata WHERE ID=1 OR ID=2";
                                        $result = mysqli_query($connection, $query);

                                        while ($raw = mysqli_fetch_assoc($result)) {
                                            $gender = $raw['Value'];
										
                                            $gender_id = $raw['ID'];
                                            echo "<option value='$gender_id'>$gender</option>";}
	}
								   else{
									$query = "SELECT ID ,Value FROM referencedata WHERE ID=1 OR ID=2";
                                        $result = mysqli_query($connection, $query);
                                        echo "<option value='' selected disabled>Select your Gender</option>";

                                        while ($raw = mysqli_fetch_assoc($result)) {
                                            $gender = $raw['Value'];
											
                                            $gender_id = $raw['ID'];
                                            echo "<option value='$gender_id'>$gender</option>";}}?>
									
								</select>
							</select>
						</div>
						<div class="col-md-6 col-sm-12">
							<label for="phone-number">Phone Number </label>
							<div class="row">
								<div class="col-md-4 col-sm-4 col-4">
									<select class="form-control options-arrow-down" name="code">
									<?php 
	if($exist!=0){
		echo "<option selected value='$country_id'>$code</option>";
		$query = "SELECT Country_Code,ID FROM country";
                                        $result = mysqli_query($connection, $query);

                                        while ($raw = mysqli_fetch_assoc($result)) {
                                            $country_id = $raw['ID'];
											$code = $raw['Country_Code'];
                                            echo "<option value='$country_id'>$code</option>";}
	}
								   else{
									$query = "SELECT Country_Code,ID FROM country";
                                        $result = mysqli_query($connection, $query);
                                        echo "<option value='' selected disabled>Select your country code</option>";

                                        while ($raw = mysqli_fetch_assoc($result)) {
                                            $country_id = $raw['ID'];
											$code = $raw['Country_Code'];
                                            echo "<option value='$country_id'>$code</option>";}}?>
									</select>
								</div>
								<div class="col-md-8 col-sm-8 col-8">
									<input type="text" name="phone_number" class="form-control input-field" value="<?php if($exist>0){ echo $phone_number;} ?>" id="phone-number" placeholder="Enter Your Phone Number">
								</div><?php
								if(!$number_check){
echo "<h5 style='color:red'; style='margin-left:20px';>please enter a 10 digit phone number</h5>";
								}?>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-md-6 col-sm-12">
							<label for="profile">Profile Picture </label>
							<div class="user-profile-photo-uploader">
								<label for="image-uploader"><img src="images/images/upload-file.png" alt="upload your profile picture"></label>
								<input type="file" id="image-uploader" class="form-control input-field" placeholder="Upload a Picture" name="upload-profile">
							</div>
						</div>
					</div>

		<!--address details-->

		<div class="row">
			<div class="container">
				<h3> Address Deatils </h3>
				<div id="address-detail-form">
					<div class="form-group row">
						<div class="col-md-6 col-sm-12">
							<label class="add" for="exampleInputName">Address Line 1 *</label>
							<input type="address" class="form-control input-field" name="address_1" value="<?php if($exist>0){ echo $address_1;} ?>" placeholder="Enter your Address" required>

						</div>
						<div class="col-md-6 col-sm-12"> <label class="add" for="exampleInputName">Address Line 2 </label>
							<input type="address" class="form-control input-field" name="address_2" value="<?php if($exist>0){ echo $address_2;} ?>" placeholder="Enter your Address">
						</div>
					</div>

					<div class="form-group row">
						<div class="col-md-6 col-sm-12">
							<label class="add" for="city">City *</label>
							<input type="address" class="form-control input-field" name="city" value="<?php if($exist>0){ echo $city;} ?>" placeholder="Enter your City" required>

						</div>
						<div class="col-md-6 col-sm-12">
							<label class="add" for="state">State *</label>
							<input type="address" class="form-control input-field" name="state" value="<?php if($exist>0){ echo $state;} ?>" placeholder="Enter your state" required>
						</div>
					</div>

					<div class="form-group row">
						<div class="col-md-6 col-sm-12">
							<label class="add" for="zipcode">ZipCode *</label>
							<input type="address" class="form-control input-field" name="zipcode" value="<?php if($exist>0){ echo $zipcode;} ?>" placeholder="Enter your ZipCode" required>

						</div>
						<div class="col-md-6 col-sm-12">
							<label class="add" for="country">Country *</label>
							<select class="form-control options-arrow-down" name="country">
							<?php 
	if($exist!=0){
		echo "<option selected value='$country_ID'>$country</option>";
		$query = "SELECT ID,Country_Name FROM country";
                                        $result = mysqli_query($connection, $query);

                                        while ($raw = mysqli_fetch_assoc($result)) {
                                            $country_ID = $raw['ID'];
                                            $country = $raw['Country_Name'];
                                            echo "<option value='$country_ID'>$country</option>";}
	}
								   else{
									$query = "SELECT ID,Country_Name FROM country";
                                        $result = mysqli_query($connection, $query);
                                        echo "<option value='' selected disabled>Select your country</option>";

                                        while ($raw = mysqli_fetch_assoc($result)) {
                                            $country_ID = $raw['ID'];
                                            $country = $raw['Country_Name'];
                                            echo "<option value='$country_ID'>$country</option>";}}?>
							</select>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!--university and college information details-->

		<div class="row">
			<div class="container">
				<h3> University And College Information Deatils </h3>
				<div id="university-detail-form">
					<div class="form-group row">
						<div class="col-md-6 col-sm-12">
							<label class="college" for="exampleInputName">University </label>
							<input type="text" class="form-control input-field" name="university" value="<?php if($exist>0){ echo $university;} ?>" placeholder="Enter your university">

						</div>
						<div class="col-md-6 col-sm-12 col-12"> <label class="college" for="exampleInputName">College </label>
							<input type="text" class="form-control input-field" value="<?php if($exist>0){ echo $college;} ?>" placeholder="Enter your College" name="college">
						</div>
					</div>

				</div>
			</div>
		</div>
		<div class="row">
			<div class="container">
				<button type="submit" id="user-submit" class="btn btn-primary" name="submit">Submit</button>
			</div>
		</div>
		</form>
			</div>

	</section>
	<div class="footer">
		<hr>
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-sm-7">
					<p>Copyright <span>&#169;</span> Tatvasoft All rights reserved.</p>
				</div>
				<div class="col-md-6 col-sm-5 social-icons">
					<ul class="social-list">

						<li> <a href="#"><i class="fa fa-linkedin"> </i></a></li>
						<li> <a href="#"><i class="fa fa-twitter"> </i></a></li>
						<li> <a href="#"><i class="fa fa-facebook"> </i></a></li>

					</ul>
				</div>
			</div>
		</div>
	</div>
	<!--jquery-->
	<script src="js/jquery.js"></script>
	<!--bootstrap-->
	<script src="js/bootstrap/bootstrap.min.4.5.js"></script>

	<!--js-->
	<script src="js/script.js"></script>
</body>

</html>