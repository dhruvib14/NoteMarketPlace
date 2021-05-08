<?php
include "db.php";
session_start();
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

if (isset($_GET['id']))
    $noteid = $_GET['id'];
else $noteid = 6;
$mail_sent = false;
$login = true;

if (isset($_SESSION['useremail'])) {
    $email = $_SESSION['useremail'];
    $buyergetter = mysqli_query($connection, "SELECT ID,LastName,FirstName FROM users WHERE EmailID='$email'");
    while ($row = mysqli_fetch_assoc($buyergetter)) {

        //buyer info getter
        $buyerid = $row['ID'];
        $full_name_buyer = $row['FirstName'] . " " . $row['LastName'];

        //seller info getter
        $seller_getter = mysqli_query($connection, "SELECT SellerID,Price,Note_Title,Category,Is_Paid FROM notes WHERE ID=$noteid");
        while ($row = mysqli_fetch_assoc($seller_getter)) {
            $sellerid = $row['SellerID'];
			echo $sellerid;
            $note_price = $row['Price'];
            $note_title = $row['Note_Title'];
            $category_id = $row['Category'];
			$sell_type=$row['Is_Paid'];
 
    $category = mysqli_query($connection, "SELECT Category_name FROM category WHERE ID='$category_id'");
    while ($row = mysqli_fetch_assoc($category)) {
        $category_name = $row['Category_name'];
    }}}
    $download_entry_checker = mysqli_query($connection, "SELECT ID FROM downloads WHERE NoteID=$noteid AND DownloaderID=$buyerid");
	


if (isset($_POST['single_download'])) {

    $attactments_getter = mysqli_query($connection, "SELECT Path,File_Name,Note_ID FROM notesattachment WHERE Note_ID=$noteid");
   if($attachments_getter){
	echo '<script type="text/javascript"> alert("successfully not")</script>';
   }
   else {
	echo '<script type="text/javascript"> alert("successfull")</script>';
   }
	while ($row = mysqli_fetch_array($attactments_getter)) {
        $filepath = $row['Path'];
    }
    $file_getter = mysqli_query($connection, "SELECT Note_Title,Category FROM notes WHERE ID=$noteid");
    while ($row = mysqli_fetch_array($file_getter)) {
        $title = $row['Note_Title'];
		$category=$row['Category'];
    }
    header('Cache-Control: public');
    header('Content-Description: File Transfer');
    header('Content-Disposition: attachment; filename=' . $title. '.pdf');
    header('Content-Type: application/pdf');
    header('Content-Transfer-Encoding:binary');
    @readfile($filepath);

    $download_entry_checker = mysqli_query($connection, "SELECT ID FROM downloads WHERE NoteID=$noteid AND DownloaderID=$buyerid");

	$download_entry_number = mysqli_num_rows($download_entry_checker);
    if ($download_entry_number == 0 && $buyerid != $sellerid) {
    

        //insert query
        $attact_path_getter = mysqli_query($connection, "SELECT Path FROM notesattachment WHERE Note_ID=$noteid");

        while ($row = mysqli_fetch_assoc($attact_path_getter)) {
            $path = $row['Path'];
		
            $download_entry = mysqli_query($connection, "INSERT INTO downloads(NoteID,SellerID,DownloaderID,
                           IsSellerHasAllowedDownload,AttachmentPath,IsAttachmentDownloaded,
                           AttachmentDownloadedDate,IsPaid,PurchasedPrice,NoteTitle,NoteCategory,
                           CreatedDate,CreatedBy,ModifiedDate,ModifiedBy)
                           VALUES($noteid,$sellerid,$buyerid,1,'$path',1,NOW(),5,'$note_price',
                           '$note_title','$category',NOW(),$buyerid,NOW(),$buyerid)");
        

	}
    }
}


if (isset($_POST['download_all'])) {
    $file_getter = mysqli_query($connection, "SELECT Note_Title,Category FROM notes WHERE ID=$noteid");
    while ($row = mysqli_fetch_array($file_getter)) {
        $title = $row['Note_Title'];
		$category=$row['Category'];
    }
    $zipname = $title . '.zip';
    $zip = new ZipArchive;
    $zip->open($zipname, ZipArchive::CREATE);
    $query = mysqli_query($connection, "SELECT Path FROM notesattachment WHERE Note_ID=$noteid");
    while ($row = mysqli_fetch_assoc($query)) {
        $attact_id = $row['Path'];
        $zip->addFile($attact_id);
    }
    $zip->close();
    header('Content-Type: application/zip');
    header('Content-disposition: attachment; filename=' . $zipname);
    header('Content-Length: ' . filesize($zipname));
    readfile($zipname);

    $download_entry_number = mysqli_num_rows($download_entry_checker);
    if ($download_entry_number == 0 && $buyerid != $sellerid) {

        //insert query
        $attact_path_getter = mysqli_query($connection, "SELECT Path FROM notesattachment WHERE Note_ID=$noteid");

        while ($row = mysqli_fetch_assoc($attact_path_getter)) {
            $path = $row['Path'];
            $download_entry = mysqli_query($connection, "INSERT INTO downloads(NoteID,SellerID,DownloaderID,
                           IsSellerHasAllowedDownload,	AttachmentPath,IsAttachmentDownloaded,
                           AttachmentDownloadedDate,IsPaid,PurchasedPrice,NoteTitle,NoteCategory,
                           CreatedDate,CreatedBy,ModifiedDate,ModifiedBy)
                             VALUES($noteid,$sellerid,$buyerid,1,'$path',1,NOW(),5,'$note_price',
                             '$note_title','$category',NOW(),$buyerid,NOW(),$buyerid)");
							 if(!$download_entry){
								 echo mysqli_error($connection);
							 }
        }



    }
}


if (isset($_POST['purchase_yes_box'])) {
    $download_entry_number = mysqli_num_rows($download_entry_checker);
    if ($download_entry_number == 0 && $buyerid != $sellerid) {
        //insert query
        $file_getter = mysqli_query($connection, "SELECT Note_Title,Category FROM notes WHERE ID=$noteid");
    while ($row = mysqli_fetch_array($file_getter)) {
        $title = $row['Note_Title'];
		$category=$row['Category'];
    }
        $attact_path_getter = mysqli_query($connection, "SELECT Path FROM notesattachment WHERE Note_ID=$noteid");

        while ($row = mysqli_fetch_assoc($attact_path_getter)) {
		 $path = $row['Path'];
		 echo $path;
		 $download_entry = mysqli_query($connection, "INSERT INTO downloads(NoteID,SellerID,DownloaderID,
                           IsSellerHasAllowedDownload,	AttachmentPath,IsAttachmentDownloaded,
                           AttachmentDownloadedDate,IsPaid,PurchasedPrice,NoteTitle,NoteCategory,
                           CreatedDate,CreatedBy,ModifiedDate,ModifiedBy)
                             VALUES($noteid,$sellerid,$buyerid,0,'$path',0,NOW(),4,'$note_price',
                             '$note_title','$category',NOW(),$buyerid,NOW(),$buyerid)");
							 if(!$download_entry){
								echo mysqli_error($connection);
							}
		}

        //seller nane getter
        $seller_id_getter = mysqli_query($connection, "SELECT SellerID FROM notes WHERE ID=$noteid");
		if(!$seller_id_getter){
			echo mysqli_error($connection)."notes";
		}
        while ($row = mysqli_fetch_assoc($seller_id_getter))
            $seller_id = $row['SellerID'];
        $seller_name_getter = mysqli_query($connection, "SELECT FirstName,LastName,EmailID FROM users WHERE ID=$seller_id");
		if(!$seller_name_getter){
			echo mysqli_error($connection);
		}
        while ($row = mysqli_fetch_assoc($seller_name_getter)) {
            $full_name_seller = $row['FirstName'] . " " . $row['LastName'];
            $email_seller = $row['EmailID'];
        }

	
        //mail function
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
            $mail->setFrom($config_email, 'NotesMarketPlace');

            $mail->addAddress($email_seller);
            $mail->addReplyTo($config_email, 'NotesMarketPlace');

            $mail->IsHTML(true);
            $mail->Subject = "wants to purchase your notes";

            $mail->Body = "Hello $full_name_seller,<br>
 <br>
           We would like to inform you that, <Buyer name> wants to purchase your notes. Please see Buyer Requests tab and allow download access to Buyer if you have received the payment from him.<br> 
 
<br>
           Regards,<br>  Notes Marketplace ";

            $mail->AltBody = '';

            $mail->send();
            $mail_sent = true;
			?><script>
			('#confirm-purchase-popup').hide();
			('#thankyou-popup').show();
			
			</script><?php
        } catch (Exception $e) {
            echo "Error in sending email. Mailer Error: {$mail->ErrorInfo}";
        } 
    }
}

 } ?>


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
									<a class='dropdown-item' href='user-profile.php'>My Profile</a>
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
						echo "	<li class='nav-item dropdown'><a class='smooth-scroll nav-link pic-nav ' href='#' id='navbardrop' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'><img src='$profile_pic'></a>
								<div class='dropdown-menu' aria-labelledby='dropdownMenuLink'>
									<a class='dropdown-item' href='user-profile.php'>My Profile</a>
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
	<form action="" method="post">
		<!--when allows-->
		<div class="modal fade" id="thankyou-popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">

						<h5 class="modal-title text-center" id="thankyou"><img src="images/images/SUCCESS.png">
							<p>Thank you for Purchasing</p>
						</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<h3>Dear Smith,</h3>
						<p>As this is paid notes -you need to pay to seller rashil Shah offline. We will send him an email that you want to download this note. He may contact you further for payment process.
						<p>

						<p>In case, you have urgency.</p>
						<p>
							Please contact us on +919999999999.</p>
						<p>Once he receives the payment and acknowledge us- selected notes you can see over my downloads tab for download.</p>

						<p>Have a good day.</p>

					</div>

				</div>
			</div>
		</div>

		<!--for  paid notes-->
		<div class="popup-box">
			<div style="margin-top: 200px;" id="confirm-purchase-popup" class="modal fade" tabindex="-1" role="dialog">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
					<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button></div>
						<div style="margin-top: -20px;" class="modal-body">
							<h6 class="blue-font-24">Are you sure you want to download this Paid note? </h6>
							<h6 style="margin-top: 20px;" class="dark-font-22"> Please confirm. </h6>
							<div style="margin-top:15px;">
								<button type="submit" style="margin-right: 30px;"  name="purchase_yes_box" data-toggle='modal'
                                    id="purchase-yes" data-target='#thankyou-popup' onclick="Purchase();"   class="btn btn-primary blue-button-hover-white" data-target='#thankyou-popup'>yes</button>
								<button id="purchase_no_box" class="btn btn-primary">no</button>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
	</form>
	<div id="note-detail">
		<div class="container">
			<div id="note-detail-1">
				<h3>Note Details</h3>
