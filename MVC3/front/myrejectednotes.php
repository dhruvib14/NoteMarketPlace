<?php
include "db.php";
session_start();
if(isset($_SESSION['useremail'])){
	$email=$_SESSION['useremail'];
	
 $query="SELECT ID FROM users WHERE EmailID='$email'";
 $result=mysqli_query($connection,$query);
 if(!$result){
	 echo mysqli_error($connection);
 }


 while($row=mysqli_fetch_array($result)){
	 $userid=$row['ID'];
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

$downloader_Entry=mysqli_query($connection,"UPDATE downloads SET AttachmentDownloadedDate=NOW(),IsAttachmentDownloaded=1 WHERE NoteID=$noteid AND SellerID=$userid AND IsSellerHasAllowedDownload=1");

}
else{
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
	$downloader_Entry=mysqli_query($connection,"UPDATE downloads SET AttachmentDownloadedDate=NOW(),IsAttachmentDownloaded=1 WHERE NoteID=$noteid   AND IsSellerHasAllowedDownload=1");
}
}

if (isset($_POST['search'])) {

    $search_result = $_POST['search_result'];

    $query = "SELECT notes.ID,notes.Note_Title,notes.Category,notes.Admin_Remarks,notes.SellerID, category.Category_name FROM notes  LEFT JOIN users ON notes.SellerID =users.ID LEFT JOIN category ON notes.Category=category.ID WHERE (notes.Note_Title LIKE '%$search_result%' OR category.Category_Name LIKE '%$search_result%' OR notes.Admin_Remarks LIKE '%$search_result%') AND SellerID=$userid  AND notes.Status=10   ";

    $result = mysqli_query($connection, $query);
if(!$result){
	echo mysqli_error($connection);
}
   
} else {
    $query = "SELECT notes.ID,notes.Note_Title,notes.Category,notes.Admin_Remarks,notes.SellerID, category.Category_name FROM notes  LEFT JOIN users ON notes.SellerID =users.ID LEFT JOIN category ON notes.Category=category.ID WHERE SellerID=$userid AND notes.Status=10 ";
    $result = mysqli_query($connection, $query);
	if(!$result){
		echo mysqli_error($connection);
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
									<a class='dropdown-item active' href='myrejectednotes.php'>My Rejected Notes</a>
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
									<a class='dropdown-item active' href='myrejectednotes.php'>My Rejected Notes</a>
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
	<section class="mydownloadspage">
		<div class="container">
		<form action="myrejectednotes.php" method="post">
			<div class="row horizontal-heading no-gutters">
				<div class="col-md-6 col-sm-12 col-xs-12">
					<h3>My Rejected Notes</h3>
				</div>
				<div class="dashboard-search">
					<input type="text" class="form-control" id="search-text-dashboard" name="search_result" style="font-family:Sans-serif, FontAwesome" placeholder="&#xF002   Search">
					<button type="submit" class="btn btn-primary btn-search dashboard-btn" name="search">Search</button>
				</div>
			</div>
			<div class="table-responsive">
				<table class="table table-hover" id="rejected-notes-table">
					<thead>
						<tr>
							<th scope="col" class='text-center'>SR NO.</th>
							<th scope="col">NOTE TITLE</th>
							<th scope="col">CATEGORY</th>
							<th scope="col">REMARKS</th>
							<th scope="col">CLONE</th>
							<th scope="col"> </th>
						</tr>
					</thead>
					<tbody>
					
					<?php
                          $i=1;
						  
						            while ($row = mysqli_fetch_assoc($result)) {
                                $title = $row['Note_Title'];
								$category_id = $row['Category'];
								$query2="SELECT Category_name FROM category where ID=$category_id";
								$result2=mysqli_query($connection,$query2);
								while($row1=mysqli_fetch_assoc($result2)){
									$category=$row1['Category_name'];
								}
								$remark=$row['Admin_Remarks'];
								
								$noteid=$row['ID'];										
                                echo "  <tr>
                                        <td class='text-center'>" . $i++ . "</td>
                                        <td><a href='note-details.php?id=$noteid'>$title</a></td>
                                        <td>$category</td>
                                        <td>$remark</td>
										<td><a href='addnotes.php?id=$noteid'>Clone</a></td>
                                        <td class='text-center'>
                                        <div class='dropleft'>
										<a id='dropdownMenuLink' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><img src='images/images/dots.png'></a>
									    <div class='dropdown-menu dropleft' aria-labelledby='dropdownMenuLink'>
										<a class='dropdown-item' href='myrejectednotes.php?noteid=$noteid'>Download Note</a>
									</div>
								</div>
                                    </td>
                                    </tr>";
                            }
                            ?>
					</tbody>
				</table>
			</div><form>
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
	<script src="js/bootstrap/bootstrap.min.js"></script>
	<script>
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