<?php
include "db.php";
session_start();
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

if (isset($_GET['id']))
    $noteid = $_GET['id'];
else $noteid = 6;
$mail_sent = false;
$login = true;

if (isset($_SESSION['useremail'])) {
    $email = $_SESSION['useremail'];
    $buyergetter = mysqli_query($connection, "SELECT ID,LastName,FirstName FROM users WHERE EmailID='$email'");
    while ($row = mysqli_fetch_assoc($buyergetter)) {

        //buyer info getter
        $buyerid = $row['ID'];
        $full_name_buyer = $row['FirstName'] . " " . $row['LastName'];

        //seller info getter
        $seller_getter = mysqli_query($connection, "SELECT ID,Price,Note_Title,Category,Is_Paid FROM notes WHERE ID=$noteid");
        while ($row = mysqli_fetch_assoc($seller_getter)) {
            $sellerid = $row['ID'];
            $note_price = $row['Price'];
            $note_title = $row['Note_Title'];
            $category_id = $row['Category'];
			$sell_type=$row['Is_Paid'];
 
    $category = mysqli_query($connection, "SELECT Category_name FROM category WHERE ID='$category_id'");
    while ($row = mysqli_fetch_assoc($category)) {
        $category_name = $row['Category_name'];
    }}}
    $download_entry_checker = mysqli_query($connection, "SELECT ID FROM downloads WHERE NoteID=$noteid AND DownloaderID=$buyerid");
}



if (isset($_POST['single_download'])) {

    $attactments_getter = mysqli_query($connection, "SELECT Path,File_Name,Note_ID FROM notesattachement WHERE ID=$noteid");
    while ($row = mysqli_fetch_array($attactments_getter)) {
        $filepath = $row['Path'];
    }
    $file_getter = mysqli_query($connection, "SELECT Note_Title FROM notes WHERE ID=$noteid");
    while ($row = mysqli_fetch_array($file_getter)) {
        $title = $row['Note_Title'];
    }

    header('Cache-Control: public');
    header('Content-Description: File Transfer');
    header('Content-Disposition: attachment; filename=' . $filepath . '.pdf');
    header('Content-Type: application/pdf');
    header('Content-Transfer-Encoding:binary');
    readfile($filepath);

    $download_entry_number = mysqli_num_rows($download_entry_checker);
    if ($download_entry_number == 0 && $buyerid != $sellerid) {

        //insert query
        $attact_path_getter = mysqli_query($connection, "SELECT Path FROM notesattachement WHERE ID=$noteid");

        while ($row = mysqli_fetch_assoc($attact_path_getter)) {
            $path = $row['Path'];

            $download_entry = mysqli_query($connection, "INSERT INTO downloads(NoteID,SellerID,DownloaderID,
                           IsSellerHasAllowedDownload,AttactmentPath,IsAttachmentDownloaded,
                           AttactmentDownloadedDate,IsPaid,PurchasedPrice,NoteTitle,NoteCategory,
                           CreatedDate,CreatedBy,ModifiedDate,ModifiedBy)
                           VALUES($noteid,$sellerid,$buyerid,1,'$path',1,NOW(),5,'$note_price',
                           '$note_title','$category_name',NOW(),$buyerid,NOW(),$buyerid)");
        }
    }
}


if (isset($_POST['download_all'])) {
    $file_getter = mysqli_query($connection, "SELECT DISTINCT Note_Title FROM notes WHERE ID=$noteid");
    while ($row = mysqli_fetch_array($file_getter)) {
        $title = $row['Note_Title'];
    }
    $zipname = $title . '.zip';
    $zip = new ZipArchive;
    $zip->open($zipname, ZipArchive::CREATE);
    $query = mysqli_query($connection, "SELECT Path FROM notesattachement WHERE ID=$noteid");
    while ($row = mysqli_fetch_assoc($query)) {
        $attact_id = $row['Path'];
        $zip->addFile($attact_id);
    }
    $zip->close();
    header('Content-Type: application/zip');
    header('Content-disposition: attachment; filename=' . $zipname);
    header('Content-Length: ' . filesize($zipname));
    readfile($zipname);

    $download_entry_number = mysqli_num_rows($download_entry_checker);
    if ($download_entry_number == 0 && $buyerid != $sellerid) {

        //insert query
        $attact_path_getter = mysqli_query($connection, "SELECT Path FROM notesattachement WHERE ID=$noteid");

        while ($row = mysqli_fetch_assoc($attact_path_getter)) {
            $path = $row['Path'];
            $download_entry = mysqli_query($connection, "INSERT INTO downloads (NoteID,SellerID,DownloaderID,
                           IsSellerHasAllowedDownload,	AttachmentPath,IsAttachmentDownloaded,
                           AttachmentDownloadedDate,IsPaid,PurchasedPrice,NoteTitle,NoteCategory,
                           CreatedDate,CreatedBy,ModifiedDate,ModifiedBy)
                             VALUES($noteid,$sellerid,$buyerid,1,'$path',1,NOW(),5,'$note_price',
                             '$note_title','$category_name',NOW(),$buyerid,NOW(),$buyerid)");
        }
    }
}


