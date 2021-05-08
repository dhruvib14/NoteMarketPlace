<?php
include "db.php";
session_start();
if(!isset($_SESSION["useremail"])){
	//header("Location:dashboard2.php");
}

if(isset($_SESSION["useremail"])){
	$email=$_SESSION["useremail"];

$userid_query=mysqli_query($connection,"SELECT ID FROM users WHERE EmailID='$email'");
if(!$userid_query){
	echo mysqli_error($connection);
}
while($row=mysqli_fetch_array($userid_query)){
	$userid=$row['ID'];
	
}
}
if (isset($_POST['progress-search'])) {

    $search_progress = $_POST['search'];

    $query = "SELECT notes.ID,notes.CreatedDate,notes.Note_Title, category.Category_name,referencedata.Value FROM notes LEFT JOIN  category ON notes.Category=category.ID LEFT JOIN referencedata ON notes.Status=referencedata.ID WHERE notes.Note_Title LIKE '%$search_progress%' OR notes.Category LIKE '%$search_progress%' OR notes.Status LIKE '%$search_progress%' AND notes.IsActive=1 AND referencedata.ID IN (6,7,8) ORDER BY notes.CreatedDate DESC";
	$result = mysqli_query($connection, $query);
		
}
else{
 	 $query = "SELECT notes.ID,notes.CreatedDate,notes.Note_Title, category.Category_name,referencedata.Value FROM notes LEFT JOIN  category ON notes.Category=category.ID LEFT JOIN referencedata ON notes.Status=referencedata.ID WHERE  notes.IsActive=1 AND referencedata.ID IN (6,7,8) ORDER BY notes.CreatedDate DESC ";
	$result = mysqli_query($connection, $query);

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
							<li class="nav-item"><a class="smooth-scroll nav-link " href="search-notes.php">Search Notes</a>
							<li class="nav-item"><a class="smooth-scroll nav-link active" href="dashboard.php">Sell Your Notes</a></li>
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
							<li class="nav-item"><a class="smooth-scroll nav-link active" href="dashboard.php">Sell Your Notes</a></li>
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

	<!--header ends-->
	<section id="statistics">
		<div class="container">
			<div class="row no-gutters horizontal-heading">
				<h3>Dashboard</h3>
				<button type="submit" class="btn btn-primary dashboard-btn"><a href="addnotes.php">Add note</a></button>
			</div>


			<div class="row">
				<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
					<div class="row no-gutters dashboard-left">

						<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
							<div class="my-earning-heading dashboard-box">
								<img src="images/images/earning-icon.svg" alt="earning">
								<p class="box-heading text-center">My Earning</p>
							</div>
						</div>
						<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
							<div class="numbers-of-notes dashboard-box"><a href="sold-notes.php">
						<?php 
								$query_sold_notes=mysqli_query($connection,"SELECT  DISTINCT NoteID FROM downloads WHERE IsSellerHasAllowedDownload='1'AND SellerID=$userid");
								if(!$query_sold_notes){
									echo mysqli_error($connection);
								}
								$row = mysqli_num_rows($query_sold_notes);
                               

								$query_earning=mysqli_query($connection,"SELECT SUM(PurchasedPrice) FROM downloads WHERE IsSellerHasAllowedDownload='1'AND SellerID=$userid ");
								$row1=mysqli_fetch_row($query_earning);
								$total_earning=$row1[0];
 
								$query_downloads=mysqli_query($connection,"SELECT DISTINCT NoteID FROM downloads WHERE IsSellerHasAllowedDownload='1'AND DownloaderID=$userid ");						
								$total_downloads=mysqli_num_rows($query_downloads);
								
								$query_rejected=mysqli_query($connection,"SELECT DISTINCT ID FROM notes WHERE Status='10' AND SellerID=$userid ");						
								$total_rejected=mysqli_num_rows($query_rejected);


								$query_buyer_Request=mysqli_query($connection,"SELECT DISTINCT NoteID FROM downloads WHERE IsSellerHasAllowedDownload='0' AND SellerID=$userid ");						
								$total_buyer_Request=mysqli_num_rows($query_buyer_Request);
								?>
									<p class="dashboard-single-details text-center"><?php echo $row;?></p>
									<p class="dashboard-detail-heading text-center">Numbers of Notes Sold</p>
								</a>
							</div>
						</div>

						<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
							<div class="money-earned dashboard-box"><a href="sold-notes.php">
									<p class="dashboard-single-details text-center">$<?php echo $total_earning;?></p>
									<p class="dashboard-detail-heading text-center">Money Earned</p>
								</a>
							</div>
						</div>
						

					</div>
				</div>
				
			</div>
		</div>

	</section>




	<section id="in-progress-notes">
		<div class="container">
		<form action="dashboard.php" method="post">
			<div class="row no-gutters horizontal-heading">
				<div class="col-md-12 col-lg-6 col-12">
					<h3>In Progress Notes</h3>
				</div>
				
				<div class="dashboard-search">
					<input type="text" class="form-control" id="search-text-dashboard" placeholder="&#xF002 Search" name="search" style="font-family:Sans-serif, FontAwesome">
					
					<button type="submit" class="btn btn-primary btn-search dashboard-btn " name="progress-search">Search</button>
				</div>
			</div></form>

			
			<div class=" table-responsive">
				<table class="table table-hover" id="progress-notes-table">
					<thead>
						<tr>
							<th scope="col" >ADDED DATE</th>
							<th scope="col">TITLE</th>
							<th scope="col">CATEGORY</th>
							<th scope="col">STATUS</th>
							<th scope="col" class="text-center">ACTIONS</th>
						</tr>
					</thead>
					<tbody>
						
						<?php
						 
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $date = $row['CreatedDate'];
                                        $title = $row['Note_Title'];
                                        $category_name = $row['Category_name'];
                                        $refe_data = $row['Value'];
                                        $noteid = $row['ID'];
                                        echo "<tr>
                                        <td >$date</td>
                                        <td>$title</td>
                                        <td>$category_name</td>
                                        <td>$refe_data</td>";
                                        if ($refe_data == 'Draft') {
                                            echo " <td class='text-center'>
                                            <a onclick='javascript:Delete($(this));return false;' href='delete.php?id=".$noteid."'><img src='images/images/delete.png'></a>
                                            <a href='addnotes.php?id=$noteid'>
                                            <img src='images/images/edit.png' title='Click to Edit' alt='edit'></a>
                                        </td>
                                    </tr>";
                                        } else {
                                            echo " <td class='text-center'>
                                       <a href='note-details.php?id=$noteid'>
                                            <img src='images/images/eye.png' title='Click to View' alt='View'>
                                            </a>";
						
						
								}	}?>
						
						
					</tbody>
				</table>
			</div>
		</div>
	</section>


