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
//fetching information

if(isset($_POST['search'])){
	$search_result=$_POST['search_result'];
$query_search=mysqli_query($connection,"SELECT DISTINCT users.FirstName,users.RoleID,users.LastName,users.EmailID,users.IsActive,users.CreatedDate,users.ID FROM users LEFT JOIN notes ON users.ID=notes.SellerID WHERE RoleID=1 AND (users.FirstName LIKE '%$search_result%' OR users.LastName LIKE '%$search_result%' OR users.EmailID LIKE '%$search_result%' OR users.CreatedDate LIKE '%$search_result%' OR users.EmailID LIKE '%$search_result%' ) AND users.IsActive=1 ORDER BY users.CreatedDate DESC");
if(!$query_search){
	mysqli_error($connection);
}
}
else{
	$query_search=mysqli_query($connection,"SELECT DISTINCT users.FirstName,users.RoleID,users.LastName,users.EmailID,users.IsActive,users.CreatedDate,users.ID FROM users LEFT JOIN notes ON users.ID=notes.SellerID WHERE RoleID=1 AND users.IsActive=1 ORDER BY users.CreatedDate DESC");
if(!$query_search){
	mysqli_error($connection);
}
}

}else {
	header("Location:../front/login1.php");
}

if(isset($_GET['adminid'])){
	$adminid=$_GET['adminid'];
	$query_deactivtae=mysqli_query($connection,"UPDATE users SET IsActive=0 WHERE ID=$adminid");
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
			<div class="admin-manage-admin admin-members">
			<form action="" method="post">
				<div class="row no-gutters horizontal-heading">
					<div class="col-lg-6 col-12">
						<h3>Members</h3>
					</div>

					<div class="dashboard-search">
						<input type="text" class="form-control" id="search-text-dashboard" placeholder="&#xF002  Search" name="search_result" style="font-family:Sans-serif, FontAwesome">
						<button type="submit" class="btn btn-primary  dashboard-btn " name="search">Search</button>
						</div>
				</div></form>
			</div>
		</div>


		<div class="container">
			<div class="table-responsive">
				<table class="table" id="members-table">
					<thead>
						<tr>
							<th scope="col">SR NO.</th>
							<th scope="col">FIRST NAME</th>
							<th scope="col">LAST NAME</th>
							<th scope="col">EMAIL</th>
							<th scope="col" class="wrap">JOINING DATE</th>
							<th scope="col" class="wrap text-center">UNDER REVIEW NOTES</th>
							<th scope="col" class="wrap text-center">PUBLISHED NOTES</th>
							<th scope="col" class="wrap text-center">DOWNLOADED NOTES</th>
							<th scope="col" class="wrap text-center">TOTAL EXPENSES</th>
							<th scope="col" class="wrap text-center">TOTAL EARNINGS</th>
							<th scope="col"></th>
						</tr>
					</thead>
					<tbody>

<?php
while($row=mysqli_fetch_array($query_search)){
	$fname=$row['FirstName'];
	$lname=$row['LastName'];
	$email=$row['EmailID'];
	$date=$row['CreatedDate'];
	$userid=$row['ID'];
	//under review
	$query_under_Review=mysqli_query($connection,"SELECT ID FROM notes WHERE SellerID=$userid AND STATUS=8");
	if(!$query_under_Review){
		echo mysqli_error($connection);
	}
$count_Review=mysqli_num_rows($query_under_Review);
//published
$query_published=mysqli_query($connection,"SELECT ID FROM notes WHERE SellerID=$userid AND STATUS=9");
	if(!$query_published){
		echo mysqli_error($connection);
	}
$count_publish=mysqli_num_rows($query_published);

//downloaded notes
$query_download=mysqli_query($connection,"SELECT DISTINCT NoteID,ID FROM downloads WHERE DownloaderID=$userid ");
	if(!$query_download){
		echo mysqli_error($connection);
	}
$count_download=mysqli_num_rows($query_download);

//expense
$query_Expense=mysqli_query($connection,"SELECT DISTINCT NoteID,PurchasedPrice FROM downloads WHERE DownloaderID=$userid");
if(!$query_Expense){
	echo mysqli_error($connection);
}
$total_expense=0;
while($row=mysqli_fetch_assoc($query_Expense)){
	$price=$row['PurchasedPrice'];
	$total_expense=$price+$total_expense;	
}

//earning
$query_earning=mysqli_query($connection,"SELECT DISTINCT NoteID,PurchasedPrice FROM downloads WHERE SellerID=$userid");
if(!$query_earning){
	echo mysqli_error($connection);
}
$total_earning=0;
while($row=mysqli_fetch_assoc($query_earning)){
	$price=$row['PurchasedPrice'];
	$total_earning=$price+$total_earning;	
}

echo "<tr>
<td class='text-center'></td>
<td>$fname</td>
<td>$lname</td>
<td>$email</td>
<td>$date</td>
<td class='text-center'><a href='admin-notes-under-review.php'>$count_Review</a></td>
<td class='text-center'><a href='admin-published-notes.php'>$count_publish</a></td>
<td class='text-center'><a href='admin-downloaded-notes.php'>$count_download</a></td>
<td class='text-center'><a href='admin-downloaded-notes.php'>$total_expense</a></td>
							<td class='text-center'>$total_earning</td>
							<td class='text-center'>
								<div class='dropleft'><a id='dropdownMenuLink' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><img src='images/images/dots.png'></a>
									<div class='dropdown-menu' aria-labelledby='dropdownMenuLink'>
										<a class='dropdown-item' href='admin-member-details.php?id=$userid'>View More Details</a>
										<a class='dropdown-item' href='admin-members.php?adminid=$userid' onclick='deactivate()'>Deactivate</a>
									</div>
								</div>
							</td>
							</tr>
";

}

?>		
					</tbody>
				</table>
			</div>
		</div>
	</section>


	<div class="footer">
		
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
    $(document).ready(function () {
var rejectedNotesTable = $("#members-table").DataTable({
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