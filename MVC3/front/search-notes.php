<?php
   include "db.php";
?>
<?php session_start();
if(isset($_SESSION["roleid"])){
	$roleid=$_SESSION["roleid"];
}?>

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
	<?php 
	include "header.php";
	?>
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
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div id="search-icon" style="margin-left:0px;">
						<input id="search_all" type="text" onkeyup="showNotes()" class="form-control input-light-color" placeholder="&#xF002  Search your notes here..." style="font-family:Sans-serif, FontAwesome">
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
									<option selected value="">Select college university</option>
									<?php
                                        $result_university = mysqli_query($connection, "SELECT DISTINCT University FROM notes WHERE IsActive=1");
										if(!$result_university){
											echo mysqli_error($connection);
										}
                                        while ($row = mysqli_fetch_assoc($result_university)) {
                                            $university_name = $row['University'];
											echo (!empty($university_name) && $university_name != "")
                                            ? "<option value='$university_name'>$university_name</option>":"";
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