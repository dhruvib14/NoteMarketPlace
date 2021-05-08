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
if(isset($_GET['noteidapprove'])){
	$approveid=$_GET['noteidapprove'];
	$query_approve=mysqli_query($connection,"UPDATE notes SET Status=9,Actioned_By=$admin_id,ModifiedDate=NOW(),ModifiedBy=$admin_id WHERE ID=$approveid");
	header("Location:admin-rejected-notes.php");
}

if(isset($_GET['noteid'])){

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
					</div>
				</div>
			</div>
		</nav>


	</header>



	<section id="in-progress-notes" class="admin-manage">
		<div class="container">
			<div class="admin-manage-admin">
				<div class="row horizontal-heading">
					<div class="col-md-6">
						<h3>Rejected Notes</h3>
					</div>
				</div>
			</div>
<?php
			$select_seller=mysqli_query($connection,"SELECT DISTINCT notes.SellerID,users.FirstName FROM notes LEFT JOIN users ON notes.SellerID=users.ID");
if(!$select_seller){
	echo mysqli_error($connection);
}					
?>
			<div class="container seller-heading">Seller</div>
			<div class="row no-gutters">
				<div class="col-lg-6 col-12">
					<div class="col-lg-4 col-md-4 col-sm-4 col-6 search-type-gap seller">
					<select class="text-hidden form-control options-arrow-down" id="search_seller" onchange="showdata()">
							<option selected  value="0" disabled>Select Seller</option>
							<?php while($row=mysqli_fetch_assoc($select_seller)){
$seller_id=$row['SellerID'];
$seller=$row['FirstName'];
echo "
<option  value='$seller_id' >$seller</option>";
							}?>
						</select>
					</div>
				</div>
				
					<div class="dashboard-search">
					<input type="text" class="form-control" id="search_txt" placeholder="&#xF002   Search" style="font-family:Sans-serif, FontAwesome" >
					<button type="submit" class="btn btn-primary btn-search dashboard-btn " onclick="showdata();">Search</button>
				</div>

			</div>
		</div>


		<div class="container">
			<div class="table-responsive">
			<div id="dynamic_result"></div>				
		
				</div>
		</div>



	</section>



	<div class="admin-footer">
		<hr>
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-sm-4 col-xs-4">
					vesion 1.1.24
				</div>
				<div class="col-md-6 col-sm-8 col-xs-8 text-right">
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

	<!--js-->
	<script src="js/script.js"></script>
	<script type="text/javascript">
          function showdata(){
            let search_txt=$("#search_txt").val();    
			let search_seller = $("#search_seller").val();
            $.ajax({
              url:"ajax/admin-rejected-notes-ajax.php",
              type:"GET",
              data:{
				selected_seller: search_seller,
				selected_search: search_txt,
               
              },
              success:function(data){
                $("#dynamic_result").html(data);
              }
            });
          }
		  
		  $(function() {
            showdata(1);
        });
    </script>
</body>

</html>