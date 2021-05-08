<?php
include "../front/db.php";
session_start();
if(isset($_SESSION['useremail'])){

}else {
	header("Location:../front/login1.php");
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

if(isset($_GET['id'])){
	$id=$_GET['id'];
	$query_information=mysqli_query($connection,"SELECT * FROM users LEFT JOIN users_details ON users.ID=users_details.UserID WHERE users.ID=$id");
	if(!$query_information){
		echo mysqli_error($connection);
	}
	while($row=mysqli_fetch_array($query_information)){
		$fname=$row['FirstName'];
		$lname=$row['LastName'];
	$email=$row['EmailID'];
	$dob=$row['Dob'];
	$add1=$row['Address_1'];
	$add2=$row['Address_2'];
	$city=$row['City'];
	$college=$row['College'];
	$country_id=$row['Country'];
	$phone_number=$row['Phone_No'];
	$profile_pic=$row['Profile_Pic'];
	$state=$row['State'];
	$zip_code=$row['Zip_Code'];
	$university=$row['University'];
	$country_name_getter=mysqli_query($connection,"SELECT Country_Name,ID FROM country WHERE ID='$country_id'");
	if(!$country_name_getter){
		echo mysqli_error($connection);
	}
	while($row=mysqli_fetch_assoc($country_name_getter)){
		$country_name=$row['Country_Name'];
	}
}
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
							<li class="nav-item"><a class="smooth-scroll nav-link " href="admin-dashboard.php">Dashboard</a></li>

							<li class="nav-item dropdown"><a class="smooth-scroll nav-link active" href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Notes</a>
								<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
									<a class="dropdown-item" href="admin-notes-under-review.php">Notes Under Review</a>
									<a class="dropdown-item " href="admin-published-notes.php">Published Notes</a>
									<a class="dropdown-item" href="admin-downloaded-notes.php">Downloaded Notes</a>
									<a class="dropdown-item active" href="admin-rejected-notes.php">Rejected Notes</a>
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
								<li class="nav-item"><a class="smooth-scroll nav-link active" href="admin-members.php">Members</a></li>
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


	<section id="in-progress-notes" class="admin-manage">
		<div class="container">
			<div class="admin-manage-admin">
				<div class="row no-gutters horizontal-heading">
					<h3>Member Details</h3>
				</div>
			</div>


			<div class="row  admin-member">
				<div class="col-md-12 col-lg-2 col-sm-5 col-xs-5 member-img">
				<?php echo "<img src='$profile_pic'>";?>
				</div>
				<div class="col-lg-6 col-xl-5  col-md-12 col-sm-12 col-xs-12 member-left-detail">
					<div class="row">
						<div class="note-right-heading col-md-5 col-lg-5 col-5">
							<h5>First Name:</h5>
						</div>
						<div class="note-description col-md-7 col-7">
							<h5><?php if($fname!=NULL) echo $fname; else echo "-";?></h5>
						</div>
					</div>

					<div class="row">
						<div class="note-right-heading col-md-5 col-5">
							<h5>Last Name:</h5>
						</div>
						<div class="note-description col-md-7 col-7">
							<h5><?php if($lname!=NULL) echo $lname; else echo "-";?></h5>
						</div>
					</div>

					<div class="row">
						<div class="note-right-heading col-md-5 col-5">
							<h5>Email:</h5>
						</div>
						<div class="note-description col-md-7 col-7">
							<h5><?php if($email!=NULL) echo $email; else echo "-";?></h5>
						</div>
					</div>

					<div class="row">
						<div class="note-right-heading col-md-5 col-5">
							<h5>DOB:</h5>
						</div>
						<div class="note-description col-md-7 col-7">
							<h5><?php if($dob!=NULL) echo $dob; else echo "-";?></h5>
						</div>
					</div>

					<div class="row">
						<div class="note-right-heading col-md-5 col-5">
							<h5>Phone Number:</h5>
						</div>
						<div class="note-description col-md-7 col-7">
							<h5><?php if($phone_number!=NULL) echo $phone_number; else echo "-";?></h5>
						</div>
					</div>

					<div class="row">
						<div class="note-right-heading col-md-5 col-5">
							<h5>College/University:</h5>
						</div>
						<div class="note-description col-md-7 col-7">
							<h5><?php if($college!=NULL) echo $college; elseif($university!=NULL)  echo $university; else echo "-";?></h5>
						</div>
					</div>

				</div>

				<div class="col-lg-4 col-xl-5 col-md-12 col-sm-12 col-xs-12">
					<div class="row">
						<div class="note-right-heading col-md-5 col-5">
							<h5>Address 1:</h5>
						</div>
						<div class="note-description col-md-7 col-7">
							<h5><?php if($add1!=NULL) echo $add1; else echo "-";?></h5>
						</div>
					</div>

					<div class="row">
						<div class="note-right-heading col-md-5 col-5">
							<h5>Address 2:</h5>
						</div>
						<div class="note-description col-md-7 col-7">
							<h5><?php if($add2!=NULL) echo $add2; else echo "-";?></h5>
						</div>
					</div>

					<div class="row">
						<div class="note-right-heading col-md-5 col-5">
							<h5>City:</h5>
						</div>
						<div class="note-description col-md-7 col-7">
							<h5><?php if($city!=NULL) echo $city; else echo "-";?></h5>
						</div>
					</div>

					<div class="row">
						<div class="note-right-heading col-md-5 col-5">
							<h5>State:</h5>
						</div>
						<div class="note-description col-md-7 col-7">
							<h5><?php if($state!=NULL) echo $state; else echo "-";?></h5>
						</div>
					</div>

					<div class="row">
						<div class="note-right-heading col-md-5 col-5">
							<h5>Country:</h5>
						</div>
						<div class="note-description col-md-7 col-7">
							<h5><?php if($country_name!=NULL) echo $country_name; else echo "-";?></h5>
						</div>
					</div>

					<div class="row">
						<div class="note-right-heading col-md-5 col-5">
							<h5>Zip Code:</h5>
						</div>
						<div class="note-description col-md-7 col-7">
							<h5><?php if($zip_code!=NULL) echo $zip_code; else echo "-";?></h5>
						</div>
					</div>

				</div>

			</div>

		</div>

<?php 
$query_data=mysqli_query($connection,"SELECT ID,Note_Title,Category,Status,PublishedDate,CreatedDate FROM notes WHERE SellerID=$id");
if(!$query_data){
	echo mysqli_error($connection);
}

?>
		<div class="container">
			<div class="horizontal-heading member-details">
				<h3>Notes</h3>
			</div>
			<div class="table-responsive">
				<table class="table" id="member-notes-table">
					<thead>
						<tr>
							<th scope="col" class="text-center">SR NO.</th>
							<th scope="col">NOTE TITLE</th>
							<th scope="col">CATEGORY</th>
							<th scope="col">STATUS</th>
							<th scope="col">DOWNLOADED NOTES</th>
							<th scope="col">TOTAL EARNINGS</th>
							<th scope="col">DATE ADDED</th>
							<th scope="col">PUBLISHED DATE</th>
							<th scope="col"></th>
						</tr>
					</thead>
					<tbody><?php
while($row=mysqli_fetch_array($query_data)){
	$note_title=$row['Note_Title'];
	$category_id=$row['Category'];
	$status_id=$row['Status'];
	$publisheddate=$row['PublishedDate'];
	$createddate=$row['CreatedDate'];
	$noteid=$row['ID'];
	$query_category=mysqli_query($connection,"SELECT ID,Category_name FROM category WHERE ID=$category_id");
	if(!$query_category){
		echo mysqli_error($connection);
	}
	while($row1=mysqli_fetch_array($query_category)){
		$catgory_name=$row1['Category_name'];
	}
	$query_status=mysqli_query($connection,"SELECT ID,Value FROM referencedata WHERE ID=$status_id");
	if(!$query_status){
		echo mysqli_error($connection);
	}
	while($row1=mysqli_fetch_array($query_status)){
		$status_name=$row1['Value'];
	}
	
//downloaded notes
$query_download=mysqli_query($connection,"SELECT DISTINCT NoteID,DownloaderID FROM downloads WHERE SellerID=$id AND NoteID=$noteid");
if(!$query_download){
	echo mysqli_error($connection);
}
$count_download=mysqli_num_rows($query_download);

$query_earning=mysqli_query($connection,"SELECT DISTINCT NoteID,PurchasedPrice FROM downloads WHERE SellerID=$id AND NoteID=$noteid");
if(!$query_earning){
	echo mysqli_error($connection);
}
$total_earning=0;
while($row=mysqli_fetch_assoc($query_earning)){
	$price=$row['PurchasedPrice'];
	$total_earning=$price+$total_earning;	
}
echo "
<tr>
<td class='text-center'></td>
<td><a href='admin-note-details.php?noteid=$noteid'>$note_title</a></td>
<td>$catgory_name</td>
<td>$status_name</td>
<td class='text-center'><a href='admin-downloaded-notes.php'>$count_download</a></td>
<td class='text-center'>$total_earning</td>
<td>$createddate</td>
<td> ";if($publisheddate!=NULL)
echo $publisheddate;
else echo "NA"; echo "</td>
<td>
								<div class='dropleft'><a id='dropdownMenuLink' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><img src='images/images/dots.png'></a>
									<div class='dropdown-menu' aria-labelledby='dropdownMenuLink'>
										<a class='dropdown-item' href='admin-member-details.php?noteid=$noteid'>Download Notes</a>
									</div>
								</div>
							</td>
</tr>";
}
					?>
						
					</tbody>
				</table>
			</div>
		</div>

		



	</section>



	<div class="admin-footer">
		<hr>
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-sm-4">
					vesion 1.1.24
				</div>
				<div class="col-md-6 col-sm-8 text-right">
					<p>Copyright <span>&#169;</span> Tatvasoft All rights reserved.</p>
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
    $(document).ready(function () {
var rejectedNotesTable = $("#member-notes-table").DataTable({
    "order": [[ 5, "desc" ]],
    "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
        //debugger;
        var index = iDisplayIndexFull + 1;
        $("td:first", nRow).html(index);
        return nRow;
    },
    'sDom': '"top"i',
    "iDisplayLength": 5,
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
<script src="../front/js/datatables.js"></script>	

	<!--js-->
	<script src="js/script.js"></script>
</body>

</html>