<?php
include "db.php";
$limit = 10;

if (isset($_GET["page"])) {
    $page  = $_GET["page"];
} else {
    $page = 1;
}
$start=($page *$limit) - $limit;
if (isset($_POST['search'])) {

    $search_result = $_POST['search_result'];

    $query = "SELECT downloads.ID, downloads.NoteTitle,downloads.NoteCategory,referencedata.Value,downloads.PurchasedPrice,downloads.AttachmentDownloadedDate FROM downloads LEFT JOIN referencedata 
             ON downloads.IsPaid=referencedata.ID WHERE NoteTitle LIKE '%$search_result%' LIMIT $start, $limit";

    $result = mysqli_query($connection, $query);
if(!$result){
	echo mysqli_error($connection);
}
	else{
		echo " search selected";
	}
    $result_num = mysqli_query($connection, "SELECT COUNT(downloads.ID) FROM downloads LEFT JOIN referencedata 
    ON downloads.IsPaid=referencedata.ID WHERE NoteTitle LIKE '%$search_result%'");

    $row = mysqli_fetch_row($result_num);
	
    $total_records = $row[0];
    $total_page = ceil($total_records / $limit);
} else  {

    $query = "SELECT downloads.ID,downloads.NoteTitle,downloads.NoteCategory,referencedata.Value,downloads.PurchasedPrice,downloads.AttachmentDownloadedDate FROM downloads LEFT JOIN referencedata ON downloads.IsPaid=referencedata.ID WHERE NoteTitle  LIMIT $start, $limit";

    $result = mysqli_query($connection, $query);
if(!$result){
	echo mysqli_error($connection);
}
	else{
		echo " elected";
	}
    $result_num = mysqli_query($connection, "SELECT COUNT(downloads.ID) FROM downloads LEFT JOIN referencedata 
    ON downloads.IsPaid=referencedata.ID");
	$row = mysqli_fetch_row($result_num);
    
	
	$total_records = $row[0];
	echo $total_records;
    $total_page = ceil($total_records / $limit);
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
	<link rel="shortcut icon" href="images/images/favicon.ico">
	<!--css-->
	<link rel="stylesheet" href="css/style.css">
	<!--responsive css-->
	<link rel="stylesheet" href="css/responsive.css">
</head>

<body>
	<!--header-->
	<!--header-->
	<header>
		<nav id="navuser" class="navbar nav-notes navbar-fixed-top navbar-expand-lg navbar-light nav-user-profile ">
			<div class="container-fluid ">
				<div class="site-nav-wrapper">
					<div class="navbar-header navbar-brand">
						<a href="home.php"><img src="images/images/logo.png"></a><span id="mobile-nav-open-btn">
							&#9776;</span>
					</div>
					<!--main menu-->

					<div class="collapse navbar-collapse" id="navbarSupportedContent">
						<ul class="navbar-nav pull-right mr-auto ">
							<li class="nav-item"><a class="smooth-scroll nav-link" href="search-notes.php">Search Notes</a></li>
							<li class="nav-item"><a class="smooth-scroll nav-link" href="dashboard.php">Sell Your Notes</a></li>
							<li class="nav-item"><a class="smooth-scroll nav-link" href="buyer-request.php">Buyer Request</a></li>
							<li class="nav-item"><a class="smooth-scroll nav-link" href="faq-page.php">FAQ</a></li>
							<li class="nav-item"><a class="smooth-scroll nav-link " href="contactus.php">Contact Us</a></li>
							<li class="nav-item dropdown"><a class="smooth-scroll nav-link pic-nav " href="#" id="navbardrop" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img src="images/images/user-img.png"></a>
								<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
									<a class="dropdown-item" href="user-profile.php">My Profile</a>
									<a class="dropdown-item" href="mydownloads.php">My Downloads</a>
									<a class="dropdown-item" href="sold-notes.php">My Sold Notes</a>
									<a class="dropdown-item" href="myrejectednotes.php">My Rejected Notes</a>
									<a class="dropdown-item" href="change-password.php">Change Password</a>
									<a class="dropdown-item dd-logout" href="logout.php"><p>Logout</p></a>
								</div>
							</li>
							<li class="nav-item"><a class="smooth-scroll nav-link" id="button-nav" href="logout.php">
									<p>Logout</p>
								</a></li>
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
							<ul class="navbar-nav nav">
								<li class="nav-item"><a class="smooth-scroll " href="search-notes.php">Search Notes</a></li>
								<li class="nav-item"><a class="smooth-scroll" href="dashboard.php">Sell Your Notes</a></li>
								<li class="nav-item"><a class="smooth-scroll " href="buyer-request.php">Buyer Request</a></li>
								<li class="nav-item"><a class="smooth-scroll" href="faq-page.php">FAQ</a></li>
								<li class="nav-item"><a class="smooth-scroll  " href="contactus.php">Contact Us</a></li>
								<li class="dropdown"><a class="smooth-scroll nav-link pic-nav " href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="images/images/user-img.png"></a>
									<div class="dropdown-menu pull-right" aria-labelledby="dropdownMenuLink">
										<a class="dropdown-item" href="user-profile.php">My Profile</a>
										<a class="dropdown-item" href="mydownloads.php">My Downloads</a>
										<a class="dropdown-item" href="sold-notes.php">My Sold Notes</a>
										<a class="dropdown-item" href="myrejectednotes.php">My Rejected Notes</a>
										<a class="dropdown-item" href="change-password.php">Change Password</a>
										<a class="dropdown-item dd-logout" href="logout.php"><p>Logout</p></a>
									</div>
								</li>
								<li class="nav-item"><a class="smooth-scroll " id="button-nav" href="logout.php">
										<p>Logout</p>
									</a></li>
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
			</div></form>
			<div class="table-responsive">
				<table class="table">
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
                                
                                $price = $row['PurchasedPrice'];
                                $time = $row['AttachmentDownloadedDate'];
								 $id=$row['ID'];
										 $refe_data = $row['Value'];
										
										
								
								
                                echo " 
                                    <tr>
                                        <td>" . $i++ . "</td>
                                        <td>$title</td>
                                        <td>$category</td>
                                        <td>Testing123@gmail.com</td>
                                        <td>+91 984549354937</td>
                                        <td>$refe_data</td>
                                        <td>&#36;$price</td>
                                        <td>$time</td>
                                        <td>
                                            <div class='dropleft'><img src='images/images/eye.png'><a id='dropdownMenuLink' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><img src='images/images/dots.png'></a>
									<div class='dropdown-menu dropleft' aria-labelledby='dropdownMenuLink'>
										<a class='dropdown-item' href='allowdownload.php?id=$id' >Allow Download</a>

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

		<!-- pagination -->
		<nav aria-label="Page navigation example" id="paging">
		<ul class="pagination justify-content-center">
		<?php
                echo "<li class='page-item'><a class='page-link' href='buyer-request.php?page=" . ($page - 1)
                    . "'><img src='images/images/left-arrow.png' alt='previous'></a></li>";
                for ($i = 1; $i <= $total_page; $i++) {
                    if ($i == $page) {
                        echo "<li class='page-item active'><a class='page-link' href='buyer-request.php?page=$i'>$i</a></li>";
                    } else echo "<li class='page-item'><a class='page-link' href='buyer-request?page=$i'>$i</a></li>";
                }
                echo "<li class='page-item'><a class='page-link' href='buyer-request.php?page=" . ($page + 1)
                    . "'><img style='color: white;' src='images/images/right-arrow.png' alt='next'></a></li>";
                ?>
			</ul>
			
		</nav>
		<!-- end pagination -->
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

	<!--js-->
	<script src="js/script.js"></script>
</body>

</html>