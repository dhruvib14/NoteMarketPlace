<?php
include "db.php";
session_start();

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
if(isset($_SESSION['useremail'])){
	$email=$_SESSION['useremail'];
	echo $email;
 $query="SELECT ID FROM users WHERE EmailID='$email'";
 $result=mysqli_query($connection,$query);
 if(!$result){
	 echo mysqli_error($connection);
 }

 while($row=mysqli_fetch_array($result)){
	 $userid=$row['ID'];
 }
$limit = 10;

if (isset($_GET["page"])) {
    $page  = $_GET["page"];
	if($page==0){
		$page=1;
	}
} else {
    $page = 1;
}
if(isset($_GET['noteid'])){
	$noteid=$_GET['noteid'];
    $query="SELECT * FROM notesattachment WHERE Note_ID=$noteid";
	$result= mysqli_query($connection,$query);
$count=mysqli_num_rows($result);
while($row=mysqli_fetch_array($result)){
	$path=$row['Path'];
	
}
$query="SELECT Note_Title FROM notes WHERE ID=$noteid";
$result= mysqli_query($connection,$query);
while($row=mysqli_fetch_array($result)){
	$title=$row['Note_Title'];
}
if($count==1){
header('Cache-Control:public');
header('Content-Description:File Transfer');
header('Content-Disposition:attachment; filename='.$title.'.pdf');
header('Control-Type:application/pdf');
header('Content-Transfer-Encoding:binary');
readfile($path);

$downloader_Entry=mysqli_query($connection,"UPDATE downloads SET AttachmentDownloadedDate=NOW(),IsAttachmentDownloaded=1 WHERE NoteID=$noteid AND DownloaderID=$userid AND IsSellerHasAllowedDownload=1");

}
else{
	echo $title."title";
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
	$downloader_Entry=mysqli_query($connection,"UPDATE downloads SET AttachmentDownloadedDate=NOW(),IsAttachmentDownloaded=1 WHERE NoteID=$noteid AND DownloaderID=$userid  AND IsSellerHasAllowedDownload=1");
}

}
$start=($page *$limit) - $limit;
if (isset($_POST['search'])) {

    $search_result = $_POST['search_result'];

    $query = "SELECT downloads.ID,downloads.DownloaderID,users.EmailID, downloads.NoteTitle,downloads.NoteID,downloads.NoteCategory,downloads.IsSellerHasAllowedDownload,referencedata.Value,downloads.PurchasedPrice,downloads.AttachmentDownloadedDate FROM downloads LEFT JOIN referencedata 
             ON downloads.IsPaid=referencedata.ID LEFT JOIN users ON downloads.DownloaderID=users.ID LEFT JOIN users_details ON users_details.UserID=downloads.DownloaderID  WHERE (NoteTitle LIKE '%$search_result%' OR users.EmailID LIKE '%$search_result%' OR downloads.PurchasedPrice LIKE '%$search_result%' OR referencedata.Value LIKE '%$search_result%' OR downloads.NoteCategory LIKE '%$search_result%') AND downloads.DownloaderID=$userid AND IsSellerHasAllowedDownload='1' ORDER BY downloads.AttachmentDownloadedDate DESC LIMIT $start, $limit";

    $result = mysqli_query($connection, $query);
    if(!$result){
	echo mysqli_error($connection);
    }
    $result_num = mysqli_query($connection,"SELECT COUNT(downloads.ID) FROM downloads LEFT JOIN referencedata 
    ON downloads.IsPaid=referencedata.ID LEFT JOIN users ON users.ID=downloads.DownloaderID WHERE (NoteTitle LIKE '%$search_result%' OR referencedata.Value LIKE '%$search_result%' OR downloads.PurchasedPrice LIKE '%$search_result%' OR downloads.NoteCategory LIKE '%$search_result%' OR users.EmailID LIKE '%$search_result%') AND IsSellerHasAllowedDownload='0'");
    $row = mysqli_fetch_row($result_num);
    $total_records = $row[0];
	echo $total_records;
    $total_page = ceil($total_records / $limit);
} 
else {
    $query = "SELECT downloads.ID,downloads.DownloaderID,users.EmailID,downloads.NoteTitle,downloads.NoteID,downloads.NoteCategory,downloads.IsSellerHasAllowedDownload,referencedata.Value,downloads.PurchasedPrice,downloads.AttachmentDownloadedDate FROM downloads  LEFT JOIN referencedata ON downloads.IsPaid=referencedata.ID LEFT JOIN users ON downloads.DownloaderID=users.ID LEFT JOIN users_details ON users_details.UserID=downloads.DownloaderID WHERE IsSellerHasAllowedDownload='1'AND users_details.UserID=$userid ORDER BY downloads.AttachmentDownloadedDate DESC LIMIT $start, $limit";
    $result = mysqli_query($connection, $query);
    $result_num = mysqli_query($connection, "SELECT COUNT(downloads.ID) FROM downloads LEFT JOIN referencedata 
    ON downloads.IsPaid=referencedata.ID WHERE IsSellerHasAllowedDownload='1'");
	$row = mysqli_fetch_row($result_num);
	$total_records = $row[0];
    $total_page = ceil($total_records / $limit);
}

if(isset($_POST['submit_rating'])){
	$rating=$_POST['asprating'];
	$comment=$_POST['comments'];
	$downloadedid=$_POST['downloadedid'];
	$noteid=$_POST['noteid_for_review'];
		$query="INSERT INTO review_rating(NoteID,UserID,againstdownloadID,ratings,Comments,CreatedDate,CreatedBy,IsActive) VALUES ('$noteid','$userid','$downloadedid','$rating','$comment',NOW(),$userid,1)";
		$result_rating=mysqli_query($connection,$query);
		if(!$result_rating){
			echo mysqli_error($connection);
		}   
	}

	if(isset($_POST['submit_review'])){
		$title=$_POST['title_for_report'];
		$remarks=$_POST['remarks'];
		$downloadedid=$_POST['downloadedid_for_report'];
		$noteid=$_POST['noteid_for_report'];
		
        $query="INSERT INTO reports(NoteID,UserID,againstdownloadID,Remarks,CreatedDate,CreatedBy,IsActive) VALUES ('$noteid','$userid','$downloadedid','$remarks',NOW(),$userid,1)";
			$result_rating=mysqli_query($connection,$query);
			if(!$result_rating){
				echo mysqli_error($connection);
			}
       
            $query="SELECT Firstname FROM users WHERE ID=$userid";
            $result=mysqli_query($connection,$query);
            if(!$result){
                echo mysqli_error($connection);
            }
            while($row=mysqli_fetch_assoc($result)){
                $membername=$row['Firstname'];
        
            }
        $query="SELECT SellerID FROM notes WHERE ID=$noteid";
        $result=mysqli_query($connection,$query);
        if(!$result){
            echo mysqli_error($connection);
        }
        while($row=mysqli_fetch_assoc($result)){
            $sellerid=$row['SellerID'];
        }

        $query="SELECT Firstname,EmailID FROM users WHERE ID=$sellerid";
        $result=mysqli_query($connection,$query);
        if(!$result){
            echo mysqli_error($connection);
        }
        while($row=mysqli_fetch_assoc($result)){
            $sellername=$row['Firstname'];
            $selleremail=$row['EmailID'];
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
            $mail->setFrom($config_email, $sellername);

            $mail->addAddress($selleremail);
            $mail->addReplyTo($selleremail, $sellername);

            $mail->IsHTML(true);
            $mail->Subject = " $membername Reported an issue for $title ";
            $mail->Body = "Hello Admins, 
 <br><br>
 We want to inform you that, $membername Reported an issue for $sellername’s Note with title $title. Please look at the notes and take required actions.    <br><br>
Regards,  Notes Marketplace";
				
				
				
            $mail->AltBody = '';
            $mail->send();
            $mail_sent = true;
            header('Location:dashboard.php');    } catch (Exception $e) {
            echo "Error in sending email. Mailer Error: {$mail->ErrorInfo}";
        }
		}
}
else {
	header('Location:login1.php');
}

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
						<a href="home.php"><img src="images/images/logo.png"> </a><span id="mobile-nav-open-btn">
							&#9776;</span>
					</div>
					<!--main menu-->
					<div class="collapse navbar-collapse">

						<ul class="navbar-nav ">
							<li class="nav-item"><a class="smooth-scroll nav-link active" href="search-notes.php">Search Notes</a>
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
									<a class='dropdown-item dd-logout' href='logout.php'><p>Logout</p></a>
								</div>
							</li>";}
?>
<?php if(isset($_SESSION['useremail'])){echo "
							<li class='nav-item'><a class='smooth-scroll nav-link' id='button-nav' href='logout.php'>
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
							<li class="nav-item"><a class="smooth-scroll nav-link active" href="search-notes.php">Search Notes</a>
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
									<a class='dropdown-item dd-logout' href='logout.php'><p>Logout</p></a>
								</div>
							</li>";}
?>
<?php if(isset($_SESSION['useremail'])){echo "
							<li class='nav-item'><a class='smooth-scroll nav-link' id='button-nav' href='logout.php'>
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

	<section class="mydownloadspage">
		<div class="container">
		<form action="mydownloads.php" method="post">
			<div class="row horizontal-heading no-gutters">
				<div class="col-6 col-md-6 col-sm-6 col-lg-6">
					<h3>My Downloads</h3>
				</div>

				<div class="dashboard-search">
					<input type="text" class="form-control" id="search-text-dashboard" name="search_result"  style="font-family:Sans-serif, FontAwesome" placeholder="&#xF002   Search" >
					<button type="submit" class="btn btn-primary btn-search dashboard-btn" name="search">Search</button>

				</div>
			</div>
			<div class=" table-responsive">
				<table class="table table-hover" id="download-notes-table">
					<thead>
						<tr>
							<th scope="col" class="text-center">SR NO.</th>
							<th scope="col">NOTE TITLE</th>
							<th scope="col">CATEGORY</th>
							<th scope="col">BUYER</th>
							<th scope="col">SELL TYPE</th>
							<th scope="col">PRICE</th>
							<th scope="col">DOWNLOAD DATE/TIME</th>
							<th scope="col"></th>
						</tr>
					</thead>
					<tbody>
						
					<?php
                          $i=1;
						
						  if($total_records==0){
							  echo " <tr><td colspan='8' style='text-align:center;'> no records found</td></tr>";
						  }else{
						
						            while ($row = mysqli_fetch_assoc($result)) {
                                $title = $row['NoteTitle'];
                                $category = $row['NoteCategory'];
								$email1=$row['EmailID'];
								$noteid=$row['NoteID'];
                                
								$refe_data = $row['Value'];
                                $price = $row['PurchasedPrice'];
                                $time = $row['AttachmentDownloadedDate'];
								 $id=$row['ID'];										
                                echo "  <tr>
                                        <td class='text-center'>" . $i++ . "</td>
                                        <td><a href='note-details.php?id=$noteid'>$title</a></td>
                                        <td>$category</td>
                                        <td>$email1</td>
                                        <td>$refe_data</td>
                                        <td>&#36;$price</td>
                                        <td>$time</td>
                                        <td>
                                        <div class='dropleft'><a href='note-details.php?id=$noteid'><img src='images/images/eye.png' ></a>
										<a id='dropdownMenuLink' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><img src='images/images/dots.png'></a>
									    <div class='dropdown-menu dropleft' aria-labelledby='dropdownMenuLink'>
										<a class='dropdown-item' href='mydownloads.php?noteid=$noteid'>Download Note</a>
										<a class='dropdown-item' href='#' data-id= '$noteid' data-download='$id'  id='add-review-star' data-toggle='modal' data-target='#exampleModal'>Add Reviews/feedback</a>
										<a class='dropdown-item' href='#'  data-title='$title' data-id= '$noteid' data-download='$id' id='report_as_inappropriate' data-toggle='modal' data-target='#report'>Report as inappropriate</a>
									</div>
								</div>
                                    </td>
                                    </tr>";?>
									
									<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title add-review" id="exampleModalLabel"> Add Review</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<form action="" method="post">
												<div class="modal-body">
												
												<div class="star-img">
														<input type="hidden" id="asp1_hidden" value="1">
														<img  src="images/images/star-white.png"  onmouseover="change(this.id);" id="asp1" class="asp">
														<input type="hidden" id="asp2_hidden" value="2">
														<img src="images/images/star-white.png"  onmouseover="change(this.id);" id="asp2" class="asp">
														<input type="hidden" id="asp3_hidden" value="3">
														<img  src="images/images/star-white.png"  onmouseover="change(this.id);" id="asp3" class="asp">
														<input type="hidden" id="asp4_hidden" value="4">
														<img  src="images/images/star-white.png"  onmouseover="change(this.id);" id="asp4" class="asp">
														<input type="hidden" id="asp5_hidden" value="5">
														<img  src="images/images/star-white.png" onmouseover="change(this.id);" id="asp5" class="asp">
														<input type="hidden" name="asprating" id="asprating">
													</div>
													<input name="noteid_for_review" id="noteid_for_review" value="" hidden>
												
												<input name="downloadedid" id="downloadedid" value="" hidden>
											
															<label for="exampleInputName">Comments* </label>
													<textarea class="form-control comment input-field" rows="3" name="comments" placeholder="comments" required></textarea>
						
												</div>
												<div class="modal-footer">
													<button type="submit"  name="submit_rating" class="btn btn-primary" id="modal-btn">Submit</button>
												</div></form>
											</div>
										</div>
									</div>
							
							<!--report an appropriate-->

									<div class="modal fade" id="report" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
												
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<form action="" method="post">
												<div class="modal-body">

												<input style="margin-bottom:30px; " name="title_for_report" id="title_for_report" value="">
												<br><input name="noteid_for_report" id="noteid_for_report" value="" hidden>
												
												<input name="downloadedid_for_report" id="downloadedid_for_report" value="" hidden >
													<label for="exampleInputName">remarks* </label>
													<textarea class="form-control comment input-field" rows="3" name="remarks" placeholder="remarks"></textarea>					
												</div>
												<div class="modal-footer">
													<button type="submit" onclick='javascript:Report($(this));return false;' name="submit_review" href='mydownloads.php?userid=". $userid."'  class="btn btn-primary" id="modal-btn">Submit</button>
													<button type="button"  class="close" data-dismiss="modal" aria-label="Close" id="modal-btn">
													<span aria-hidden="true">Cancel</span>
													</button>
												</div></form>
											</div>
										</div>
									</div>
							<?php
								}}
                            ?>
					</tbody>
				</table>
				</div>
				</form>
			
		</div>

		
	</section>


	<div class="footer">
		<hr>
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-sm-7 col-xs-7">
					<p>Copyright <span>&#169;</span> Tatvasoft All rights reserved.</p>
				</div>
				<div class="col-md-6 col-sm-5 col-xs-5 social-icons">
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
$(function() {

//note id getter via data id
$(document).on("click", "#add-review-star", function() {
	$('#noteid_for_review').val($(this).data('id'));
	$('#downloadedid').val($(this).data('download'));
	$('#exampleModal').modal('show');
});

//note title getter via data id
$(document).on("click", "#report_as_inappropriate", function() {
	$("#title_for_report").val($(this).data('title'));
	$("#noteid_for_report").val($(this).data('id'));
	$("#downloadedid_for_report").val($(this).data('download'));
	$("#report").modal('show');
})
});

$(document).ready(function () {

var rejectedNotesTable = $('#rejected-notes-table').DataTable({
    "order": [[ 4, "desc" ]],
    "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
        //debugger;
        var index = iDisplayIndexFull + 1;
        $("td:first", nRow).html(index);
        return nRow;
    },
    'sDom': '"top"i',
    "iDisplayLength": 10,
    "bInfo": false,
    language: {
        "zeroRecords": "No record found",
        paginate: {
            next: "<img src='images/images/right-arrow.png' alt='next'>",
            previous: "<img src='images/images/left-arrow.png' alt='prev'>"
        }
    }
});
});
</script>
<script src="js/datatables.js"></script>
	<!--js-->
	<script src="js/script.js"></script>
</body>

</html>