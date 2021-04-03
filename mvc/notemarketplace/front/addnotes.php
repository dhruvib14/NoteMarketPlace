<?php 
include "db.php";
session_start();
$profile_validation=true;
$file_validation=true;
$preview_validation=true;
if(isset($_SESSION["useremail"])){
	//seller id
	$email=$_SESSION["useremail"];
	$query="SELECT ID FROM users WHERE EmailID='$email'";
	$result=mysqli_query($connection, $query);
	
	while($row=mysqli_fetch_array($result)){
		$seller_id =$row['ID'];
	}
	
	
	if(isset($_POST['save'])){
		$title=$_POST['title'];
		$category=$_POST['category'];
		$type=$_POST['type'];
		$pages=$_POST['pages'];
		$description=$_POST['description'];
		$country=$_POST['country'];
	$institute_name=$_POST['institute_name'];
		$course_name=$_POST['course_name'];
		$course_code=$_POST['course_code'];
		$professor_name=$_POST['professor_name'];
		$sell_type=$_POST['sell_type'];
		$price=$_POST['price'];
		$default_display_pic = "../members/default/search1.jpg";
		
		//status 6 for draft
		$query="INSERT INTO notes(SellerID,Status,Note_Title,Category,Note_Display_Picture,Note_types,Note_pages,Description,University,Country,Course,Course_Code,Professor_Name,Is_Paid,Price,CreatedDate,CreatedBy,ModifiedDate,ModifiedBy,IsActive) VALUES ('$seller_id',6, '$title','$category','$default_display_pic','$type','$pages','$description','$institute_name','$country','$course_name','$course_code','$professor_name','$sell_type','$price',NOW(),'$seller_id',NOW(),'$seller_id',1 )";
		$result=mysqli_query($connection, $query);
		if($result){
			echo "insersted";
		}
		else{
			echo "not".mysqli_error($connection);
		
		}
	
	
	//to get above note id
        $note_id = mysqli_insert_id($connection);
	
        $profile_pic=$_FILES["upload_profile"];	
	    $filename=$profile_pic['name'];
	    $filetmp=$profile_pic['tmp_name'];
	$extension=explode('.',$filename);
	$filecheck=strtolower(end($extension));
	$fileextstored=array('jpg','png','jpeg');
	
	

		if (in_array($filecheck, $fileextstored)) {
            if (!is_dir("../members/")) {
                mkdir('../members/');
            }
            if (!is_dir("../members/" . $seller_id)) {
                mkdir("../members/" . $seller_id);
            }
            if (!is_dir("../members/" . $seller_id . "/" . $note_id)) {
                mkdir('../members/' . $seller_id . '/' . $note_id);
            }
            $destinationfile = '../members/' . $seller_id . '/' . $note_id . '/' . "DP_" . time() . '.' . $filecheck;
            move_uploaded_file($filetmp, $destinationfile);
            $query_pic = "UPDATE notes SET Note_Display_Picture='$destinationfile' WHERE ID=$note_id";
            $result_pic = mysqli_query($connection, $query_pic);
        } else {
            echo "upload failed".mysqli_error($connection);
			$profile_validation=false;
        }
	
		
	//upload notes for multiple files
	
		    $filename=$_FILES['upload_notes']['name'];
		
		foreach($_FILES['upload_notes']['name'] as $key=>$val){
			$filename=$_FILES['upload_notes']['name'][$key];
		
	$extension=explode('.',$filename);
	$filecheck=strtolower(end($extension));
	$fileextstored=array('pdf');
	

		if (in_array($filecheck, $fileextstored)) {
			
			$query="INSERT INTO notesattachment (Note_ID,CreatedDate,CreatedBy,IsActive)VALUES ($note_id,NOW(),$seller_id,1)";
			$result=mysqli_query($connection,$query);
			$attach_id=mysqli_insert_id($connection);
			
            if (!is_dir("../members/")) {
                mkdir('../members/');
            }
            if (!is_dir("../members/" . $seller_id)) {
                mkdir("../members/" . $seller_id);
            }
            if (!is_dir("../members/" . $seller_id . "/" . $note_id)) {
                mkdir('../members/' . $seller_id . '/' . $note_id);
            }
			if (!is_dir("../members/" . $seller_id . "/" . $note_id . "/" . "Attachements")) {
                    mkdir('../members/' . $seller_id . '/' . $note_id . '/' . 'Attachements');
                }

                $multiple_file_name = '../members/' . $seller_id . '/' . $note_id . '/' . 'Attachements/' . $attach_id . '_' . time() . '.' . $filecheck;
                move_uploaded_file($_FILES['upload_notes']['tmp_name'][$key], $multiple_file_name);
          $attached_name = $attach_id . "_" . time() . $filecheck;
			
            $query= "UPDATE notesattachment SET File_Name='$attached_name' ,Path='$multiple_file_name'  WHERE ID=$attach_id";
            $result = mysqli_query($connection, $query);
       
			
		} else {
            echo "upload failed attachment".mysqli_error($connection);
			$file_validation=false;
        }
		}
		//upload note preview
		$note_preview=$_FILES['note-preview'];	
	    $filename2=$note_preview['name'];
	    $filetmp2=$note_preview['tmp_name'];
	$extension2=explode('.',$filename2);
	$filecheck2=strtolower(end($extension2));
	$fileextstored2=array('jpg','png','jpeg');
	

		if (in_array($filecheck2, $fileextstored2)) {
            if (!is_dir("../members/")) {
                mkdir('../members/');
            }
            if (!is_dir("../members/" . $seller_id)) {
                mkdir("../members/" . $seller_id);
            }
            if (!is_dir("../members/" . $seller_id . "/" . $note_id)) {
                mkdir('../members/' . $seller_id . '/' . $note_id);
            }
            $destinationfile2 = '../members/' . $seller_id . '/' . $note_id . '/' . "Preview_" . time() . '.' . $filecheck2;
            move_uploaded_file($filetmp2, $destinationfile2);
            $query = "UPDATE notes SET NotesPreview='$destinationfile2' WHERE ID=$note_id";
            $result = mysqli_query($connection, $query);
        } else {
            echo "upload failed notes preview";
			$preview_validation=false;
        }
		
	}
	
	//for edit notes
	
	else if (isset($_GET['id'])) {
        $publish_note_id = $_GET['id'];
        $fetch_detail = mysqli_query($connection, "SELECT * FROM notes WHERE ID=$publish_note_id");

        while ($row = mysqli_fetch_assoc($fetch_detail)) {

            $category_id = "";
            $country_id = "";
            $sell_type_new = "";
            $title = $row['Note_Title'];
            $categories_id = $row['Category'];
            $type = $row['Note_types'];
            $note_pages = $row['Note_Pages'];
            $description = $row['Description'];
            $countries_id = $row['Country'];
            $institute_name = $row['University'];
            $course_name = $row['Course'];
            $course_code = $row['Course_Code'];
            $professor_name = $row['Professor_Name'];
            $sell_type_new = $row['Is_Paid'];
            $sell_price = $row['Price'];
        }

        $fetch_category = mysqli_query($connection, "SELECT Category_name FROM Category WHERE ID=$categories_id");
        while ($row = mysqli_fetch_assoc($fetch_category)) {
            $category_name = $row['Category_name'];
        }

        $fetch_type = mysqli_query($connection, "SELECT Type_Name FROM type WHERE ID =$type");
        while ($row = mysqli_fetch_assoc($fetch_type)) {
            $type_name = $row['Type_Name'];
        }

        $fetch_country = mysqli_query($connection, "SELECT Country_Name FROM country WHERE ID=$countries_id");
        while ($row = mysqli_fetch_assoc($fetch_country)) {
            $country_name = $row['Country_Name'];
        }
    }
	
	if (isset($_POST['save2'])) {

        $dashboard_noteid = $_POST['id_getter'] ;
        $title=$_POST['title'];
		$category=$_POST['category'];
		$type=$_POST['type'];
		$pages=$_POST['pages'];
		$description=$_POST['description'];
		$country=$_POST['country'];
	$institute_name=$_POST['institute_name'];
		$course_name=$_POST['course_name'];
		$course_code=$_POST['course_code'];
		$professor_name=$_POST['professor_name'];
		$sell_type=$_POST['sell_type'];
		$price=$_POST['price'];

        $query_insert_save = "UPDATE notes SET Note_Title='$title',Category=$category,
                                  Note_types=$type,Note_Pages=$pages,Description='$description',
                                  University='$institute_name',Country=$country,course='$course_name',
                                  Course_Code='$course_code',Professor_Name='$professor_name',Is_Paid=$sell_type,
                                  price='$price',modifieddate=NOW(), modifiedby=$seller_id 
                                  WHERE ID=$dashboard_noteid";

        $result_insert_save = mysqli_query($connection, $query_insert_save);

	$profile_pic=$_FILES["upload_profile"];	
	    $filename=$profile_pic['name'];
	    $filetmp=$profile_pic['tmp_name'];
	$extension=explode('.',$filename);
	$filecheck=strtolower(end($extension));
	$fileextstored=array('jpg','png','jpeg');
	
	

		if (in_array($filecheck, $fileextstored)) {
            if (!is_dir("../members/")) {
                mkdir('../members/');
            }
            if (!is_dir("../members/" . $seller_id)) {
                mkdir("../members/" . $seller_id);
            }
            if (!is_dir("../members/" . $seller_id . "/" . $dashboard_noteid)) {
                mkdir('../members/' . $seller_id . '/' . $dashboard_noteid);
            }
            $destinationfile = '../members/' . $seller_id . '/' . $dashboard_noteid . '/' . "DP_" . time() . '.' . $filecheck;
            move_uploaded_file($filetmp, $destinationfile);
            $query_pic = "UPDATE notes SET Note_Display_Picture='$destinationfile' WHERE ID=$dashboard_noteid";
            $result_pic = mysqli_query($connection, $query_pic);
        } else {
            echo "upload failed".mysqli_error($connection);
			$profile_validation=false;
        }
	
		
	//upload notes for multiple files
	
		    $filename=$_FILES['upload_notes']['name'];
		
		foreach($_FILES['upload_notes']['name'] as $key=>$val){
			$filename=$_FILES['upload_notes']['name'][$key];
		
	$extension=explode('.',$filename);
	$filecheck=strtolower(end($extension));
	$fileextstored=array('pdf');
	

		if (in_array($filecheck, $fileextstored)) {
			
			$query="INSERT INTO notesattachment (Note_ID,CreatedDate,CreatedBy,IsActive)VALUES ($dashboard_noteid,NOW(),$seller_id,1)";
			$result=mysqli_query($connection,$query);
			$attach_id=mysqli_insert_id($connection);
			
            if (!is_dir("../members/")) {
                mkdir('../members/');
            }
            if (!is_dir("../members/" . $seller_id)) {
                mkdir("../members/" . $seller_id);
            }
            if (!is_dir("../members/" . $seller_id . "/" . $dashboard_noteid)) {
                mkdir('../members/' . $seller_id . '/' . $dashboard_noteid);
            }
			if (!is_dir("../members/" . $seller_id . "/" . $dashboard_noteid. "/" . "Attachements")) {
                    mkdir('../members/' . $seller_id . '/' . $dashboard_noteid . '/' . 'Attachements');
                }

                $multiple_file_name = '../members/' . $seller_id . '/' . $dashboard_noteid . '/' . 'Attachements/' . $attach_id . '_' . time() . '.' . $filecheck;
                move_uploaded_file($_FILES['upload_notes']['tmp_name'][$key], $multiple_file_name);
          $attached_name = $attach_id . "_" . time() . $filecheck;
			
            $query= "UPDATE notesattachment SET File_Name='$attached_name' ,Path='$multiple_file_name'  WHERE ID=$attach_id";
            $result = mysqli_query($connection, $query);
       
			
		} else {
            echo "upload failed attachment".mysqli_error($connection);
			$file_validation=false;
        }
		}
		//upload note preview
		$note_preview=$_FILES['note-preview'];	
	    $filename2=$note_preview['name'];
	    $filetmp2=$note_preview['tmp_name'];
	$extension2=explode('.',$filename2);
	$filecheck2=strtolower(end($extension2));
	$fileextstored2=array('jpg','png','jpeg');
	

		if (in_array($filecheck2, $fileextstored2)) {
            if (!is_dir("../members/")) {
                mkdir('../members/');
            }
            if (!is_dir("../members/" . $seller_id)) {
                mkdir("../members/" . $seller_id);
            }
            if (!is_dir("../members/" . $seller_id . "/" . $dashboard_noteid)) {
                mkdir('../members/' . $seller_id . '/' . $dashboard_noteid);
            }
            $destinationfile2 = '../members/' . $seller_id . '/' . $dashboard_noteid . '/' . "Preview_" . time() . '.' . $filecheck2;
            move_uploaded_file($filetmp2, $destinationfile2);
            $query = "UPDATE notes SET NotesPreview='$destinationfile2' WHERE ID=$dashboard_noteid";
            $result = mysqli_query($connection, $query);
        } else {
            echo "upload failed notes preview";
        	$preview_validation=false;
		}
		
	}
	
	
	if (isset($_POST['publish'])) {

        $dashboard_noteid = $_POST['id_getter'] ;
        $title=$_POST['title'];
		$category=$_POST['category'];
		$type=$_POST['type'];
		$pages=$_POST['pages'];
		$description=$_POST['description'];
		$country=$_POST['country'];
	$institute_name=$_POST['institute_name'];
		$course_name=$_POST['course_name'];
		$course_code=$_POST['course_code'];
		$professor_name=$_POST['professor_name'];
		$sell_type=$_POST['sell_type'];
		$price=$_POST['price'];

        $query_insert_save = "UPDATE notes SET Note_Title='$title',Category=$category,
                                  Note_types=$type,Note_Pages=$pages,Description='$description',
                                  University='$institute_name',Country=$country,course='$course_name',
                                  Course_Code='$course_code',Professor_Name='$professor_name',Is_Paid=$sell_type,
                                  price='$price',modifieddate=NOW(), modifiedby=$seller_id 
                                  WHERE ID=$dashboard_noteid";

        $result_insert_save = mysqli_query($connection, $query_insert_save);

	$profile_pic=$_FILES["upload_profile"];	
	    $filename=$profile_pic['name'];
	    $filetmp=$profile_pic['tmp_name'];
	$extension=explode('.',$filename);
	$filecheck=strtolower(end($extension));
	$fileextstored=array('jpg','png','jpeg');
	
	

		if (in_array($filecheck, $fileextstored)) {
            if (!is_dir("../members/")) {
                mkdir('../members/');
            }
            if (!is_dir("../members/" . $seller_id)) {
                mkdir("../members/" . $seller_id);
            }
            if (!is_dir("../members/" . $seller_id . "/" . $dashboard_noteid)) {
                mkdir('../members/' . $seller_id . '/' . $dashboard_noteid);
            }
            $destinationfile = '../members/' . $seller_id . '/' . $dashboard_noteid . '/' . "DP_" . time() . '.' . $filecheck;
            move_uploaded_file($filetmp, $destinationfile);
            $query_pic = "UPDATE notes SET Note_Display_Picture='$destinationfile' WHERE ID=$dashboard_noteid";
            $result_pic = mysqli_query($connection, $query_pic);
        } else {
            echo "upload failed".mysqli_error($connection);
			$profile_validation=false;
        }
	
		
	//upload notes for multiple files
	
		    $filename=$_FILES['upload_notes']['name'];
		
		foreach($_FILES['upload_notes']['name'] as $key=>$val){
			$filename=$_FILES['upload_notes']['name'][$key];
		
	$extension=explode('.',$filename);
	$filecheck=strtolower(end($extension));
	$fileextstored=array('pdf');
	

		if (in_array($filecheck, $fileextstored)) {
			
			$query="INSERT INTO notesattachment (Note_ID,CreatedDate,CreatedBy,IsActive)VALUES ($dashboard_noteid,NOW(),$seller_id,1)";
			$result=mysqli_query($connection,$query);
			$attach_id=mysqli_insert_id($connection);
			
            if (!is_dir("../members/")) {
                mkdir('../members/');
            }
            if (!is_dir("../members/" . $seller_id)) {
                mkdir("../members/" . $seller_id);
            }
            if (!is_dir("../members/" . $seller_id . "/" . $dashboard_noteid)) {
                mkdir('../members/' . $seller_id . '/' . $dashboard_noteid);
            }
			if (!is_dir("../members/" . $seller_id . "/" . $dashboard_noteid. "/" . "Attachements")) {
                    mkdir('../members/' . $seller_id . '/' . $dashboard_noteid . '/' . 'Attachements');
                }

                $multiple_file_name = '../members/' . $seller_id . '/' . $dashboard_noteid . '/' . 'Attachements/' . $attach_id . '_' . time() . '.' . $filecheck;
                move_uploaded_file($_FILES['upload_notes']['tmp_name'][$key], $multiple_file_name);
          $attached_name = $attach_id . "_" . time() . $filecheck;
			
            $query= "UPDATE notesattachment SET File_Name='$attached_name' ,Path='$multiple_file_name'  WHERE ID=$attach_id";
            $result = mysqli_query($connection, $query);
       
			
		} else {
            echo "upload failed attachment".mysqli_error($connection);
			$file_validation=false;
        }
		}
		//upload note preview
		$note_preview=$_FILES['note-preview'];	
	    $filename2=$note_preview['name'];
	    $filetmp2=$note_preview['tmp_name'];
	$extension2=explode('.',$filename2);
	$filecheck2=strtolower(end($extension2));
	$fileextstored2=array('jpg','png','jpeg');
	

		if (in_array($filecheck2, $fileextstored2)) {
            if (!is_dir("../members/")) {
                mkdir('../members/');
            }
            if (!is_dir("../members/" . $seller_id)) {
                mkdir("../members/" . $seller_id);
            }
            if (!is_dir("../members/" . $seller_id . "/" . $dashboard_noteid)) {
                mkdir('../members/' . $seller_id . '/' . $dashboard_noteid);
            }
            $destinationfile2 = '../members/' . $seller_id . '/' . $dashboard_noteid . '/' . "Preview_" . time() . '.' . $filecheck2;
            move_uploaded_file($filetmp2, $destinationfile2);
            $query = "UPDATE notes SET NotesPreview='$destinationfile2' WHERE ID=$dashboard_noteid";
            $result = mysqli_query($connection, $query);
        } else {
            echo "upload failed notes preview";
        	$preview_validation=false;
		}
		
	}
	
        }
	
	
	
	
	