if (isset($_POST['purchase_yes_box'])) {
    $download_entry_number = mysqli_num_rows($download_entry_checker);
    if ($download_entry_number == 0 && $buyerid != $sellerid) {
        //insert query
    
        $attact_path_getter = mysqli_query($connection, "SELECT Path FROM notesattachment WHERE ID=$noteid");

        while ($row = mysqli_fetch_assoc($attact_path_getter)) {
		 $path = $row['Path'];
		}
        //seller nane getter
        $seller_id_getter = mysqli_query($connection, "SELECT SellerID FROM notes WHERE ID=$noteid");
		if(!$seller_id_getter){
			echo mysqli_error($connection)."notes";
		}
        while ($row = mysqli_fetch_assoc($seller_id_getter))
            $seller_id = $row['SellerID'];
        $seller_name_getter = mysqli_query($connection, "SELECT FirstName,LastName,EmailID FROM users WHERE ID=$seller_id");
		if(!$seller_name_getter){
			echo mysqli_error($connection);
		}
        while ($row = mysqli_fetch_assoc($seller_name_getter)) {
            $full_name_seller = $row['FirstName'] . " " . $row['LastName'];
            $email_seller = $row['EmailID'];
        }
        //mail function
        require 'PHPMailer/Exception.php';
        require 'PHPMailer/PHPMailer.php';
        require 'PHPMailer/SMTP.php';

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $config_email = 'trainingm08@gmail.com ';
            $mail->Username = $config_email;
            $mail->Password = 'abc@08(mail)';

            // Sender and recipient settings
            $mail->setFrom($config_email, 'NotesMarketPlace');

            $mail->addAddress($email_seller);
            $mail->addReplyTo($config_email, 'NotesMarketPlace');

            $mail->IsHTML(true);
            $mail->Subject = "wants to purchase your notes";

            $mail->Body = "Hello $full_name_seller,<br>
 <br>
           We would like to inform you that, <Buyer name> wants to purchase your notes. Please see Buyer Requests tab and allow download access to Buyer if you have received the payment from him.<br> 
 
<br>
           Regards,<br>  Notes Marketplace ";

            $mail->AltBody = '';

            $mail->send();
            $mail_sent = true;
			?>
<script><?php
	if ($mail_sent) { ?>
    $("#confirm-purchase-popup").modal('hide');
    $("#thankyou-popup").modal('show');
<?php } ?></script><?php
        } catch (Exception $e) {
            echo "Error in sending email. Mailer Error: {$mail->ErrorInfo}";
        } 
    }


 } ?>


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
<form action="" method="post">
<!--when allows-->
	<div class="modal fade" id="thankyou-popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">

					<h5 class="modal-title text-center" id="thankyou"><img src="images/images/SUCCESS.png">
						<p>Thank you for Purchasing</p>
					</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<h3>Dear Smith,</h3>
					<p>As this is paid notes -you need to pay to seller rashil Shah offline. We will send him an email that you want to download this note. He may contact you further for payment process.
					<p>

					<p>In case, you have urgency.</p>
					<p>
						Please contact us on +919999999999.</p>
					<p>Once he receives the payment and acknowledge us- selected notes you can see over my downloads tab for download.</p>

					<p>Have a good day.</p>

				</div>

			</div>
		</div>
	</div>
	
	<!--for confiemation of paid notes-->
	<div class="popup-box">
                <div style="margin-top: 200px;" id="confirm-purchase-popup" class="modal fade" tabindex="-1"
                    role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <button type="button" class="close text-right popup-close-btn" data-dismiss="modal"
                                aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <div style="margin-top: -20px;" class="modal-body">
                                <h6 class="blue-font-24">Are you sure you want to download this Paid note? </h6>
                                <h6 style="margin-top: 20px;" class="dark-font-22"> Please confirm. </h6>
                                <div style="margin-top:15px;">
                                    <button type="submit" data-toggle='modal' style="margin-right: 30px;"
                                        name="purchase_yes_box"
                                        class="btn btn-primary blue-button-hover-white">yes</button>
                                    <button id="purchase_no_box"
                                        class="btn btn-primary blue-button-hover-white">no</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
	
	</div>
