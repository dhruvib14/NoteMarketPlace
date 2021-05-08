<?php
include "db.php";
session_start();
if(isset($_SESSION['useremail'])){

}
else{
	header("Location:login1.php");
}

if (isset($_POST['search'])) {

    $search_result = $_POST['search_result'];

    $query = "SELECT downloads.ID,downloads.DownloaderID,users.EmailID,users_details.Phone_No, downloads.NoteTitle,downloads.NoteID,downloads.NoteCategory,downloads.IsSellerHasAllowedDownload,referencedata.Value,downloads.PurchasedPrice,downloads.AttachmentDownloadedDate FROM downloads LEFT JOIN referencedata 
             ON downloads.IsPaid=referencedata.ID LEFT JOIN users ON downloads.DownloaderID=users.ID LEFT JOIN users_details ON users_details.UserID=downloads.DownloaderID  WHERE (NoteTitle LIKE '%$search_result%' OR referencedata.Value LIKE '%$search_result%' OR downloads.PurchasedPrice LIKE '%$search_result%' OR downloads.NoteCategory LIKE '%$search_result%') AND IsSellerHasAllowedDownload='0' ";

    $result = mysqli_query($connection, $query);
if(!$result){
	echo mysqli_error($connection);
}
} else {
    $query = "SELECT downloads.ID,downloads.DownloaderID,users.EmailID,users_details.Phone_No,downloads.NoteTitle,downloads.NoteID,downloads.NoteCategory,downloads.IsSellerHasAllowedDownload,referencedata.Value,downloads.PurchasedPrice,downloads.AttachmentDownloadedDate FROM downloads  LEFT JOIN referencedata ON downloads.IsPaid=referencedata.ID LEFT JOIN users ON downloads.DownloaderID=users.ID LEFT JOIN users_details ON users_details.UserID=downloads.DownloaderID WHERE IsSellerHasAllowedDownload='0' ";
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
								echo "<li class='nav-item active'><a class='smooth-scroll nav-link' href='buyer-request.php'>Buyer Request</a></li>";
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
							<li class="nav-item"><a class="smooth-scroll nav-link" href="dashboard.php">Sell Your Notes</a></li>
							<?php if(isset($_SESSION['useremail'])){
								echo "<li class='nav-item active'><a class='smooth-scroll nav-link' href='buyer-request.php'>Buyer Request</a></li>";
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
	<section class="mydownloadspage">
		<div class="container">
		<form action="buyer-request.php" method="post">
			<div class="row horizontal-heading no-gutters">
				<div class="col-md-6 col-lg-6 col-12">
					<h3>Buyer Requests</h3>
				</div>
				<div class="dashboard-search">
					<input type="text" class="form-control" id="search-text-dashboard" placeholder="&#xF002  Search" name="search_result" style="font-family:Sans-serif, FontAwesome">
				
					<button type="submit" class="btn btn-primary btn-search dashboard-btn " name="search">Search</button>
				</div>
			</div>
			<div class="table-responsive">
				<table class="table"id="buyer-request-table" >
					<thead>
						<tr>
							<th scope="col" class="text-center">SR NO.</th>
							<th scope="col">NOTE TITLE</th>
							<th scope="col">CATEGORY</th>
							<th scope="col">BUYER</th>
							<th scope="col">PHONE NO.</th>
							<th scope="col">SELL TYPE</th>
							<th scope="col">PRICE</th>
							<th scope="col">DOWNLOAD DATE/TIME</th>
							<th scope="col"></th>
						</tr>
					</thead>
					<tbody>
					
						<?php
                          $i=1;
						  
						            while ($row = mysqli_fetch_assoc($result)) {
                                $title = $row['NoteTitle'];
                                $category = $row['NoteCategory'];
                                $noteid=$row['NoteID'];
                                $price = $row['PurchasedPrice'];
								$phone_no=$row['Phone_No'];
								$email1=$row['EmailID'];
                                $time = $row['AttachmentDownloadedDate'];
								 $id=$row['ID'];
										 $refe_data = $row['Value'];
										
                                echo " 
                                    <tr>
                                        <td class='text-center'>" . $i++ . "</td>
                                        <td><a href='note-details.php?id=$noteid'>$title</a></td>
                                        <td>$category</td>
                                        <td>$email1</td>
                                        <td>$phone_no</td>
                                        <td>$refe_data</td>
                                        <td>&#36;$price</td>
                                        <td>$time</td>
                                        <td class='text-center'>
                                            <div class='dropleft'><a href='note-details.php?id=$noteid'><img src='images/images/eye.png' ></a>
											<a id='dropdownMenuLink' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><img src='images/images/dots.png'></a>
									<div class='dropdown-menu dropleft' aria-labelledby='dropdownMenuLink'>
										<a class='dropdown-item' href='allowdownload.php?id=$id'>Allow Download</a>

									</div>
								</div>
                                        </td>
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
				<div class="col-md-6  col-sm-5 col-xs-5 social-icons">
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

var rejectedNotesTable = $('#buyer-request-table').DataTable({
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