else {
	header('Location:login1.php');
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
	<script>
function text(x){
	if(x==0)
		document.getElementById("sell-price").style.display="none";
	else
			document.getElementById("sell-price").style.display="block";
	return;
}
		
	
</script>
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
	<section id="user-profile">
<form id="basic-note-form" method="post" action="addnotes.php" enctype="multipart/form-data">
		<div class="row">

			<div class="logo col-12">
				<div id="user-logo">

					<h3 id="user-profile-logo">Add Notes</h3>
				</div>
			</div>
			<div class="container">
				<h3> Basic Note Details</h3>
				

					<div class="form-group row .no-gutters">
						<div class="col-md-6 col-12 col-lg-6">
							<label id="fname" class="form-info" for="exampleInputName">Title *</label>
							<input type="name" class="form-control input-field" placeholder="Enter Your Notes title" name="title" value="<?php if(isset($_GET['id'])) echo $title?>" required>

						</div>
						<div class="form-group col-md-6 col-12 col-lg-6 ">
							<label for="phone-number">Category * </label>
							<div class="row no-gutters">
								<select class="form-control options-arrow-down" name="category">
							<?php 
	if(isset($_GET['id'])){
		echo "<option selected value='$categories_id'>$category_name</option>";
		$query_category = "SELECT ID,Category_name FROM category";
                                        $result_category = mysqli_query($connection, $query_category);

                                        while ($raw = mysqli_fetch_assoc($result_category)) {
                                            $categories = $raw['Category_name'];
                                            $category_id = $raw['ID'];
                                            echo "<option value='$category_id'>$categories</option>";}
	}
								   else{
	$query_category = "SELECT ID,Category_name FROM category";
                                        $result_category = mysqli_query($connection, $query_category);
                                        echo "<option value='' selected disabled>Select your Category</option>";

                                        while ($raw = mysqli_fetch_assoc($result_category)) {
                                            $categories = $raw['Category_name'];
                                            $category_id = $raw['ID'];
                                            echo "<option value='$category_id'>$categories</option>";}}?>
									
								</select>
							</div>
						</div>
					</div>

					<div class="form-group row">
						<div class="col-md-6 col-12 col-lg-6">
							<label for="profile">Profile Picture </label>
							<div class="user-profile-photo-uploader">
								<label for="image-uploader"><img src="images/images/upload-file.png" alt="upload your profile picture" ></label>
								<input type="file" id="image-uploader" class="form-control" placeholder="Upload a Picture" name="upload_profile" >
								<?php //if($profile_validation==false){
//echo "Please enter valid file format(JPG, PNG, JPEG ARE ONLY ALLOWED)";								
//}
?>
							</div>
						</div>
						<div class="col-md-6 col-12 col-lg-6">
							<label for="profile">Upload Notes </label>
							<div class="user-profile-photo-uploader">
								<label for="image-uploader"><img src="images/images/upload-note.png" alt="upload your notes"></label>
								<input type="file" id="image-uploader" class=" form-control" placeholder="Upload a notes" name="upload_notes[]" multiple>
								 <?php //if($profile_validation==false){
//echo "Please enter valid file format(PDF ARE ONLY ALLOWED)";								
//}
?>
							</div>
						</div>
					</div>
					
					<?php if (isset($_GET['id'])) {
                    $temp_id = $_GET['id']; ?>
                <input name="id_getter" <?php echo "value='$temp_id'"; ?> type="text"> <?php } ?>

					<div class="form-group row">
						<div class="form-group col-md-6 col-12 col-lg-6 no-gutters">
							<label for="exampleInputName ">Type *</label>
							<div class="row no-gutters">
								<select class="form-control options-arrow-down" name="type">
									
                                            <?php
									
	if(isset($_GET['id'])){
		echo "<option selected value='$type'>$type_name</option>";
	$query_category = "SELECT ID,Type_Name FROM type";
                                        $result_category = mysqli_query($connection, $query_category);
                                    

                                        while ($raw = mysqli_fetch_assoc($result_category)) {
                                            $type_name = $raw['Type_Name'];
                                            $type_id = $raw['ID'];
                                            echo "<option value='$type_id'>$type_name</option>";}
	}else{
									$query_category = "SELECT ID,Type_Name FROM type";
                                        $result_category = mysqli_query($connection, $query_category);
                                        echo "<option value='' selected disabled>Select your Category</option>";

                                        while ($raw = mysqli_fetch_assoc($result_category)) {
                                            $type_name = $raw['Type_Name'];
                                            $type_id = $raw['ID'];
                                            echo "<option value='$type_id'>$type_name</option>";}}?>
								</select>
							</div>
						</div>
						<div class="col-md-6 col-12 col-lg-6">
							<label class="form-info" for="exampleInputName">Number Of Pages *</label>
							<input type="name" class="form-control input-field" placeholder="Enter number of pages" name="pages" value="<?php if(isset($_GET['id'])) echo $note_pages?>" required>


						</div>

					</div>
					<div class="form-group row">
						<div class="col-md-12 col-12">
							<label id="fname" class="form-info" for="exampleInputName">Description *</label>
							<textarea class="form-control" id="exampleFormControlTextarea1" rows="4" placeholder="enter your description" name="description" ><?php if(isset($_GET['id'])) echo $description ?></textarea>
						</div>

					</div>
				
			</div>
		</div>

		<!--institute details-->

		<div class="row">
			<div class="container">
				<h3> Institution Deatils </h3>
				<div id="address-detail-form">
					<div class="form-group row">
						<div class="col-md-6 col-12 col-lg-6">
							<label class="add" for="country" >Country *</label>
							<select class="form-control options-arrow-down" name="country">
								<?php 
	if(isset($_GET['id'])){
		echo "<option value='$countries_id' selected >$country_name</option>";
		$query_category = "SELECT ID,Country_Name FROM country";
                                        $result_category = mysqli_query($connection, $query_category);

                                        while ($raw = mysqli_fetch_assoc($result_category)) {
                                            $countries = $raw['Country_Name'];
                                            $country_id = $raw['ID'];
                                            echo "<option value='$country_id'>$countries</option>";}
	}
								   else{
	
	$query_category = "SELECT ID,Country_Name FROM country";
                                        $result_category = mysqli_query($connection, $query_category);
                                        echo "<option value='' selected disabled>Select your Category</option>";

                                        while ($raw = mysqli_fetch_assoc($result_category)) {
                                            $countries = $raw['Country_Name'];
                                            $country_id = $raw['ID'];
                                            echo "<option value='$country_id'>$countries</option>";}}?>
							</select>
						</div>


						<div class="col-md-6 col-12 col-lg-6">
							<label class="add" for="city">Institution Name</label>
							<input type="address" class="form-control input-field" placeholder="Enter your institution name" name="institute_name" value="<?php if(isset($_GET['id'])) echo $institute_name?>" required>

						</div>
					</div>



				</div>
			</div>
		</div>

		<!--course details-->

		<div class="row">
			<div class="container">
				<h3> Course Deatils </h3>
				<div id="course-detail-form">
					<div class="form-group row">
						<div class="col-md-6 col-12 col-lg-6">
							<label class="course" for="exampleInputName">Course Name </label>
							<input type="text" class="form-control input-field" placeholder="Enter your coure name" name="course_name" value="<?php if(isset($_GET['id'])) echo $course_name ?>">

						</div>
						<div class="col-md-6 col-12 col-lg-6"> <label for="exampleInputName">Course Code </label>
							<input type="text" class="form-control input-field" placeholder="Enter your Course code" name="course_code" value="<?php if(isset($_GET['id'])) echo $course_code?>">
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 col-12 col-lg-6"> <label for="exampleInputName">Professor/ lecturer </label>
							<input type="text" class="form-control input-field" placeholder="Enter your professor name" name="professor_name" value="<?php if(isset($_GET['id'])) echo $professor_name?>">
						</div>
					</div>
				</div>
			</div>
		</div>


		<!--selling information details-->

		<div class="row">
			<div class="container">
				<h3> Selling Information </h3>
				<div id="selling-information-form">
					<div class="form-group row ">
						<div class="col-md-6 col-12 col-lg-6 ">
						
							<label class="course" for="exampleInputName">Sell For* </label>
							<div class="col-6 free-paid-radio-wrapper">
								
									<label class="purple-radio-input">
									
									<?php
	if(isset($_GET['id'])){
		?> <input type='radio' <?php if($sell_type_new==5) echo "checked";?> name='sell_type' value='5' onclick='text(0)'><span class='checkmark'></span><?php 
	}else{
										$query_note_mode = "SELECT ID FROM referencedata WHERE value='Free'";
                                                $result_note_mode = mysqli_query($connection, $query_note_mode);
                                                while ($row = mysqli_fetch_assoc($result_note_mode)) {
                                                    $note_type = $row['ID'];
                                                    echo "<input type='radio' name='sell_type' value='$note_type' onclick=" ."text(0)"."><span class='checkmark'></span>";}}?>
									</label><label class="info-label-check">Free</label>
									 
                                                
                                                
                                                
									<label class="purple-radio-input ">
									<?php	if(isset($_GET['id'])){
		?><input type='radio' <?php if($sell_type_new==4) echo "checked";?> name='sell_type' value='4' onclick='text(1)'><span class='checkmark'></span><?php
	}else{
										$query_note_mode = "SELECT ID FROM referencedata WHERE value='Paid'";
                                                $result_note_mode = mysqli_query($connection, $query_note_mode);
                                                while ($row = mysqli_fetch_assoc($result_note_mode)) {
                                                    $note_type = $row['ID'];
                                                    echo "<input type='radio' name='sell_type' checked value='$note_type' onclick=" ."text(1)"."><span class='checkmark'></span>";}}?>
								</label><label class="info-label-check">Paid</label>
								</div>
						</div>	

						<div class="col-md-6"> <label for="exampleInputName">Note preview </label>
							<div class="user-profile-photo-uploader picture-uploader">
								<label for="image-uploader"><img src="images/images/upload-file.png" alt="upload your profile picture"></label>
								<input type="file" id="image-uploader" class="picture-uploader form-control" placeholder="Upload a Picture" name="note-preview">
								
							</div>
						</div></div>
					
					<div class="row" id="sell-price">
						<div class="col-md-6 sell-price"> <label for="exampleInputName" >Sell Price * </label>
							<input type="text" class="form-control input-field" placeholder="Enter your price" name="price" value="<?php if(isset($_GET['id'])) echo $sell_price?>">
						</div>
					</div>
				</div>
			</div>
		</div>



		<div class="row">
			<div class="container">
			<?php
                            if (isset($_GET['id'])) { ?>
				<button type="submit" id="user-submit" class="btn btn-primary" name="save2">Save</button>
				<button type="submit" id="user-submit" class="btn btn-primary" onclick='javascript:Publish($(this));return false;' name="publish"  href='publish.php?id=".$noteid."'>publish</button><?php }
				else { ?>
				<button type="submit" id="user-submit" class="btn btn-primary" name="save">Save</button>
				<button type="submit" id="user-submit" class="btn btn-primary" disabled>publish</button><?php }?>
			</div>
		</div>
</form>
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
	<script src="js/bootstrap/bootstrap.min.4.5.js"></script>

	<!--js-->
	<script src="js/script.js"></script>
</body>

</html>