<?php
$query_note_details="SELECT * FROM NOTES WHERE ID=$noteid";
$result_note_details=mysqli_query($connection,$query_note_details);
if(!$result_note_details){
	echo mysqli_error($connection);
}

while($row=mysqli_fetch_assoc($result_note_details)){
	$title=$row['Note_Title'];
	$category_id=$row['Category'];
	$description=$row['Description'];
	$display_picture=$row['Note_Display_Picture'];
$university=$row['University'];
$country_id=$row['Country'];
$course_name=$row['Course'];
$course_Code=$row['Course_Code'];
$professor=$row['Professor_Name'];
$num_of_pages=$row['Note_Pages'];
$approved_date=$row['PublishedDate'];
$notes_preview=$row['NotesPreview'];
	$query_category=mysqli_query($connection,"SELECT Category_name FROM category WHERE ID=$category_id");
	while($row=mysqli_fetch_assoc($query_category)){	
	$category_name=$row['Category_name'];
	}
	$query_country=mysqli_query($connection,"SELECT Country_Name FROM country WHERE ID=$country_id");
	while($row=mysqli_fetch_assoc($query_country)){	
	$country_name=$row['Country_Name'];
	}
	
}

?>
				<div class="row">
					<div class=" col-md-12 col-lg-7 col-sm-12 col-xs-12" id="note-detail-1-left">

						<div class="row">
							<div class=" col-lg-5 col-md-5 col-sm-5 col-sm-5 note-details-img">

								<?php echo "<img src='$display_picture'>";?>
							</div>
							<div class="col-sm-7 col-md-7 col-lg-7">
								<h4><?php echo $title; ?></h4>
								<h5><?php echo $category_name?></h5>
								<p><?php echo $description ?></p>

								<div class="row">
									<div class="container">

										<?php
										
                                    if (isset($_SESSION['useremail'])) {
										
                                        
										
										$query="SELECT Is_Paid, Price FROM notes WHERE ID=$noteid";
										$result=mysqli_query($connection,$query);
										if(!$result){
											echo mysqli_error($connection);
										}
										while($row=mysqli_fetch_assoc($result)){
											$sell_type=$row['Is_Paid'];
											$sell_price=$row['Price'];
										}
										if ($sell_type==5) {
                                            $attactments_getter = mysqli_query($connection, "SELECT Note_ID FROM notesattachment WHERE Note_ID=$noteid");
											if(!$attactments_getter){
												echo mysqli_error($connection);
											}
                                            $attact_count = mysqli_num_rows($attactments_getter);
echo $attact_count;
                                            //if note has single attachement
                                            if ($attact_count <= 1) {
                                                echo "<form action='' method='POST'>";
                                                echo " <button type='submit' id='note-download' data-toggle='modal' name='single_download' class='btn btn-primary'>Download</button>";
                                                echo "</form>";
                                                if ($sellerid == $buyerid)
                                                    echo "<h6>You Self own this note so downloading it won't display in the buyer request section</h6>";

                                                //if note has multiple attachements
                                            } else if ($attact_count > 1) {
                                    ?>
										<form action="" method="post">
											<button type='submit' id='note-download' data-toggle='modal' name='download_all' class='btn btn-primary' name='download_all'>download</button>
										</form>


										<?php }
											
										
										
                                    } else if ($sell_type == 4) {
                                            echo " <button type='submit' id='note-download' class='btn btn-primary' data-toggle='modal'
                                        data-target='#confirm-purchase-popup' >download / &#36;$sell_price</button>";
                                            if ($sellerid == $buyerid)
                                                echo "<h6>You Self own this note so downloading it won't display in the buyer request section</h6>";
                                        }}else {?>
                                         <button type='submit' id='note-download' class='btn btn-primary' onclick="window.location.href='login1.php'">Download </button>
										<?php }
                                    
                                    ?>

									</div>

								</div>
							</div>
						</div>

					</div>



					<div class="col-md-12 col-lg-5  col-sm-12 col-xs-12" id="note-detail-1-right">
						<div class="row">
							<div class="note-right-heading col-4 col-lg-4 ">
								<h5>Institute:</h5>
							</div>
							<div class="note-description col-8">
								<h5><?php if($university !=NULL){ echo $university;} else {
									echo "-";
								} ?></h5>
							</div>
						</div>
						<div class="row">
							<div class="note-right-heading col-md-5 col-sm-5 col-lg-5 col-sm-5 col-5">
								<h5>Country:</h5>
							</div>
							<div class="note-description col-md-7 col-sm-7 col-lg-7 col-sm-7 col-7">
								<h5><?php if($country_name !=NULL){ echo $country_name;} else {
									echo "-";
								} ?></h5>
							</div>
						</div>
						<div class="row">
							<div class="note-right-heading col-5">
								<h5>Course Name:</h5>
							</div>
							<div class="note-description col-7">
								<h5><?php if($course_name!=NULL){ echo $course_name;} else {
									echo "-";
								} ?></h5>
							</div>
						</div>
						<div class="row">
							<div class="note-right-heading col-md-6 col-sm-6 col-lg-6 col-sm-6 col-6">
								<h5>Course Code:</h5>
							</div>
							<div class="note-description col-md-6 col-sm-6 col-6 col-lg-6 col-sm-6">
								<h5><?php if($course_Code !=NULL){ echo $course_Code;} else {
									echo "-";
								} ?></h5>
							</div>
						</div>
						<div class="row">
							<div class="note-right-heading col-4">
								<h5>Professor:</h5>
							</div>
							<div class="note-description col-8">
								<h5><?php if($professor !=NULL){ echo $professor;} else {
									echo "-";
								} ?></h5>
							</div>
						</div>
						<div class="row">
							<div class="note-right-heading col-md-6 col-sm-6 col-lg-6 col-sm-6 col-6">
								<h5>Number of Pages:</h5>
							</div>
							<div class="note-description col-md-6 col-sm-6 col-lg-6 col-sm-6 col-6">
								<h5><?php if($num_of_pages !=NULL){ echo $num_of_pages;} else {
									echo "-";
								} ?></h5>
							</div>
						</div>
						<div class="row">
							<div class="note-right-heading col-6">
								<h5>Approved Date:</h5>
							</div>
							<div class="note-description col-6">
								<h5><?php if($approved_date !=NULL){ echo $approved_date;} else {
									echo "-";
								} ?></h5>
							</div>
						</div>
						<div class="row">
							<div class="note-right-heading col-md-5 col-sm-5 col-lg-5 col-sm-5 col-5">
								<h5>Rating:</h5>
							</div>

