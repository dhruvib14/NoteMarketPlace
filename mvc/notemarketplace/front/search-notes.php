<?php
   include "db.php";
?>
<?php session_start();
					echo $_SESSION['useremail'];?>

<!DOCTYPE html>
<html lang="en">


<head>

	<!--meta-->
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />

	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0 ,user-scalable=no">

	<title>Notes Marketplace </title>
	<!-- Favicon -->
	<link rel="shortcut icon" href="images/logo/favicon.ico">

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
		<nav id="navuser" class="navbar nav-notes navbar-fixed-top navbar-expand-lg navbar-light  ">
			<div class="container-fluid ">
				<div class="site-nav-wrapper">
					<div class="navbar-header navbar-brand">
						<a href="home.html"><img src="images/images/logo.png"> </a><span id="mobile-nav-open-btn">
							&#9776;</span>
					</div>
					<!--main menu-->
					<div class="collapse navbar-collapse">

						<ul class="navbar-nav  ">
							<li class="nav-item"><a class="smooth-scroll nav-link active" href="search-notes.php">Search Notes</a>
							<li class="nav-item"><a class="smooth-scroll nav-link" href="dashboard.php">Sell Your Notes</a></li>
							<li class="nav-item"><a class="smooth-scroll nav-link" href="faq-page.php">FAQ</a></li>
							<li class="nav-item"><a class="smooth-scroll nav-link " href="contactus.php">Contact Us</a></li>
							<li class="nav-item"><a class="smooth-scroll nav-link" id="button-nav" href="login1.php">
									<p>Login</p>
								</a></li>
						</ul>
					</div>
					<!--mobile menu-->
					<div id="mobile-nav">
						<div class="navbar-header">
							<a href="home.html"><img src="images/images/logo.png"></a>
							<!--mobile menu close button-->
							<span id="mobile-nav-close-btn">&times;</span>
						</div>

						<div id="mobile-nav-content">
							<ul class="navbar-nav">
								<li class="nav-item"><a class="smooth-scroll nav-link active" href="search-notes.php">Search Notes</a></li>
								<li class="nav-item"><a class="smooth-scroll nav-link" href="dashboard.php">Sell Your Notes</a></li>
								<li class="nav-item"><a class="smooth-scroll nav-link" href="faq-page.php">FAQ</a></li>
								<li class="nav-item"><a class="smooth-scroll nav-link " href="contactus.php">Contact Us</a></li>
								<li class="nav-item"><a class="smooth-scroll nav-link" id="button-nav" href="login1.php">
										<p>Login</p>
									</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</nav>


	</header>
	<div class="row">
		<div class="logo " id="search-logo">
			<h3 id="user-profile-logo">Search Notes</h3>
		</div>
	</div>

	<div id="search-filter-heading">
		<div class="container">
			<div class="row ">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<h4>Search and Filter notes</h4>
				</div>
			</div>
		</div>
	</div>
	<div id="search-section">
		<div class="container ">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div id="search-icon">
						<i class="fa fa-search"></i>
						<input id="search-note-main" type="text" class="form-control input-light-color" placeholder="Search your notes here...">
					</div>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div id="search-filters">
						<div class="row">
							<div class="col-lg-2 col-md-4 col-sm-4 col-6 search-type-gap">
								<select class="text-hidden form-control options-arrow-down">
									<option selected disabled>Select type</option>
									<option>Free</option>
									<option>Paid</option>
								</select>
							</div>
							<div class="col-lg-2 col-md-4 col-sm-4 col-6 search-type-gap">
								<select class="text-hidden form-control options-arrow-down">
									<option selected disabled>Select category</option>
									<option>PDF(Digital)</option>
									<option>Scanned</option>
									<option>Hard-Copy</option>
									<option>Hand-writing</option>
								</select>
							</div>
							<div class="col-lg-2 col-md-4 col-sm-4 col-6 search-type-gap">
								<select class="text-hidden form-control options-arrow-down">
									<option selected disabled>Select college university</option>
									<option>GTU</option>
									<option>STU</option>
									<option>Nirma</option>
									<option>Marwadi</option>
									<option>Delhi University</option>
									<option>MS University</option>
								</select>
							</div>
							<div class="col-lg-2 col-md-4 col-sm-4 col-6 search-type-gap">
								<select class="text-hidden form-control options-arrow-down">
									<option selected disabled>Select course</option>
									<option>Computer-science</option>
									<option>Mechanical Engineering</option>
									<option>Civil Engineering</option>
									<option>Electrical Engineering</option>
									<option>Automobile Engineering</option>
									<option>Drwing</option>
									<option>Bio-logy</option>
									<option>Arts-study</option>
								</select>
							</div>
							<div class="col-lg-2 col-md-4 col-sm-4 col-6 search-type-gap">
								<select class="text-hidden form-control options-arrow-down">
									<option selected disabled>Select country</option>
									<option>India</option>
									<option>Japan</option>
									<option>USA</option>
									<option>China</option>
									<option>Canada</option>
									<option>Australia</option>
									<option>Pakistan</option>
									<option>Tajikistan</option>
									<option>Taiwan</option>
								</select>
							</div>
							<div class="col-lg-2 col-md-4 col-sm-4 col-6 search-type-gap">
								<select class="text-hidden form-control options-arrow-down">
									<option selected disabled>Select rating</option>
									<option>5</option>
									<option>4</option>
									<option>3</option>
									<option>2</option>
									<option>1</option>
								</select>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="search-result">
		<div class="container">
			<div class="row ">
				<div id="search-result-heading">
					<div class="col-md-12 col-md-12 col-sm-12 col-12">
						<h2>Total 18 notes</h2>
					</div>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row ">
				<div class="col-lg-4 col-md-6 col-sm-6 col-12 single-book-selecter"><a href="note-details.html">
					
						<img src="images/images/search1.png" class="search-img-border" title="Click to View more" alt="Book Cover photo"></a>
					<div class="search-result-below-img">
						<ul>
							<li>
								<h3>
									Computer Operating System - Final Exam With Paper Solution
								</h3>
							</li>
						</ul>
						<div class="search-result-data">
							<img class="search-icon-resizer" src="images/images/university.png" alt="university">
							<h6 class="search-result-data-body">University of California, US</h6>
						</div>
						<div class="search-result-data">
							<img class="search-icon-resizer" src="images/images/pages.png" alt="book">
							<h6 class="search-result-data-body">204 Pages</h6>
						</div>
						<div class="search-result-data">
							<img class="search-icon-resizer" src="images/images/date.png" alt="calender">
							<h6 class="search-result-data-body">Thu, Nov 26 2020</h6>
						</div>
						<div class="search-result-data">
							<img class="search-icon-resizer" src="images/images/flag.png" alt="flag">
							<h6 class="search-result-data-body search-result-red">5 Users have marked this note as inappropriate</h6>
						</div>
						<div class="notes-rating">
							<div class="col-md-7 col-sm-8 col-8">
								<div class="rate">
									<input type="radio" id="star5" name="rate" value="5" />
									<label for="star5" title="text">5 stars</label>
									<input type="radio" id="star4" name="rate" value="4" />
									<label for="star4" title="text">4 stars</label>
									<input type="radio" id="star3" name="rate" value="3" />
									<label for="star3" title="text">3 stars</label>
									<input type="radio" id="star2" name="rate" value="2" />
									<label for="star2" title="text">2 stars</label>
									<input type="radio" id="star1" name="rate" value="1" />
									<label for="star1" title="text">1 star</label>
								</div>
							</div>
							<div class="col-md-5 col-sm-4 col-4">
								<p class="review-count">100 reviews</p>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6 col-sm-6 col-12 single-book-selecter"><a href="note-details.html">
						<img src="images/images/search2.png" class="img-fluid search-img-border" title="Click to View more" alt="Book Cover photo"></a>
					<div class="search-result-below-img">
						<ul>
							<li>
								<h3>
									Computer science
								</h3>
							</li>
						</ul>
						<div class="search-result-data">
							<img class="search-icon-resizer" src="images/images/university.png" alt="">
							<h6 class="search-result-data-body">University of California, US</h6>
						</div>
						<div class="search-result-data">
							<img class="search-icon-resizer" src="images/images/pages.png" alt="">
							<h6 class="search-result-data-body">204 Pages</h6>
						</div>
						<div class="search-result-data">
							<img class="search-icon-resizer" src="images/images/date.png" alt="">
							<h6 class="search-result-data-body">Thu, Nov 26 2020</h6>
						</div>
						<div class="search-result-data">
							<img class="search-icon-resizer" src="images/images/flag.png" alt="">
							<h6 class="search-result-data-body search-result-red">5 Users have marked this note as inappropriate</h6>
						</div>
						<div class="notes-rating">
							<div class="col-md-7 col-sm-8 col-8">
								<div class="rate">
									<input type="radio" id="star5" name="rate" value="5" />
									<label for="star5" title="text">5 stars</label>
									<input type="radio" id="star4" name="rate" value="4" />
									<label for="star4" title="text">4 stars</label>
									<input type="radio" id="star3" name="rate" value="3" />
									<label for="star3" title="text">3 stars</label>
									<input type="radio" id="star2" name="rate" value="2" />
									<label for="star2" title="text">2 stars</label>
									<input type="radio" id="star1" name="rate" value="1" />
									<label for="star1" title="text">1 star</label>
								</div>
							</div>
							<div class="col-md-5 col-sm-4 col-4">
								<p class="review-count">100 reviews</p>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6 col-sm-6 col-12 single-book-selecter"><a href="note-details.html">
						<img src="images/images/search3.png" class="img-fluid search-img-border" title="Click to View more" alt="Book Cover photo"></a>
					<div class="search-result-below-img">
						<ul>
							<li>
								<h3>
									basic Computer engineering tech india publication
								</h3>
							</li>
						</ul>
						<div class="search-result-data">
							<img class="search-icon-resizer" src="images/images/university.png" alt="">
							<h6 class="search-result-data-body">University of California, US</h6>
						</div>
						<div class="search-result-data">
							<img class="search-icon-resizer" src="images/images/pages.png" alt="">
							<h6 class="search-result-data-body">204 Pages</h6>
						</div>
						<div class="search-result-data">
							<img class="search-icon-resizer" src="images/images/date.png" alt="">
							<h6 class="search-result-data-body">Thu, Nov 26 2020</h6>
						</div>
						<div class="search-result-data">
							<img class="search-icon-resizer" src="images/images/flag.png" alt="">
							<h6 class="search-result-data-body search-result-red">5 Users have marked this note as inappropriate</h6>
						</div>
						<div class="notes-rating">
							<div class="col-md-7 col-sm-8 col-8">
								<div class="rate">
									<input type="radio" id="star5" name="rate" value="5" />
									<label for="star5" title="text">5 stars</label>
									<input type="radio" id="star4" name="rate" value="4" />
									<label for="star4" title="text">4 stars</label>
									<input type="radio" id="star3" name="rate" value="3" />
									<label for="star3" title="text">3 stars</label>
									<input type="radio" id="star2" name="rate" value="2" />
									<label for="star2" title="text">2 stars</label>
									<input type="radio" id="star1" name="rate" value="1" />
									<label for="star1" title="text">1 star</label>
								</div>
							</div>
							<div class="col-md-5 col-sm-4 col-4">
								<p class="review-count">100 reviews</p>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6 col-sm-6 col-12 single-book-selecter"><a href="note-details.html">
						<img src="images/images/search4.png" class="img-fluid search-img-border" title="Click to View more" alt="Book Cover photo"></a>
					<div class="search-result-below-img">
						<ul>
							<li>
								<h3>
									Computer science illuminated seventh edition
								</h3>
							</li>
						</ul>
						<div class="search-result-data">
							<img class="search-icon-resizer" src="images/images/university.png" alt="">
							<h6 class="search-result-data-body">University of California, US</h6>
						</div>
						<div class="search-result-data">
							<img class="search-icon-resizer" src="images/images/pages.png" alt="">
							<h6 class="search-result-data-body">204 Pages</h6>
						</div>
						<div class="search-result-data">
							<img class="search-icon-resizer" src="images/images/date.png" alt="">
							<h6 class="search-result-data-body">Thu, Nov 26 2020</h6>
						</div>
						<div class="search-result-data">
							<img class="search-icon-resizer" src="images/images/flag.png" alt="">
							<h6 class="search-result-data-body search-result-red">5 Users have marked this note as inappropriate</h6>
						</div>
						<div class="notes-rating">
							<div class="col-md-7 col-sm-8 col-8">
								<div class="rate">
									<input type="radio" id="star5" name="rate" value="5" />
									<label for="star5" title="text">5 stars</label>
									<input type="radio" id="star4" name="rate" value="4" />
									<label for="star4" title="text">4 stars</label>
									<input type="radio" id="star3" name="rate" value="3" />
									<label for="star3" title="text">3 stars</label>
									<input type="radio" id="star2" name="rate" value="2" />
									<label for="star2" title="text">2 stars</label>
									<input type="radio" id="star1" name="rate" value="1" />
									<label for="star1" title="text">1 star</label>
								</div>
							</div>
							<div class="col-md-5 col-sm-4 col-4">
								<p class="review-count">100 reviews</p>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6 col-sm-6 col-12 single-book-selecter"><a href="note-details.html">
						<img src="images/images/search5.png" class="img-fluid search-img-border" title="Click to View more" alt="Book Cover photo"></a>
					<div class="search-result-below-img">
						<ul>
							<li>
								<h3>
									the principles of Computer hardware - oxford
								</h3>
							</li>
						</ul>
						<div class="search-result-data">
							<img class="search-icon-resizer" src="images/images/university.png" alt="">
							<h6 class="search-result-data-body">University of California, US</h6>
						</div>
						<div class="search-result-data">
							<img class="search-icon-resizer" src="images/images/pages.png" alt="">
							<h6 class="search-result-data-body">204 Pages</h6>
						</div>
						<div class="search-result-data">
							<img class="search-icon-resizer" src="images/images/date.png" alt="">
							<h6 class="search-result-data-body">Thu, Nov 26 2020</h6>
						</div>
						<div class="search-result-data">
							<img class="search-icon-resizer" src="images/images/flag.png" alt="">
							<h6 class="search-result-data-body search-result-red">5 Users have marked this note as inappropriate</h6>
						</div>
						<div class="notes-rating">
							<div class="col-md-7 col-sm-8 col-8">
								<div class="rate">
									<input type="radio" id="star5" name="rate" value="5" />
									<label for="star5" title="text">5 stars</label>
									<input type="radio" id="star4" name="rate" value="4" />
									<label for="star4" title="text">4 stars</label>
									<input type="radio" id="star3" name="rate" value="3" />
									<label for="star3" title="text">3 stars</label>
									<input type="radio" id="star2" name="rate" value="2" />
									<label for="star2" title="text">2 stars</label>
									<input type="radio" id="star1" name="rate" value="1" />
									<label for="star1" title="text">1 star</label>
								</div>
							</div>
							<div class="col-md-5 col-sm-4 col-4">
								<p class="review-count">100 reviews</p>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6 col-sm-6 col-12 single-book-selecter"><a href="note-details.html">
						<img src="images/images/search6.png" class="img-fluid search-img-border" title="Click to View more" alt="Book Cover photo"></a>
					<div class="search-result-below-img">
						<ul>
							<li>
								<h3>
									the Computer book
								</h3>
							</li>
						</ul>
						<div class="search-result-data">
							<img class="search-icon-resizer" src="images/images/university.png" alt="">
							<h6 class="search-result-data-body">University of California, US</h6>
						</div>
						<div class="search-result-data">
							<img class="search-icon-resizer" src="images/images/pages.png" alt="">
							<h6 class="search-result-data-body">204 Pages</h6>
						</div>
						<div class="search-result-data">
							<img class="search-icon-resizer" src="images/images/date.png" alt="">
							<h6 class="search-result-data-body">Thu, Nov 26 2020</h6>
						</div>
						<div class="search-result-data">
							<img class="search-icon-resizer" src="images/images/flag.png" alt="">
							<h6 class="search-result-data-body search-result-red">5 Users have marked this note as inappropriate</h6>
						</div>
						<div class="notes-rating">
							<div class="col-md-7 col-sm-8 col-8">
								<div class="rate">
									<input type="radio" id="star5" name="rate" value="5" />
									<label for="star5" title="text">5 stars</label>
									<input type="radio" id="star4" name="rate" value="4" />
									<label for="star4" title="text">4 stars</label>
									<input type="radio" id="star3" name="rate" value="3" />
									<label for="star3" title="text">3 stars</label>
									<input type="radio" id="star2" name="rate" value="2" />
									<label for="star2" title="text">2 stars</label>
									<input type="radio" id="star1" name="rate" value="1" />
									<label for="star1" title="text">1 star</label>
								</div>
							</div>
							<div class="col-md-5 col-sm-4 col-4">
								<p class="review-count">100 reviews</p>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6 col-sm-6 col-12 single-book-selecter"><a href="note-details.html">
						<img src="images/images/search1.png" class="img-fluid search-img-border" title="Click to View more" alt="Book Cover photo"></a>
					<div class="search-result-below-img">
						<ul>
							<li>
								<h3>
									Computer Operating System -Final Exam With Paper Solution
								</h3>
							</li>
						</ul>
						<div class="search-result-data">
							<img class="search-icon-resizer" src="images/images/university.png" alt="">
							<h6 class="search-result-data-body">University of California, US</h6>
						</div>
						<div class="search-result-data">
							<img class="search-icon-resizer" src="images/images/pages.png" alt="">
							<h6 class="search-result-data-body">204 Pages</h6>
						</div>
						<div class="search-result-data">
							<img class="search-icon-resizer" src="images/images/date.png" alt="">
							<h6 class="search-result-data-body">Thu, Nov 26 2020</h6>
						</div>
						<div class="search-result-data">
							<img class="search-icon-resizer" src="images/images/flag.png" alt="">
							<h6 class="search-result-data-body search-result-red">5 Users have marked this note as inappropriate</h6>
						</div>
						<div class="notes-rating">
							<div class="col-md-7 col-sm-8 col-8">
								<div class="rate">
									<input type="radio" id="star5" name="rate" value="5" />
									<label for="star5" title="text">5 stars</label>
									<input type="radio" id="star4" name="rate" value="4" />
									<label for="star4" title="text">4 stars</label>
									<input type="radio" id="star3" name="rate" value="3" />
									<label for="star3" title="text">3 stars</label>
									<input type="radio" id="star2" name="rate" value="2" />
									<label for="star2" title="text">2 stars</label>
									<input type="radio" id="star1" name="rate" value="1" />
									<label for="star1" title="text">1 star</label>
								</div>
							</div>
							<div class="col-md-5 col-sm-4 col-4">
								<p class="review-count">100 reviews</p>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6 col-sm-6 col-12 single-book-selecter"><a href="note-details.html">
						<img src="images/images/search2.png" class="img-fluid search-img-border" title="Click to View more" alt="Book Cover photo"></a>
					<div class="search-result-below-img">
						<ul>
							<li>
								<h3>
									Computer science
								</h3>
							</li>
						</ul>
						<div class="search-result-data">
							<img class="search-icon-resizer" src="images/images/university.png" alt="">
							<h6 class="search-result-data-body">University of California, US</h6>
						</div>
						<div class="search-result-data">
							<img class="search-icon-resizer" src="images/images/pages.png" alt="">
							<h6 class="search-result-data-body">204 Pages</h6>
						</div>
						<div class="search-result-data">
							<img class="search-icon-resizer" src="images/images/date.png" alt="">
							<h6 class="search-result-data-body">Thu, Nov 26 2020</h6>
						</div>
						<div class="search-result-data">
							<img class="search-icon-resizer" src="images/images/flag.png" alt="">
							<h6 class="search-result-data-body search-result-red">5 Users have marked this note as inappropriate</h6>
						</div>
						<div class="notes-rating">
							<div class="col-md-7 col-sm-8 col-8">
								<div class="rate">
									<input type="radio" id="star5" name="rate" value="5" />
									<label for="star5" title="text">5 stars</label>
									<input type="radio" id="star4" name="rate" value="4" />
									<label for="star4" title="text">4 stars</label>
									<input type="radio" id="star3" name="rate" value="3" />
									<label for="star3" title="text">3 stars</label>
									<input type="radio" id="star2" name="rate" value="2" />
									<label for="star2" title="text">2 stars</label>
									<input type="radio" id="star1" name="rate" value="1" />
									<label for="star1" title="text">1 star</label>
								</div>
							</div>
							<div class="col-md-5 col-sm-4 col-4">
								<p class="review-count">100 reviews</p>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6 col-sm-6 col-12 single-book-selecter"><a href="note-details.html">
						<img src="images/images/search3.png" class="img-fluid search-img-border" title="Click to View more" alt="Book Cover photo"></a>
					<div class="search-result-below-img">
						<ul>
							<li>
								<h3>
									basic Computer engineering tech india publication
								</h3>
							</li>
						</ul>
						<div class="search-result-data">
							<img class="search-icon-resizer" src="images/images/university.png" alt="">
							<h6 class="search-result-data-body">University of California, US</h6>
						</div>
						<div class="search-result-data">
							<img class="search-icon-resizer" src="images/images/pages.png" alt="">
							<h6 class="search-result-data-body">204 Pages</h6>
						</div>
						<div class="search-result-data">
							<img class="search-icon-resizer" src="images/images/date.png" alt="">
							<h6 class="search-result-data-body">Thu, Nov 26 2020</h6>
						</div>
						<div class="search-result-data">
							<img class="search-icon-resizer" src="images/images/flag.png" alt="">
							<h6 class="search-result-data-body search-result-red">5 Users have marked this note as
								inappropriate</h6>
						</div>
						<div class="notes-rating">
							<div class="col-md-7 col-sm-8 col-8">
								<div class="rate">
									<input type="radio" id="star5" name="rate" value="5" />
									<label for="star5" title="text">5 stars</label>
									<input type="radio" id="star4" name="rate" value="4" />
									<label for="star4" title="text">4 stars</label>
									<input type="radio" id="star3" name="rate" value="3" />
									<label for="star3" title="text">3 stars</label>
									<input type="radio" id="star2" name="rate" value="2" />
									<label for="star2" title="text">2 stars</label>
									<input type="radio" id="star1" name="rate" value="1" />
									<label for="star1" title="text">1 star</label>
								</div>
							</div>
							<div class="col-md-5 col-sm-4 col-4">
								<p class="review-count">100 reviews</p>
							</div>
						</div>
					</div>
				</div>
			</div>
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
	<!-- pagination -->

	<div class="footer">
		<hr>
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
	<script src="js/bootstrap/bootstrap.min.4.5.js"></script>

	<!--js-->
	<script src="js/script.js"></script>
</body>

</html>