<?php




if (isset($_POST['published-search'])) {

    $search_publish = $_POST['search-publish'];
    $query = "SELECT notes.ID,notes.PublishedDate,notes.Note_Title, category.Category_name,referencedata.Value,notes.Price FROM notes LEFT JOIN  category ON notes.Category=category.ID LEFT JOIN referencedata ON notes.Is_Paid=referencedata.ID WHERE( notes.Note_Title LIKE '%$search_publish%' OR notes.Category LIKE '%$search_publish%' OR notes.Price LIKE '%$search_publish%' OR referencedata.Value LIKE '%$search_publish%')AND notes.IsActive=1 AND notes.Status=9 ORDER BY notes.PublishedDate DESC ";
	$result2 = mysqli_query($connection, $query);
	if(!$result2){
		echo mysqli_error($connection);
	}

}
else{
	 $query = "SELECT notes.ID,notes.PublishedDate,notes.Note_Title, category.Category_name,referencedata.Value,notes.Price FROM notes LEFT JOIN  category ON notes.Category=category.ID LEFT JOIN referencedata ON notes.Is_Paid=referencedata.ID WHERE  notes.IsActive=1 AND notes.Status=9 ORDER BY notes.PublishedDate DESC ";
	$result2 = mysqli_query($connection, $query);
	
}
?>


	<section id="in-progress-notes">
		<div class="container"><form action="dashboard.php" method="post">
			<div class="row no-gutters horizontal-heading">
				<div class="col-md-12 col-lg-6 col-12">
					<h3>Published Notes</h3>
				</div>
				<div class="dashboard-search">
					<input type="text" class="form-control" id="search-text-dashboard" name="search-publish" placeholder="&#xF002 Search" style="font-family:Sans-serif, FontAwesome">
					<button type="submit" class="btn btn-primary btn-search dashboard-btn " name="published-search">Search</button>
				</div>
			</div>
			<div class="table-responsive">
				<table class="table table-hover" id="published-notes-table">
					<thead>
						<tr>
							<th scope="col" >ADDED DATE</th>
							<th scope="col">TITLE</th>
							<th scope="col">CATEGORY</th>
							<th scope="col">SELL TYPE</th>
							<th scope="col">PRICE</th>
							<th scope="col" class="text-center" class='text-center'>ACTIONS</th>
						</tr>
					</thead>
					<tbody>
						
						 <?php  
						 
                                while ($row = mysqli_fetch_assoc($result2)) {
                                    $date2 = $row['PublishedDate'];
                                    $title2 = $row['Note_Title'];
                                    $category_name2 = $row['Category_name'];
                                    $refe_data2 = $row['Value'];
                                    $sell_price = $row['Price'];
									$noteid=$row['ID'];
                                    echo "<tr>
                                        <td >$date2</td>
                                        <td>$title2</td>
                                        <td>$category_name2</td>
                                        <td>$refe_data2</td> 
                                        <td>$sell_price</td>
                                        <td class='text-center'> <a href='note-details.php?id=$noteid'><img src='images/images/eye.png' title='Click to View' alt='View'></a> </td>
                                         </tr>";
						  } 
                                ?>
						
					</tbody>
				</table>
			</div></form>
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
	
	<script type="text/javascript">

</script>

<script>
    $(document).ready(function () {

var rejectedNotesTable = $('#published-notes-table').DataTable({
    "order": [[ 4, "desc" ]],
    "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
        
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
var rejectedNotesTable = $('#progress-notes-table').DataTable({
    "order": [[ 4, "desc" ]],
    "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
      
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