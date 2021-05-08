
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

						<ul class="navbar-nav">
							<li class="nav-item"><a class="smooth-scroll nav-link " href="search-notes.php">Search Notes</a>
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
									<a class='dropdown-item dd-logout' href='logout.php' onclick='javascript:logout($(this));return false;'><p>Logout</p></a>
								</div>
							</li>";}
?>
<?php if(isset($_SESSION['useremail'])){echo "
							<li class='nav-item'><a class='smooth-scroll nav-link' id='button-nav' onclick='javascript:logout($(this));return false;' href='logout.php'>
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
									<a class='dropdown-item dd-logout' onclick='javascript:logout($(this));return false;' href='logout.php'><p>Logout</p></a>
								</div>
							</li>";}
?>
<?php if(isset($_SESSION['useremail'])){echo "
							<li class='nav-item'><a class='smooth-scroll nav-link' id='button-nav' onclick='javascript:logout($(this));return false;'  href='logout.php'>
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
            <script src="js/jquery.js"></script>	
                        <script type="text/javascript">
                        $(document).on('click','ul li a', function(){
                            $(this).addClass('active').siblings().removeClass('active')
                        })
                        
                        </script>
		</nav>

	</header>
	<!--header ends-->