<?php
$star_rating = mysqli_query($connection, "SELECT AVG(ratings),COUNT(ratings) FROM review_rating WHERE noteid=$noteid AND isactive=1");
while ($row = mysqli_fetch_assoc($star_rating)) {
	$star_rating_val = $row['AVG(ratings)'];
	$star_rating_count = $row['COUNT(ratings)'];
}

?>

							<div class="note-description col-md-7 col-sm-7 col-lg-7 col-xs-7 col-7">
								
									<?php if($star_rating_count>0){?>
										<div class="notes-star">
										<?php for($i=0;$i<$star_rating_val;$i++){
											echo "<img src='images/images/star.png'>";
										}
                                        for($i=0;$i<(4-$star_rating_val);$i++){
											echo "<img src='images/images/star-white.png'>";
										}
									echo " ".$star_rating_count." Reviews";?>		
									</div>
									<?php }
									else echo "-";?>
							</div>
						</div>

						<?php 
						$query_appropriate=mysqli_query($connection,"SELECT * FROM reports WHERE noteid=$noteid AND isactive=1");
						$count_appropriate=mysqli_num_rows($query_appropriate);
						?>
						<div class="note-right-heading note-red col-md-12 col-sm-12 sol-xs-12 col-lg-12">
							<h5><?php echo $count_appropriate;?> Users have marked this note as inappropriate</h5>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!--bottom-->
		<div class="note-details-2 container">
			<div class="row no-gutters">
				<div class="col-md-12 col-sm-12 col-lg-6 col-xs-12">
					<div class="note-preview-box">
						<h3>Notes Preview</h3>

						<div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
							<div class="note-details-2-left">
							<?php echo "<iframe src=' $notes_preview'>"?>
								

								</iframe>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-12 col-sm-12 col-lg-6 col-xs-12">
					<h3>Customer Review</h3>

					<div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
					<div class="note-details-2-right">
						<?php
						$query_review=mysqli_query($connection,"SELECT * FROM review_rating WHERE NoteID=$noteid");
						if(!$query_review){
							echo mysqli_error($connection);
						}
						while($row=mysqli_fetch_assoc($query_review)){
							$rating=$row['ratings'];
							$comments=$row['Comments'];
							$userid=$row['UserID'];
							$userprofile=mysqli_query($connection,"SELECT FirstName,LastName FROM users WHERE ID=$userid");
							while($row=mysqli_fetch_assoc($userprofile)){
							$userlname=$row['LastName'];
							$userfname=$row['FirstName'];
						}
						$userprofilepic=mysqli_query($connection,"SELECT Profile_Pic FROM users_details WHERE UserID=$userid");
						while($row=mysqli_fetch_assoc($userprofilepic)){
						$profilepic=$row['Profile_Pic'];
						}
						?>
						<!--reviewer -->
							<div class="row" id="reviewer">
								<div class="col-md-2 col-2 reviewer-img">
<?php								echo "	<img src='$profilepic'>";?>
								</div>
								<div class="col-md-10 col-10">
									<div class="reviewer-info">
								<?php	echo "	<h6>$userfname  $userlname</h6>";?>
										<div class="notes-star">
										
										<?php for($i=0;$i<$rating;$i++){
											echo "<img src='images/images/star.png'>";
										}
                                        for($i=0;$i<(5-$rating);$i++){
											echo "<img src='images/images/star-white.png'>";
										}
								?>
										
										<?php echo "<p>$comments</p>";?>
									</div>
								</div>
							</div>



						</div><?php
				}
				?>
					</div>
				</div>
			</div>
		</div>
	</div>


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
	<script src="js/bootstrap/bootstrap.bundle.min.js"></script>
	<script src="js/bootstrap/bootstrap.min.4.5.js"></script>
<script>
function Purchase() {	
	$('#thankyou-popup').modal('show');
}
</script>
	<!--js-->
	<script src="js/script.js"></script>
</body>

</html>