</form>
	<div id="note-detail">
		<div class="container">
			<div id="note-detail-1">
				<h3>Note Details</h3>

				<div class="row">
					<div class=" col-md-12 col-lg-7 col-sm-12 col-xs-12" id="note-detail-1-left">

						<div class="row">
							<div class=" col-lg-5 col-md-5 col-sm-5 col-sm-5 note-details-img">

								<img src="images/images/1.jpg">
							</div>
							<div class="col-sm-7 col-md-7 col-lg-7">
								<h4>Computer Science</h4>
								<h5>Sciences</h5>
								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Neque ipsum ducimus consequatur accusantium, veniam voluptatum et fugit sunt eum maxime commodi.</p>

								<div class="row">
									<div class="container">
									
									<?php
										
                                    if (isset($_SESSION['useremail'])) {
										
                                        
										
										$query="SELECT Is_Paid, Price FROM notes WHERE ID=$noteid";
										$result=mysqli_query($connection,$query);
										if(!$result){
											echo mysqli_error($connection);
										}
										while($row=mysqli_fetch_assoc($result)){
											$sell_type=$row['Is_Paid'];
											$sell_price=$row['Price'];
										}
										if ($sell_type==5) {
                                            $attactments_getter = mysqli_query($connection, "SELECT Note_ID FROM notesattachment WHERE Note_ID=$noteid");
											if(!$attactments_getter){
												echo mysqli_error($connection);
											}
                                            $attact_count = mysqli_num_rows($attactments_getter);
echo $attact_count;
                                            //if note has single attachement
                                            if ($attact_count <= 1) {
                                                echo "<form action='' method='POST'>";
                                                echo " <button type='submit' id='note-download' data-toggle='modal' name='single_download' class='btn btn-primary'>Download / $15</button>";
                                                echo "</form>";
                                                if ($sellerid == $buyerid)
                                                    echo "<h6>You Self own this note so downloading it won't display in the buyer request section</h6>";

                                                //if note has multiple attachements
                                            } else if ($attact_count > 1) {
                                    ?>
                                    <form action="" method="post">
                                        <button type='submit' id='note-download' data-toggle='modal' name='download_all' class='btn btn-primary' name='download_all'>download / $15</button>
                                    </form>
										
										
										<?php }
											
										
										
                                    } else if ($sell_type == 4) {
                                            echo " <button type='submit' id='note-download' class='btn btn-primary' data-toggle='modal'
                                        data-target='#confirm-purchase-popup' >download / &#36;$sell_price</button>";
                                            if ($sellerid == $buyerid)
                                                echo "<h6>You Self own this note so downloading it won't display in the buyer request section</h6>";
                                        }}else {
                                        echo " <button type='submit' id='note-download' class='btn btn-primary' href='login1.php'>Download / $15</button>";
										}
                                    
                                    ?>
									
									</div>

								</div>
							</div>
						</div>

					</div>



					<div class="col-md-12 col-lg-5  col-sm-12 col-xs-12" id="note-detail-1-right">
						<div class="row">
							<div class="note-right-heading col-4 col-lg-4 ">
								<h5>Institute:</h5>
							</div>
							<div class="note-description col-8">
								<h5>University of California</h5>
							</div>
						</div>
						<div class="row">
							<div class="note-right-heading col-md-5 col-sm-5 col-lg-5 col-sm-5">
								<h5>Country:</h5>
							</div>
							<div class="note-description col-md-7 col-sm-7 col-lg-7 col-sm-7 ">
								<h5>United State</h5>
							</div>
						</div>
						<div class="row">
							<div class="note-right-heading col-5">
								<h5>Course Name:</h5>
							</div>
							<div class="note-description col-7">
								<h5>Computer Engineering</h5>
							</div>
						</div>
						<div class="row">
							<div class="note-right-heading col-md-6 col-sm-6 col-lg-6 col-sm-6">
								<h5>Course Code:</h5>
							</div>
							<div class="note-description col-md-6 col-sm-6 col-lg-6 col-sm-6">
								<h5>248705</h5>
							</div>
						</div>
						<div class="row">
							<div class="note-right-heading col-4">
								<h5>Professor:</h5>
							</div>
							<div class="note-description col-8">
								<h5>Mr. Richard Brown</h5>
							</div>
						</div>
						<div class="row">
							<div class="note-right-heading col-md-6 col-sm-6 col-lg-6 col-sm-6">
								<h5>Number of Pages:</h5>
							</div>
							<div class="note-description col-md-6 col-sm-6 col-lg-6 col-sm-6">
								<h5>277</h5>
							</div>
						</div>
						<div class="row">
							<div class="note-right-heading col-6">
								<h5>Approved Date:</h5>
							</div>
							<div class="note-description col-6">
								<h5>November 25 2020</h5>
							</div>
						</div>
						<div class="row">
							<div class="note-right-heading col-md-5 col-sm-5 col-lg-5 col-sm-5">
								<h5>Rating:</h5>
							</div>
							<div class="note-description col-md-7 col-sm-7 col-lg-7 col-xs-7">
								<div class="row">
									<div class="col-md-8 col-sm-8 col-lg-5 ">
										<div class="notes-star">
											<img src="images/images/star.png">
											<img src="images/images/star.png">
											<img src="images/images/star.png">
											<img src="images/images/star.png">
											<img src="images/images/star-white.png">
										</div>
									</div>
									<h5>100 Reviews</h5>
								</div>
							</div>
						</div>
						<div class="note-right-heading note-red col-md-12 col-sm-12 sol-xs-12 col-lg-12">
							<h5>5 Users have marked this note as inappropriate</h5>
						</div>


					</div>
				</div>


			</div>
		</div>


		<!--bottom-->
		<div class="note-details-2 container">
			<div class="row no-gutters">
				<div class="col-md-12 col-sm-12 col-lg-6 col-xs-12">
					<div class="note-preview-box">
						<h3>Notes Preview</h3>

						<div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
							<div class="note-details-2-left">
								<iframe src="images/images/sample.pdf">

								</iframe>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-12 col-sm-12 col-lg-6 col-xs-12">
					<h3>Customer Review</h3>

					<div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
						<!--reviewer 1-->
						<div class="note-details-2-right">
							<div class="row">
								<div class="col-md-2 col-2 reviewer-img">
									<img src="images/images/reviewer-1.png">
								</div>
								<div class="col-md-10 col-10">
									<div class="reviewer-info">
										<h6>Richard Brown</h6>
										<div class="notes-star">
											<img src="images/images/star.png">
											<img src="images/images/star.png">
											<img src="images/images/star.png">
											<img src="images/images/star.png">
											<img src="images/images/star-white.png">
										</div>
										<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. </p>
									</div>
								</div>
							</div>

							<!--reviewer 2-->
							<div class="row">
								<div class="col-md-2 col-2 reviewer-img">
									<img src="images/images/reviewer-2.png">
								</div>
								<div class="col-md-10 col-10">
									<div class="reviewer-info">
										<h6>Alice Ortiaz</h6>
										<div class="notes-star">
											<img src="images/images/star.png">
											<img src="images/images/star.png">
											<img src="images/images/star.png">
											<img src="images/images/star.png">
											<img src="images/images/star-white.png">
										</div>
										<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut corporis nihil ullam.</p>
									</div>
								</div>
							</div>

							<!--reviewer 3-->
							<div class="row" id="reviewer-3">
								<div class="col-md-2 col-2 reviewer-img">
									<img src="images/images/reviewer-3.png">
								</div>
								<div class="col-md-10 col-10 ">
									<div class="reviewer-info">
										<h6>Sara Passmore</h6>
										<div class="notes-star">
											<img src="images/images/star.png">
											<img src="images/images/star.png">
											<img src="images/images/star.png">
											<img src="images/images/star.png">
											<img src="images/images/star-white.png">
										</div>
										<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut corporis nihil ullam recusandae.</p>
									</div>
								</div>
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

	<!--jquery-->
	<script src="js/jquery.js"></script>
	<!--bootstrap-->
	<script src="js/bootstrap/bootstrap.min.4.5.js"></script>

	<!--js-->
	<script src="js/script.js"></script>
</body>

</html>