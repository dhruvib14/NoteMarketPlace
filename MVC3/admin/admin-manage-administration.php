<?php
include "../front/db.php";
session_start();

if(isset($_SESSION['useremail'])){

	$email=$_SESSION['useremail'];
	
	$query_id=mysqli_query($connection,"SELECT FIrstName,LastName,ID FROM users WHERE EmailID= '$email'");
	if(!$query_id){
		echo mysqli_error($connection);
	}
	while($row=mysqli_fetch_assoc($query_id)){
	$fname=$row['FIrstName'];
	$lname=$row['LastName'];
	$userID=$row['ID'];
	}
	
	$query=mysqli_query($connection,"SELECT Profile_Pic FROM users_details WHERE UserID=$userID");
		while($row=mysqli_fetch_array($query)){
			$profile_pic=$row['Profile_Pic'];
		}

	if(isset($_POST['search'])){
		$search_result=$_POST['search_result'];
	$query_search=mysqli_query($connection,"SELECT users.FirstName,users.LastName,users.EmailID,users.IsActive,users.CreatedDate,users.ID,users_details.Phone_No  FROM users LEFT JOIN users_details ON users.ID=users_details.UserID WHERE RoleID=2 AND (users.FirstName LIKE '%$search_result%' OR users.LastName LIKE '%$search_result%' OR users.EmailID LIKE '%$search_result%' OR users.CreatedDate LIKE '%$search_result%' OR users.IsActive LIKE '%$search_result%' OR users_details.Phone_No LIKE '%$search_result%') ORDER BY users.CreatedDate DESC");
	if(!$query_search){
		mysqli_error($connection);
	}
	}
	else{
		$query_search=mysqli_query($connection,"SELECT users.FirstName,users.LastName,users.EmailID,users.IsActive,users.CreatedDate,users.ID,users_details.Phone_No  FROM users LEFT JOIN users_details ON users.ID=users_details.UserID WHERE RoleID=2  ORDER BY users.CreatedDate DESC");
	if(!$query_search){
		mysqli_error($connection);
	}
	}
}
else{
	header("Location:../front/login1.php");
}


if(isset($_GET['delete_id'])){

	$deleteid=$_GET['delete_id'];
	$query_check_superadmin=mysqli_query($connection,"SELECT RoleID FROM users WHERE ID=$deleteid");
	while ($row=mysqli_fetch_assoc($query_check_superadmin)) {
		$roleid=$row['RoleID'];
	}
	if($roleid==3){}else{
	$query_delete=mysqli_query($connection,"UPDATE users SET IsActive=0 WHERE ID=$deleteid");
	if(!$query_delete){
		mysqli_error($connection);
	}
	}
	header("Location:admin-manage-administration.php");
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
							<li class="nav-item dropdown"><a class="smooth-scroll nav-link " href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Reports</a>
								<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
									<a class="dropdown-item active" href="admin-spamreports.php">Spam Reports</a>
								</div>
							</li>
							<li class="nav-item dropdown"><a class="smooth-scroll nav-link active" href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Settings</a>
								<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
									<a class="dropdown-item " href="admin-manage-system.php">Manage System Configuration</a>
									<a class="dropdown-item active" href="admin-manage-administration.php">Manage Administration</a>
									<a class="dropdown-item " href="admin-manage-category.php">Manage Category</a>

									<a class="dropdown-item" href="admin-manage-type.php">Manage Type</a>
									<a class="dropdown-item " href="admin-manage-country.php">Manage Countries</a>
								</div>
							</li>
							<li class="nav-item dropdown"><a class="smooth-scroll nav-link pic-nav" href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							
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
								<li class="nav-item dropdown"><a class="smooth-scroll nav-link active" href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Settings</a>
									<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
										<a class="dropdown-item " href="admin-manage-system.php">Manage System Configuration</a>
										<a class="dropdown-item active" href="admin-manage-administration.php">Manage Administration</a>
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

	<section id="in-progress-notes" class="admin-manage">
		<div class="container">
			<div class="admin-manage-admin">
				<div class="row horizontal-heading">
					<div class="col-md-6 ">
						<h3>Manage Administration</h3>
					</div>
				</div>
			</div>

			
			<div class="row no-gutters ">
			
				<div class="col-md-6 col-lg-6 col-sm-6 col-xs-12"><button type="submit" onclick="window.location.href='admin-add-administration.php'" class="btn btn-primary btn-admin dashboard-btn ">ADD ADMINISTRATION</button></div>
				<form action="" method="post"><div class="dashboard-search " style="margin-right:0px;">
				
					<input type="text" class="form-control" id="search-text-dashboard" placeholder="&#xF002  Search" name="search_result" style="font-family:Sans-serif, FontAwesome">
					<button type="submit" class="btn btn-primary btn-search dashboard-btn " name="search">Search</button>

				</div>
			</div></form>
		</div>


		<div class="container">
			<div class="table-responsive">
				<table class="table" id="manage-administration-table">
					<thead>
						<tr>
							<th scope="col" class="text-center">SR NO.</th>
							<th scope="col">FIRST NAME</th>
							<th scope="col">LAST NAME</th>
							<th scope="col">EMAIL</th>
							<th scope="col">PHONE NO.</th>
							<th scope="col">DATE ADDED</th>
							<th scope="col">ACTIVE</th>
							<th scope="col">ACTION</th>
						</tr>
					</thead>
					<tbody><?php
				
					while($row=mysqli_fetch_assoc($query_search)){
						$fname=$row['FirstName'];
						$lname=$row['LastName'];
						$email=$row['EmailID'];
						$phone_no=$row['Phone_No'];
						$added_date=$row['CreatedDate'];
						$active=$row['IsActive'];
						$admn_id_for_edit=$row['ID'];

if($active==1){
	$active="Yes";
}

elseif($active==0) {
	$active="No";
}
						echo "
						<tr>
						<td class='text-center'></td>
						<td>$fname</td>
						<td>$lname</td>
						<td>$email</td>
						<td>$phone_no</td>
						<td>$added_date</td>
						<td>$active</td>
						<td><a href='admin-add-administration.php?admin_id=$admn_id_for_edit' >
						<img src='images/images/edit.png' ></a>
						<a onclick='Delete(this);return false;' href='admin-manage-administration.php?delete_id=$admn_id_for_edit'><img src='images/images/delete.png'></a></td>
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
				<div class="col-md-6 col-sm-4 sol-xs-3">
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
	<!--bootstrap-->
	<script src="js/bootstrap/bootstrap.bundle.min.js"></script>
	<script src="js/bootstrap/bootstrap.min.js"></script>
	<script>
    $(document).ready(function () {

var rejectedNotesTable = $('#manage-administration-table').DataTable({
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