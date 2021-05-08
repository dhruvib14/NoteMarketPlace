<?php
include "../front/db.php";
session_start();
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

if(isset($_SESSION["useremail"])){
$email=$_SESSION['useremail'];
$query="SELECT ID FROM users WHERE EmailID='$email'";
$result=mysqli_query($connection,$query);
if(!$result){
	echo mysqli_error($connection);
}
while($row=mysqli_fetch_array($result)){
	$admin_id=$row['ID'];
}
$query=mysqli_query($connection,"SELECT Profile_Pic FROM users_details WHERE UserID=$admin_id");
	
	while($row=mysqli_fetch_array($query)){
		$profile_pic=$row['Profile_Pic'];
	}

}
else{
	header("Location:../front/login1.php");
}
if(isset($_GET['noteid'])){
$admin_id=94;
$noteid=$_GET['noteid'];
    $query="SELECT * FROM notesattachment WHERE Note_ID=$noteid";
	$result= mysqli_query($connection,$query);
$count=mysqli_num_rows($result);
if(!$result){
	echo mysqli_error($connection);
}
while($row=mysqli_fetch_array($result)){
	$path=$row['Path'];
}
$query="SELECT * FROM notes WHERE ID=$noteid";
$result= mysqli_query($connection,$query);
while($row=mysqli_fetch_array($result)){
	$title=$row['Note_Title'];
	$sellerID=$row['SellerID'];
	$Is_Paid=$row['Is_Paid'];
$prince=$row['Price'];
$category=$row['Category'];
}
echo $title;
$exist_query=mysqli_query($connection,"SELECT ID FROM downloads WHERE NoteID=$noteid AND DownloaderID=$admin_id");
if(!$exist_query){
	echo mysqli_error($connection);
}
$exist=mysqli_num_rows($exist_query);

if($count==1){
header('Cache-Control:public');
header('Content-Description:File Transfer');
header('Content-Disposition:attachment; filename='.$title.'.pdf');
header('Control-Type:application/pdf');
header('Content-Transfer-Encoding:binary');
readfile($path);
if($exist>0)
$downloader_Entry=mysqli_query($connection,"UPDATE downloads SET AttachmentDownloadedDate=NOW(),IsAttachmentDownloaded=1,ModifiedDate=Now(),ModifiedBy=$admin_id WHERE NoteID=$noteid AND DownloaderID=$admin_id AND IsSellerHasAllowedDownload=1");
else{
	$downloader_Entry=mysqli_query($connection,"INSERT INTO downloads 
	(SellerID,DownloaderID,NoteID,IsSellerHasAllowedDownload,AttachmentPath,IsAttachmentDownloaded,AttachmentDownloadedDate,IsPaid,PurchasedPrice,NoteTitle,NoteCategory,CreatedDate,CreatedBy,IsActive) VALUES 
	($sellerID,$admin_id,$noteid,1,'$path',1,NOW(),$Is_Paid,$prince,'$title','$category',NOW(),$admin_id,1)");
}if(!$downloader_Entry){
	echo mysqli_error($connection);
}
}
else{
	echo $title."title";
	$zipname = $title . '.zip';
    $zip = new ZipArchive;
    $zip->open($zipname, ZipArchive::CREATE);
    $query = mysqli_query($connection, "SELECT AttachmentPath FROM notesattachment WHERE Note_ID=$noteid");
    while ($row = mysqli_fetch_assoc($query)) {
        $attact_id = $row['AttachmentPath'];
        $zip->addFile($attact_id);
    }
    $zip->close();
    header('Content-Type: application/zip');
    header('Content-disposition: attachment; filename=' . $zipname);
    header('Content-Length: ' . filesize($zipname));
    readfile($zipname);
	if($exist>0)
	$downloader_Entry=mysqli_query($connection,"UPDATE downloads SET AttachmentDownloadedDate=NOW(),IsAttachmentDownloaded=1,ModifiedDate=Now(),ModifiedBy=$admin_id WHERE NoteID=$noteid AND DownloaderID=$admin_id  AND IsSellerHasAllowedDownload=1");
else{
	$downloader_Entry=mysqli_query($connection,"INSERT INTO downloads 
	(SellerID,DownloaderID,NoteID,IsSellerHasAllowedDownload,AttachmentPath,IsAttachmentDownloaded,AttachmentDownloadedDate,IsPaid,PurchasedPrice,NoteTitle,NoteCategory,CreatedDate,CreatedBy,IsActive) VALUES 
	($sellerID,$admin_id,$noteid,1,'$path',1,NOW(),$Is_Paid,$prince,'$title','$category',NOW(),$admin_id,1)");
}
}
}



if(isset($_POST['submit_review'])){

	 $title=$_POST['title_for_report'];
	  $unpublish_id=$_POST['noteid_for_report'];
	 $remark=$_POST['remarks'];

$query_unpublish=mysqli_query($connection,"UPDATE notes SET Status=11,Actioned_By=$admin_id,ModifiedDate=NOW(),ModifiedBy=$admin_id,Admin_Remarks='$remark' WHERE ID=$unpublish_id");
if(!$query_unpublish){
	echo mysqli_error($connection);
}
$query_get_seller_id=mysqli_query($connection,"SELECT SellerID FROM notes WHERE ID=$unpublish_id");
while ($row=mysqli_fetch_assoc($query_get_seller_id)) {
	$sellerid=$row['SellerID'];
}
$query_seller=mysqli_query($connection,"SELECT EmailID,FirstName FROM users WHERE ID=$sellerid");
while($row=mysqli_fetch_assoc($query_seller)){
	$fname=$row['FirstName'];
	$email=$row['EmailID'];
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

		$mail->addAddress($email);
		$mail->addReplyTo($config_email, 'NotesMarketPlace');

		$mail->IsHTML(true);
		$mail->Subject = "Sorry! We need to remove your notes from our portal. ";
		

		$mail->Body = "Hello 
		$fname, 
		We want to inform you that, your note $title has been removed from the portal.<br><br> 
		Please find our remarks as below -   <br><br>
		$remark<br><br>
 
		Regards,  Notes Marketplace 
		 
		  ";

		$mail->AltBody = '';

		$mail->send();
		$mail_sent = true;
		if($mail_sent=true){
			}
			else echo"none";
		}
		
		
	 catch (Exception $e) {
		echo "Error in sending email. Mailer Error: {$mail->ErrorInfo}";
	} }



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
	<!--datatable-->
	<link rel="stylesheet" href="css/datatables.css">
</head>

<body>
	<!--header-->
	<header>
		<nav id="navuser" class="navbar nav-notes navbar-fixed-top navbar-expand-lg navbar-light  ">
			<div class="container-fluid ">
				<div class="site-nav-wrapper">
					<div class="navbar-header navbar-brand">
						<a href="admin-dashboard.php"><img src="images/images/logo.png"></a><span id="mobile-nav-open-btn">
							&#9776;</span>
					</div>
					<!--main menu-->

					<div class="collapse navbar-collapse">
						<ul class="navbar-nav pull-right ">
							<li class="nav-item"><a class="smooth-scroll nav-link active" href="admin-dashboard.php">Dashboard</a></li>

							<li class="nav-item dropdown"><a class="smooth-scroll nav-link" href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Notes</a>
								<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
									<a class="dropdown-item" href="admin-notes-under-review.php">Notes Under Review</a>
									<a class="dropdown-item" href="admin-published-notes.php">Published Notes</a>
									<a class="dropdown-item" href="admin-downloaded-notes.php">Downloaded Notes</a>
									<a class="dropdown-item" href="admin-rejected-notes.php">Rejected Notes</a>
								</div>
							</li>
							<li class="nav-item"><a class="smooth-scroll nav-link" href="admin-members.php">Members</a></li>
							<li class="nav-item dropdown"><a class="smooth-scroll nav-link" href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Reports</a>
								<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
									<a class="dropdown-item" href="admin-spamreports.php">Spam Reports</a>
								</div>
							</li>
							<li class="nav-item dropdown"><a class="smooth-scroll nav-link" href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Settings</a>
								<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
									<a class="dropdown-item" href="admin-manage-system.php">Manage System Configuration</a>
									<a class="dropdown-item" href="admin-manage-administration.php">Manage Administration</a>
									<a class="dropdown-item" href="admin-manage-category.php">Manage Category</a>

									<a class="dropdown-item" href="admin-manage-type.php">Manage Type</a>
									<a class="dropdown-item" href="admin-manage-country.php">Manage Countries</a>
								</div>
							</li>
							<li class="nav-item dropdown"><a class="smooth-scroll nav-link pic-nav " href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<?php echo "<img src='$profile_pic'>";?></a>
					<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
									<a class="dropdown-item" href="admin-myprofile.php">Update Profile</a>
									<a class="dropdown-item" href="../front/change-password.php">Change Password</a>
									<a class="dropdown-item dd-logout" onclick='javascript:logout($(this));return false;' href="../front/logout.php"><p>Logout</p></a>
								</div>
							</li>
							<li class="nav-item"><a class="smooth-scroll nav-link" id="button-nav" onclick='javascript:logout($(this));return false;' href="../front/logout.php">
									<p>Logout</p>
								</a></li>
						</ul>
					</div>
					<!--mobile menu-->
					<div id="mobile-nav">
						<div class="navbar-header">
							<img src="images/images/logo.png">
							<!--mobile menu close button-->
							<span id="mobile-nav-close-btn">&times;</span>
						</div>

						<div id="mobile-nav-content">
							<ul class="navbar-nav  ">
								<li class="nav-item"><a class="smooth-scroll nav-link active" href="admin-dashboard.php">Dashboard</a></li>

								<li class="nav-item dropdown"><a class="smooth-scroll nav-link" href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Notes</a>
									<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
										<a class="dropdown-item" href="admin-notes-under-review.php">Notes Under Review</a>
										<a class="dropdown-item" href="admin-published-notes.php">Published Notes</a>
										<a class="dropdown-item" href="admin-downloaded-notes.php">Downloaded Notes</a>
										<a class="dropdown-item" href="admin-rejected-notes.php">Rejected Notes</a>
									</div>
								</li>
								<li class="nav-item"><a class="smooth-scroll nav-link" href="admin-members.php">Members</a></li>
								<li class="nav-item dropdown"><a class="smooth-scroll nav-link" href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Reports</a>
									<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
										<a class="dropdown-item" href="admin-spamreports.php">Spam Reports</a>
									</div>
								</li>
								<li class="nav-item dropdown"><a class="smooth-scroll nav-link" href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Settings</a>
									<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
										<a class="dropdown-item" href="admin-manage-system.php">Manage System Configuration</a>
										<a class="dropdown-item" href="admin-manage-administration.php">Manage Administration</a>
										<a class="dropdown-item" href="admin-manage-category.php">Manage Category</a>

										<a class="dropdown-item" href="admin-manage-type.php">Manage Type</a>
										<a class="dropdown-item" href="admin-manage-country.php">Manage Countries</a>
									</div>
								</li>
								<li class="nav-item dropdown"><a class="smooth-scroll nav-link pic-nav " href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">	<?php echo "<img src='$profile_pic'>";?></a>
									<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
										<a class="dropdown-item" href="admin-myprofile.php">Update Profile</a>
										<a class="dropdown-item" href="../front/change-password.php">Change Password</a>
										<a class="dropdown-item dd-logout" onclick='javascript:logout($(this));return false;' href="../front/logout.php"><p>Logout</p></a>
									</div>
								</li>
								<li class="nav-item"><a class="smooth-scroll nav-link" onclick='javascript:logout($(this));return false;' id="button-nav" href="../front/logout.php">
										<p>Logout</p>
									</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</nav>


	</header>



	<section id="statistics">
		<div class="container">
			<div class="row no-gutters horizontal-heading">
				<h3>Dashboard</h3>
			</div>

			<div class="row no-gutters admin-dashboard">
<?php

$query_review_notes=mysqli_query($connection,"SELECT COUNT(ID) FROM notes WHERE Status=8");
if(!$query_review_notes){
	echo mysqli_error($connection);
}
$row = mysqli_fetch_row($query_review_notes);
    $review_notes = $row[0];

$query_downloads=mysqli_query($connection,"SELECT COUNT(ID) FROM downloads WHERE AttachmentDownloadedDate > DATE_SUB(NOW(), INTERVAL 7 DAY)");
if(!$query_downloads){
	echo mysqli_error($connection);
}
$row = mysqli_fetch_row($query_downloads);
    $downloaded_notes = $row[0];


$query_registration=mysqli_query($connection,"SELECT COUNT(ID) FROM users WHERE CreatedDate > DATE_SUB(NOW(), INTERVAL 7 DAY)");
if(!$query_registration){
	echo mysqli_error($connection);
}

$row = mysqli_fetch_row($query_registration);
    $registration = $row[0];

?>
				<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4 admin-dash-1">
					<div class="dashboard-box"><a href="admin-notes-under-review.php">
							<p class="dashboard-single-details text-center"><?php echo $review_notes;?></p>
							<p class="dashboard-detail-heading text-center">Numbers of Notes in Review for Publish</p>
						</a>
					</div>
				</div>
				<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
					<div class=" dashboard-box"><a href="admin-downloaded-notes.php">
							<p class="dashboard-single-details text-center"><?php echo $downloaded_notes;?></p>
							<p class="dashboard-detail-heading text-center">Number of New Notes Downloaded (Last 7 days)</p>
						</a>
					</div>
				</div>

				<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4 ">
					<div class="dashboard-box"><a href="admin-members.php">
							<p class="dashboard-single-details text-center"><?php echo $registration;?></p>
							<p class="dashboard-detail-heading text-center">Number of New Registration (Last 7 days)</p>
						</a>
					</div>
				</div>
			</div>
		</div>

	</section>


	<section id="in-progress-notes">
		<div class="container">
			<div class="row no-gutters horizontal-heading">
				<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
					<h3>Published Notes</h3>
				</div>
				
				<div class="dashboard-search ">
					<input type="text" class="form-control" id="search-text-dashboard" placeholder="&#xF002   Search" style="font-family:Sans-serif, FontAwesome" name="search_result">
					<button type="submit" class="btn btn-primary btn-search dashboard-btn " name="search" onclick="showdata()">Search</button>
<select style="width:170px; margin-right:0px; margin-left:10px;" class="form-control options-arrow-down " id="search_month" name="month" onchange="showdata()">
					
					<option value='0' disabled selected>Select Month</option>
                   
					<?php	for ($i = 0; $i <= 5; $i++) {
  $month= date('M Y', strtotime('last day of ' . -$i . 'month'));
  $date= date('Y-m', strtotime('last day of ' . -$i . 'month'));
  

   echo "<option value=' $date'> $month</option>";
}?>
				</select>
				</div>
			</div>
		<div id="dynamic_result"></div>
	
		</div>
	

	</section>




	<div class="admin-footer">
		<hr>
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-sm-4 col-xs-3">
					vesion 1.1.24
				</div>
				<div class="col-md-6 col-sm-8 col-xs-9 text-right">
					<p>Copyright <span>&#169;</span> Tatvasoft All rights reserved.</p>
				</div>
			</div>
		</div>
	</div>

	<!--jquery-->
	<script src="js/jquery.js"></script>
	
	<script type="text/javascript">
        function showdata(page_current) {
            let search_month = $("#search_month").val();
		  let search_result=$("#search-text-dashboard").val();

            $.ajax({
                url: "admin-dashboard-ajax.php",
                method: "GET",
                data: {
                    selected_month: search_month,
					selected_search: search_result
                },
                success: function(search_data) {
                    $("#dynamic_result").html(search_data);
                }
            });
        }
        $(function() {
            showdata(1);
        });
        </script>

	<!--bootstrap-->
	<script src="js/bootstrap/bootstrap.bundle.min.js"></script>
	<script src="js/bootstrap/bootstrap.min.4.5.js"></script>
	
	<script src="js/datatables.js"></script>
	<!--js-->
	<script src="js/script.js"></script>
</body>

</html>