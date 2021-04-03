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
</head>

<body>
	<!--header-->
	<header>
		<nav id="navuser" class="navbar nav-notes navbar-fixed-top navbar-expand-lg navbar-light nav-user-profile ">
			<div class="container-fluid ">
				<div class="site-nav-wrapper ">
					<div class="navbar-header navbar-brand">
						<a href="home.html"><img src="images/images/logo.png"> </a><span id="mobile-nav-open-btn">
							&#9776;</span>
					</div>
					<!--main menu-->

					<div class="collapse navbar-collapse">
						<ul class="navbar-nav nav pull-right ">
							<li class="nav-item"><a class="smooth-scroll nav-link" href="search-notes.html">Search Notes</a></li>
							<li class="nav-item"><a class="smooth-scroll nav-link" href="dashboard.html">Sell Your Notes</a></li>
							<li class="nav-item"><a class="smooth-scroll nav-link active" href="faq-page.html">FAQ</a></li>
							<li class="nav-item"><a class="smooth-scroll nav-link " href="contactus.html">Contact Us</a></li>
							<li class="nav-item"><a class="smooth-scroll nav-link" id="button-nav" href="login.html">
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
								<li class="nav-item"><a class="smooth-scroll nav-link" href="search-notes.html">Search Notes</a></li>
								<li class="nav-item"><a class="smooth-scroll nav-link" href="dashboard.html">Sell Your Notes</a></li>
								<li class="nav-item"><a class="smooth-scroll nav-link active" href="faq-page.html">FAQ</a></li>
								<li class="nav-item"><a class="smooth-scroll nav-link" href="contactus.html">Contact Us</a></li>
								<li class="nav-item"><a class="smooth-scroll nav-link" id="button-nav" href="login.html">
										<p>Login</p>
									</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</nav>


	</header>

	<!--header ends-->


	<div class="logo img-responsive ">
		<div id="user-logo">

			<h3 id="user-profile-logo" class="text-center">Frequently Asked Questions</h3>
		</div>
	</div>

	<section id="faq-page">
		<div class="container">
			<h3 class="faq-heading">General Questions</h3>
			<div class="faq"> <button type="button" class="collapsible" onclick="faqcollpase()">What is Note-Marketplaces?</button>
				<div class="content">
					<p> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dicta, veritatis fugiat, nemo et corporis accusantium dolor deleniti hic vel consequuntur dolorem nulla harum sequi magnam non! Porro aliquam accusamus iure.</p>
				</div>
			</div>
			<div class="faq">
				<button type="button" class="collapsible" onclick="faqcollpase()">What Do the unvidersity Say?</button>
				<div class="content">
					<p> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dicta, veritatis fugiat, nemo et corporis accusantium dolor deleniti hic vel consequuntur dolorem nulla harum sequi magnam non! Porro aliquam accusamus iure.</p>
				</div>
			</div>
			<div class="faq">
				<button type="button" class="collapsible" onclick="faqcollpase()">is this jegal?</button>
				<div class="content">
					<p> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dicta, veritatis fugiat, nemo et corporis accusantium dolor deleniti hic vel consequuntur dolorem nulla harum sequi magnam non! Porro aliquam accusamus iure.</p>
				</div>
			</div>


			<h3 class="faq-heading">Uploaders</h3>
			<div class="faq">
				<button type="button" class="collapsible" onclick="faqcollpase()">What Can't I sell?</button>
				<div class="content">
					<p> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dicta, veritatis fugiat, nemo et corporis accusantium dolor deleniti hic vel consequuntur dolorem nulla harum sequi magnam non! Porro aliquam accusamus iure.</p>
				</div>
			</div>
			<div class="faq">
				<button type="button" class="collapsible" onclick="faqcollpase()">What notes can I sell?</button>
				<div class="content">
					<p> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dicta, veritatis fugiat, nemo et corporis accusantium dolor deleniti hic vel consequuntur dolorem nulla harum sequi magnam non! Porro aliquam accusamus iure.</p>
				</div>
			</div>


			<h3 class="faq-heading">Downloaders</h3>
			<div class="faq">
				<button type="button" class="collapsible" onclick="faqcollpase()">How do I buy notes?</button>
				<div class="content">
					<p> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dicta, veritatis fugiat, nemo et corporis accusantium dolor deleniti hic vel consequuntur dolorem nulla harum sequi magnam non! Porro aliquam accusamus iure.</p>
				</div>
			</div>
			<div class="faq">
				<button type="button" class="collapsible" onclick="faqcollpase()">Can i edit the notes I purchased?</button>
				<div class="content">
					<p> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dicta, veritatis fugiat, nemo et corporis accusantium dolor deleniti hic vel consequuntur dolorem nulla harum sequi magnam non! Porro aliquam accusamus iure.</p>
				</div>
			</div>

		</div>


	</section>
	<div class="footer">
		<hr>
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<p>Copyright <span>&#169;</span> Tatvasoft All rights reserved.</p>
				</div>
				<div class="col-md-6 social-icons">
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