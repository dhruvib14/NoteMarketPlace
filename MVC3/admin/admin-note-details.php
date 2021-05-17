<?php 
include "../front/db.php";
session_start();
if(isset($_SESSION['useremail'])){
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
    $noteid=$_GET['noteid'];
}



    if(isset($_POST['download'])){
	    
		
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


//delete report
if(isset($_GET['reportid'])){
    $reportid=$_GET['reportid'];
    $query=mysqli_query($connection,"UPDATE review_rating SET IsActive=0 WHERE ID=$reportid");
    if(!$query){
        echo mysqli_error($connection);
    }
    header("Location:admin-note-details.php?noteid=$noteid");
}
?>

<!DOCTYPE html>
<html lang="en">


<head>
   
   <!--meta-->
   <meta http-equiv="X-UA-Compatible" content="IE=edge" />

   <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0 ,user-scalable=no">

    <title>Notes Marketplace </title>
    
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
							<li class="nav-item"><a class="smooth-scroll nav-link " href="admin-dashboard.php">Dashboard</a></li>

							<li class="nav-item dropdown"><a class="smooth-scroll nav-link " href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Notes</a>
								<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
									<a class="dropdown-item" href="admin-notes-under-review.php">Notes Under Review</a>
									<a class="dropdown-item " href="admin-published-notes.php">Published Notes</a>
									<a class="dropdown-item" href="admin-downloaded-notes.php">Downloaded Notes</a>
									<a class="dropdown-item " href="admin-rejected-notes.php">Rejected Notes</a>
								</div>
							</li>
							<li class="nav-item"><a class="smooth-scroll nav-link" href="admin-members.php">Members</a></li>
							<li class="nav-item dropdown"><a class="smooth-scroll nav-link active" href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Reports</a>
								<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
									<a class="dropdown-item active" href="admin-spamreports.php">Spam Reports</a>
								</div>
							</li>
							<li class="nav-item dropdown"><a class="smooth-scroll nav-link " href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Settings</a>
								<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
									<a class="dropdown-item " href="admin-manage-system.php">Manage System Configuration</a>
									<a class="dropdown-item " href="admin-manage-administration.php">Manage Administration</a>
									<a class="dropdown-item " href="admin-manage-category.php">Manage Category</a>

									<a class="dropdown-item" href="admin-manage-type.php">Manage Type</a>
									<a class="dropdown-item " href="admin-manage-country.php">Manage Countries</a>
								</div>
							</li>
							<li class="nav-item dropdown"><a class="smooth-scroll nav-link pic-nav" href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							
							<?php echo "<img src='$profile_pic'>";?></a>
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
					<!--mobile menu-->
					<div id="mobile-nav">
						<div class="navbar-header">
							<img src="images/images/logo.png">
							<!--mobile menu close button-->
							<span id="mobile-nav-close-btn">&times;</span>
						</div>

						<div id="mobile-nav-content">
							<ul class="navbar-nav  ">
								<li class="nav-item"><a class="smooth-scroll nav-link " href="admin-dashboard.php">Dashboard</a></li>

								<li class="nav-item dropdown"><a class="smooth-scroll nav-link " href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Notes</a>
									<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
										<a class="dropdown-item" href="admin-notes-under-review.php">Notes Under Review</a>
										<a class="dropdown-item " href="admin-published-notes.php">Published Notes</a>
										<a class="dropdown-item" href="admin-downloaded-notes.php">Downloaded Notes</a>
										<a class="dropdown-item " href="admin-rejected-notes.php">Rejected Notes</a>
									</div>
								</li>
								<li class="nav-item"><a class="smooth-scroll nav-link " href="admin-members.php">Members</a></li>
								
								<li class="nav-item dropdown"><a class="smooth-scroll nav-link " href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Reports</a>
									<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
										<a class="dropdown-item " href="admin-spamreports.php">Spam Reports</a>
									</div>
								</li>
								<li class="nav-item dropdown"><a class="smooth-scroll nav-link " href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Settings</a>
									<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
										<a class="dropdown-item " href="admin-manage-system.php">Manage System Configuration</a>
										<a class="dropdown-item " href="admin-manage-administration.php">Manage Administration</a>
										<a class="dropdown-item " href="admin-manage-category.php">Manage Category</a>

										<a class="dropdown-item" href="admin-manage-type.php">Manage Type</a>
										<a class="dropdown-item " href="admin-manage-country.php">Manage Countries</a>
									</div>
								</li>
								<li class="nav-item dropdown"><a class="smooth-scroll nav-link pic-nav " href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								
							<?php echo "<img src='$profile_pic'>";?></a>
									<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
										<a class="dropdown-item " href="admin-myprofile.php">Update Profile</a>
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

<div id="note-detail">
      <div class="container">
          <div id="note-detail-1 " class="note-deatil-admin">
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
                                           
                                    ?>
										<form action="" method="post">
											<button type='submit' id='note-download'  name='download' class='btn btn-primary' >download</button>
										</form>


										<?php }
											
										
										
                                else {?>
                                        <form action="" method="post">
                                            <?php echo " <button type='submit' id='note-download' class='btn btn-primary' name='download' >download / &#36;$sell_price</button>";
                                            ?></form>
                                        <?php 
                                        }    }
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
                                        for($i=0;$i<(5-$star_rating_val);$i++){
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
						$query_review=mysqli_query($connection,"SELECT * FROM review_rating WHERE NoteID=$noteid AND IsActive=1");
						if(!$query_review){
							echo mysqli_error($connection);
						}
                        $count_reviewer=mysqli_num_rows($query_review);
                        if($count_reviewer==0){
                            echo "NO Reviews Yet!";
                        }
						while($row=mysqli_fetch_assoc($query_review)){
							$rating=$row['ratings'];
							$comments=$row['Comments'];
							$userid=$row['UserID'];
                            $reportid=$row['ID'];
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
								<div class="col-md-9 col-9 ">
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
										
								</div>
									</div>
								</div>

                                <div class="col-md-1 col-lg-1 col-1 mr-0"><div class="delete"><?php echo "<a href='admin-note-details.php?reportid=$reportid&noteid=$noteid'><img src='images/images/delete.png'></a>";?></div></div>
                                <div class="col-md-2 col-lg-2 col-3"> </div><div class="col-md-10 col-lg-10 col-9">		<?php echo "<p>$comments</p>";?></p></div>
        
							




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
