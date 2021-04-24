<?php
   include "db.php";
?>
<?php session_start();?>

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
						<a href="home.php"><img src="images/images/logo.png"> </a><span id="mobile-nav-open-btn">
							&#9776;</span>
					</div>
					<!--main menu-->
					<div class="collapse navbar-collapse">

						<ul class="navbar-nav ">
							<li class="nav-item"><a class="smooth-scroll nav-link active" href="search-notes.php">Search Notes</a>
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
									<a class='dropdown-item' href='myrejectednotes.php'>My Rejected Notes</a>
									<a class='dropdown-item' href='change-password.php'>Change Password</a>
									<a class='dropdown-item dd-logout' href='logout.php'><p>Logout</p></a>
								</div>
							</li>";}
?>
<?php if(isset($_SESSION['useremail'])){echo "
							<li class='nav-item'><a class='smooth-scroll nav-link' id='button-nav' href='logout.php'>
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
							<li class="nav-item"><a class="smooth-scroll nav-link active" href="search-notes.php">Search Notes</a>
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
									<a class='dropdown-item' href='myrejectednotes.php'>My Rejected Notes</a>
									<a class='dropdown-item' href='change-password.php'>Change Password</a>
									<a class='dropdown-item dd-logout' href='logout.php'><p>Logout</p></a>
								</div>
							</li>";}
?>
<?php if(isset($_SESSION['useremail'])){echo "
							<li class='nav-item'><a class='smooth-scroll nav-link' id='button-nav' href='logout.php'>
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
	
	<div class="row"><div class="col-12">
	<div class="logo ">
			<img src="images/images/banner-home.jpg">
			<h3 id="user-profile-logo" class="text-center">Search Notes</h3>
		</div>
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
						<input id="search_all" type="text" onkeyup="showNotes()" class="form-control input-light-color" placeholder="Search your notes here...">
					</div>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div id="search-filters">
						<div class="row">
							<div class="col-lg-2 col-md-4 col-sm-4 col-6 search-type-gap">
								<select class="text-hidden form-control options-arrow-down" id="search_type" onchange="showNotes()">
								<option selected value="0" >Select type</option>
								<?php
                                        $result_type = mysqli_query($connection, "SELECT ID,Type_Name FROM type WHERE IsActive=1");
										if(!$result_type){
											echo mysqli_error($connection);
										}
                                        while ($row = mysqli_fetch_assoc($result_type)) {
                                            $type_id = $row['ID'];
                                            $type_name = $row['Type_Name'];
											
                                            echo "<option value='$type_id'>$type_name</option>";
                                        }
                                        ?>
								
								</select>
							</div>
							<div class="col-lg-2 col-md-4 col-sm-4 col-6 search-type-gap">
								<select class="text-hidden form-control options-arrow-down" id="search_category" onchange="showNotes()">
									<option selected value="0">Select category</option>
									<?php
                                        $result_category = mysqli_query($connection, "SELECT ID,Category_name FROM category WHERE IsActive=1");
										if(!$result_category){
											echo mysqli_error($connection);
										}
                                        while ($row = mysqli_fetch_assoc($result_category)) {
                                            $category_id = $row['ID'];
                                            $category_name = $row['Category_name'];
											
                                            echo "<option value='$category_id'>$category_name</option>";
                                        }
                                        ?>
								</select>
							</div>
							<div class="col-lg-2 col-md-4 col-sm-4 col-6 search-type-gap">
								<select class="text-hidden form-control options-arrow-down" id="search_university" onchange="showNotes()">
									<option selected value="0">Select college university</option>
									<?php
                                        $result_university = mysqli_query($connection, "SELECT DISTINCT University FROM notes WHERE IsActive=1");
										if(!$result_university){
											echo mysqli_error($connection);
										}
                                        while ($row = mysqli_fetch_assoc($result_university)) {
                                           
                                            $university_name = $row['University'];
											
                                            echo "<option value='$university_name'>$university_name</option>";
                                        }
                                        ?>
								</select>
							</div>
							<div class="col-lg-2 col-md-4 col-sm-4 col-6 search-type-gap">
								<select class="text-hidden form-control options-arrow-down" id="search_course" onchange="showNotes()">
									<option selected value="0">Select course</option>
									<?php
                                        $result_course = mysqli_query($connection, "SELECT DISTINCT Course,Course_Code FROM notes WHERE IsActive=1");
										if(!$result_course){
											echo mysqli_error($connection);
										}
                                        while ($row = mysqli_fetch_assoc($result_course)) {
                                           $course_id=$row['Course_Code'];
                                            $course_name = $row['Course'];
											
                                            echo "<option value='$course_id'>$course_name</option>";
                                        }
                                        ?>
								</select>
							</div>
							<div class="col-lg-2 col-md-4 col-sm-4 col-6 search-type-gap">
								<select class="text-hidden form-control options-arrow-down" id="search_country" onchange="showNotes()">
									<option selected value="0">Select country</option>
									<?php
                                        $result_course = mysqli_query($connection, "SELECT  ID,Country_Name FROM country WHERE IsActive=1");
										if(!$result_course){
											echo mysqli_error($connection);
										}
                                        while ($row = mysqli_fetch_assoc($result_course)) {
                                           $country_id=$row['ID'];
                                            $country_name = $row['Country_Name'];
											
                                            echo "<option value='$country_id'>$country_name</option>";
                                        }
                                        ?>
								</select>
							</div>
							<div class="col-lg-2 col-md-4 col-sm-4 col-6 search-type-gap">
								<select class="text-hidden form-control options-arrow-down"id="search_rating" onchange="showNotes()">
									<option selected value="0">Select rating</option>
									<?php
                                        $result_rating = mysqli_query($connection, "SELECT  DISTINCT ratings FROM review_rating WHERE IsActive=1");
										if(!$result_rating){
											echo mysqli_error($connection);
										}
                                        while ($row = mysqli_fetch_assoc($result_rating)) {
                                           
                                            $rating_name = $row['ratings'];
											
                                            echo "<option value='$rating_name'>$rating_name</option>";
                                        }
                                        ?>
								</select>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	
	

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
	<script type="text/javascript">
        function showNotes(page_current) {
            let search_str = $("#search_all").val();
            let search_type = $("#search_type").val();
            let search_category = $("#search_category").val();
            let search_university = $("#search_university").val();
            let search_course = $("#search_course").val();
            let search_country = $("#search_country").val();
            let search_rating = $("#search_rating").val();

            $.ajax({
                url: "search-note-ajax.php",
                method: "GET",
                data: {
                    selected_search: search_str,
                    selected_type: search_type,
                    selected_category: search_category,
                    selected_university: search_university,
                    selected_course: search_course,
                    selected_country: search_country,
                    selected_rating: search_rating,
                    page: page_current
                },
                success: function(search_data) {
                    $("#dynamic_result").html(search_data);
                }
            });
        }
        $(function() {
            showNotes(1);
        });
        </script>

        <!-- data from ajax will display in this  -->
        <div id="dynamic_result"></div>
	<!--jquery-->
	<script src="js/jquery.js"></script>
	<!--bootstrap-->
	<script src="js/bootstrap/bootstrap.min.4.5.js"></script>

	<!--js-->
	<script src="js/script.js"></script>
</body>

</html>