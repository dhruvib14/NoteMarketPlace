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
</head>

<body>
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
			<div class="row horizontal-heading no-gutters">
				<div class="col-md-6 col-lg-6 col-12">
					<h3>Published Notes</h3>
				</div>
				<div class="dashboard-search no-gutters">
					<input type="text" class="form-control" id="search-text-dashboard" placeholder="     Search">
					<i class="fa fa-search"></i>
					<button type="submit" class="btn btn-primary btn-search dashboard-btn ">Search</button>
				</div>
			</div>
			<div class="table-responsive">
				<table class="table table-hover">
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
						<tr>
							<td class="text-center">1</td>
							<td><a href="note-details.html" class="text-highlight">Data Science</a></td>
							<td>Science</td>
							<td>testting123@gmail.com</td>
							<td>Paid</td>
							<td>$250</td>
							<td>27 Nov 2020, 11:24:34</td>
							<td>
								<div class="dropleft"><a href="note-details.html"><img src="images/images/eye.png"></a><a id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="images/images/dots.png"></a>
									<div class="dropdown-menu dropleft" aria-labelledby="dropdownMenuLink">
										<a class="dropdown-item" href="#">Download Note</a>

									</div>
								</div>
							</td>
						</tr>
						<tr class="highlight">
							<td scope="row" class="text-center">2</td>
							<td><a href="note-details.html" class="text-highlight">Accounts</a></td>
							<td>Commerce</td>
							<td>testting123@gmail.com</td>
							<td>Free</td>
							<td>$0</td>
							<td>27 Nov 2020, 11:24:34</td>
							<td>
								<div class="dropleft"><a href="note-details.html"><img src="images/images/eye.png"></a><a id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="images/images/dots.png"></a>
									<div class="dropdown-menu dropleft" aria-labelledby="dropdownMenuLink">
										<a class="dropdown-item" href="#">Download Note</a>

									</div>
								</div>
							</td>
						</tr>
						<tr>
							<td scope="row" class="text-center">3</td>
							<td><a href="note-details.html" class="text-highlight">Social Studies</a></td>
							<td>Social</td>
							<td>testting123@gmail.com</td>
							<td>Free</td>
							<td>$0</td>
							<td>27 Nov 2020, 11:24:34</td>
							<td>
								<div class="dropleft"><a href="note-details.html"><img src="images/images/eye.png"></a><a id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="images/images/dots.png"></a>
									<div class="dropdown-menu dropleft" aria-labelledby="dropdownMenuLink">
										<a class="dropdown-item" href="#">Download Note</a>

									</div>
								</div>
							</td>

						</tr>
						<tr>
							<td scope="row" class="text-center">4</td>
							<td><a href="note-details.html" class="text-highlight">AI</a></td>
							<td>IT</td>
							<td>testting123@gmail.com</td>
							<td>Paid</td>
							<td>$158</td>
							<td>27 Nov 2020, 11:24:34</td>
							<td>
								<div class="dropleft"><a href="note-details.html"><img src="images/images/eye.png"></a><a id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="images/images/dots.png"></a>
									<div class="dropdown-menu dropleft" aria-labelledby="dropdownMenuLink">
										<a class="dropdown-item" href="#">Download Note</a>

									</div>
								</div>
							</td>
						</tr>
						<tr>
							<td scope="row" class="text-center">5</td>
							<td><a href="note-details.html" class="text-highlight">Lorem ipsum dolor sit amet</a></td>
							<td>Lorem</td>
							<td>testting123@gmail.com</td>
							<td>Free</td>
							<td>$0</td>
							<td>27 Nov 2020, 11:24:34</td>
							<td>
								<div class="dropleft"><a href="note-details.html"><img src="images/images/eye.png"></a><a id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="images/images/dots.png"></a>
									<div class="dropdown-menu dropleft" aria-labelledby="dropdownMenuLink">
										<a class="dropdown-item" href="#">Download Note</a>

									</div>
								</div>
							</td>
						</tr>
						<tr>
							<td class="text-center">6</td>
							<td><a href="note-details.html" class="text-highlight">Data Science</a></td>
							<td>Science</td>
							<td>testting123@gmail.com</td>
							<td>Paid</td>
							<td>$250</td>
							<td>27 Nov 2020, 11:24:34</td>
							<td>
								<div class="dropleft"><a href="note-details.html"><img src="images/images/eye.png"></a><a id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="images/images/dots.png"></a>
									<div class="dropdown-menu dropleft" aria-labelledby="dropdownMenuLink">
										<a class="dropdown-item" href="#">Download Note</a>

									</div>
								</div>
							</td>
						</tr>
						<tr>
							<td scope="row" class="text-center">7</td>
							<td><a href="note-details.html" class="text-highlight">Accounts</a></td>
							<td>Commerce</td>
							<td>testting123@gmail.com</td>
							<td>Free</td>
							<td>$0</td>
							<td>27 Nov 2020, 11:24:34</td>
							<td>
								<div class="dropleft"><a href="note-details.html"><img src="images/images/eye.png"></a><a id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="images/images/dots.png"></a>
									<div class="dropdown-menu dropleft" aria-labelledby="dropdownMenuLink">
										<a class="dropdown-item" href="#">Download Note</a>

									</div>
								</div>
							</td>
						</tr>
						<tr>
							<td scope="row" class="text-center">8</td>
							<td><a href="note-details.html" class="text-highlight">Social Studies</a></td>
							<td>Social</td>
							<td>testting123@gmail.com</td>
							<td>Free</td>
							<td>$0</td>
							<td>27 Nov 2020, 11:24:34</td>
							<td>
								<div class="dropleft"><a href="note-details.html"><img src="images/images/eye.png"></a><a id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="images/images/dots.png"></a>
									<div class="dropdown-menu dropleft" aria-labelledby="dropdownMenuLink">
										<a class="dropdown-item" href="#">Download Note</a>

									</div>
								</div>
							</td>
						</tr>
						<tr>
							<td scope="row" class="text-center">9</td>
							<td><a href="note-details.html" class="text-highlight">AI</a></td>
							<td>IT</td>
							<td>testting123@gmail.com</td>
							<td>Paid</td>
							<td>$158</td>
							<td>27 Nov 2020, 11:24:34</td>
							<td>
								<div class="dropleft"><a href="note-details.html"><img src="images/images/eye.png"></a><a id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="images/images/dots.png"></a>
									<div class="dropdown-menu dropleft" aria-labelledby="dropdownMenuLink">
										<a class="dropdown-item" href="#">Download Note</a>

									</div>
								</div>
							</td>
						</tr>
						<tr>
							<td scope="row" class="text-center">10</td>
							<td><a href="note-details.html" class="text-highlight">Lorem ipsum dolor sit amet</a></td>
							<td>Lorem</td>
							<td>testting123@gmail.com</td>
							<td>Free</td>
							<td>$0</td>
							<td>27 Nov 2020, 11:24:34</td>
							<td>
								<div class="dropleft"><a href="note-details.html"><img src="images/images/eye.png"></a><a id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="images/images/dots.png"></a>
									<div class="dropdown-menu dropleft" aria-labelledby="dropdownMenuLink">
										<a class="dropdown-item" href="#">Download Note</a>

									</div>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>

		<!-- pagination -->
		<nav aria-label="Page navigation example" id="paging">
			<ul class="pagination justify-content-center">
				<li class="page-item">
					<a class="page-link" href="" aria-label="Previous">
						<img src="images/images/left-arrow.png" alt="">
					</a>
				</li>
				<li class="page-item"><a class="page-link" href="#">1</a></li>
				<li class="page-item"><a class="page-link" href="#">2</a></li>
				<li class="page-item"><a class="page-link" href="#">3</a></li>
				<li class="page-item"><a class="page-link" href="#">4</a></li>
				<li class="page-item"><a class="page-link" href="#">5</a></li>
				<li class="page-item">
					<a class="page-link" href="" aria-label="Next">
						<img style="color: white;" src="images/images/right-arrow.png" alt="">
					</a>
				</li>
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

	<!--js-->
	<script src="js/script.js"></script>
</body>

</html>