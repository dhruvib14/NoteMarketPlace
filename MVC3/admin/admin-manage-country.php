<?php
include "../front/db.php";
session_start();

if(isset($_SESSION['useremail'])){
	$email=$_SESSION['useremail'];
$query=mysqli_query($connection,"SELECT ID FROM users WHERE EmailID='$email'");
while($row=mysqli_fetch_array($query)){
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

if(isset($_POST['search'])){
	$search_result=$_POST['search_result'];
$query_search=mysqli_query($connection,"SELECT users.FirstName,users.LastName,country.Country_Name,country.Country_Code,country.CreatedDate,country.IsActive,country.ID FROM country LEFT JOIN users ON country.CreatedBy=users.ID WHERE users.FirstName LIKE '%$search_result%' OR users.LastName LIKE '%$search_result%' OR country.Country_Name LIKE '%$search_result%' OR country.Country_Code LIKE '%$search_result%' OR country.CreatedDate LIKE '%$search_result%' OR country.IsActive LIKE '%$search_result%' ORDER BY country.CreatedDate DESC");
if(!$query_search){
	mysqli_error($connection);
}
}
else{
	$query_search=mysqli_query($connection,"SELECT users.FirstName,users.LastName,country.Country_Name,country.Country_Code,country.CreatedDate,country.IsActive,country.ID FROM country LEFT JOIN users ON country.CreatedBy=users.ID ORDER BY country.CreatedDate DESC");
if(!$query_search){
	mysqli_error($connection);
}
}

if(isset($_GET['delete_id'])){
	$deleteid=$_GET['delete_id'];
	$query_delete=mysqli_query($connection,"UPDATE country SET IsActive=0 WHERE ID=$deleteid");
	if(!$query_delete){
		mysqli_error($connection);
	}
	
	header("Location:admin-manage-country.php");

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

							<li class="nav-item dropdown"><a class="smooth-scroll nav-link " href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Notes</a>
								<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
									<a class="dropdown-item" href="admin-notes-under-review.php">Notes Under Review</a>
									<a class="dropdown-item " href="admin-published-notes.php">Published Notes</a>
									<a class="dropdown-item" href="admin-downloaded-notes.php">Downloaded Notes</a>
									<a class="dropdown-item " href="admin-rejected-notes.php">Rejected Notes</a>
								</div>
							</li>
							<li class="nav-item"><a class="smooth-scroll nav-link" href="admin-members.php">Members</a></li>
							<li class="nav-item dropdown"><a class="smooth-scroll nav-link" href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Reports</a>
								<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
									<a class="dropdown-item" href="admin-spamreports.php">Spam Reports</a>
								</div>
							</li>
							<li class="nav-item dropdown"><a class="smooth-scroll nav-link active" href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Settings</a>
								<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
									<a class="dropdown-item " href="admin-manage-system.php">Manage System Configuration</a>
									<a class="dropdown-item " href="admin-manage-administration.php">Manage Administration</a>
									<a class="dropdown-item " href="admin-manage-category.php">Manage Category</a>

									<a class="dropdown-item" href="admin-manage-type.php">Manage Type</a>
									<a class="dropdown-item active" href="admin-manage-country.php">Manage Countries</a>
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
								<li class="nav-item"><a class="smooth-scroll nav-link " href="admin-members.php">Members</a></li>
								
								<li class="nav-item dropdown"><a class="smooth-scroll nav-link" href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Reports</a>
									<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
										<a class="dropdown-item" href="admin-spamreports.php">Spam Reports</a>
									</div>
								</li>
								<li class="nav-item dropdown"><a class="smooth-scroll nav-link active" href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Settings</a>
									<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
										<a class="dropdown-item " href="admin-manage-system.php">Manage System Configuration</a>
										<a class="dropdown-item " href="admin-manage-administration.php">Manage Administration</a>
										<a class="dropdown-item " href="admin-manage-category.php">Manage Category</a>

										<a class="dropdown-item" href="admin-manage-type.php">Manage Type</a>
										<a class="dropdown-item active" href="admin-manage-country.php">Manage Countries</a>
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
						<h3>Manage Country</h3>
					</div>
				</div>
			</div>

			<div class="row no-gutters">

				<div class="col-md-6"><button type="submit" class="btn btn-primary btn-admin  dashboard-btn " onclick="window.location.href='admin-add-country.php'">ADD country</button></div>
				<form action="admin-manage-country.php" method="post">
				<div class="dashboard-search">
				<input type="text" class="form-control" id="search-text-dashboard" placeholder="&#xF002  Search" name="search_result" style="font-family:Sans-serif, FontAwesome">
					
					<button type="submit" class="btn btn-primary btn-search dashboard-btn " name="search">Search</button>

				</div></form>
			</div>
		</div>


		<div class="container">
			<div class="table-responsive">
				<table class="table" id="country-table">
					<thead>
						<tr>
							<th scope="col">SR NO.</th>
							<th scope="col">COUNTRY NAME</th>
							<th scope="col">COUNTRY CODE</th>
							<th scope="col">DATE ADDED</th>
							<th scope="col">ADDED BY</th>
							<th scope="col">ACTIVE</th>
							<th scope="col">ACTION</th>
						</tr>
					</thead>
					<tbody>
					<?php
				
				while($row=mysqli_fetch_assoc($query_search)){
					$fname=$row['FirstName'];
					$lname=$row['LastName'];
					$country_name=$row['Country_Name'];
					$country_Code=$row['Country_Code'];
					$added_date=$row['CreatedDate'];
					$active=$row['IsActive'];
					$country_id=$row['ID'];

if($active==1){
$active="Yes";
}

elseif($active==0) {
$active="No";
}
					echo "
					<tr>
					<td class='text-center'></td>
					<td>$country_name</td>
					<td>$country_Code</td>
					<td>$added_date</td>
					<td>$fname $lname</td>
					<td>$active</td>
					<td><a href='admin-add-country.php?country_id=$country_id' >
					<img src='images/images/edit.png' ></a>
					<a onclick='Country(this);return false;' href='admin-manage-country.php?delete_id=$country_id'><img src='images/images/delete.png'></a></td>
					";
				}?>
					
					</tbody>
				</table>
			</div>
		</div>




	</section>



	<div class="admin-footer">
		<hr>
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-sm-4 col-xs-3 col-3">
					vesion 1.1.24
				</div>
				<div class="col-md-6 col-sm-8 col-xs-9 col-9 text-right">
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

var rejectedNotesTable = $('#country-table').DataTable({
    "order": [[ 4, "desc" ]],
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
<script src="js/datatables.js"></script>
	<!--js-->
	<script src="js/script.js"></script>
</body>

</html>