<?php
include "../front/db.php";
session_start();

if(isset($_SESSION['useremail'])){
	$email=$_SESSION['useremail'];
	$query=mysqli_query($connection,"SELECT ID FROM users WHERE EmailID='$email'");
	while($row=mysqli_fetch_array($query)){
		$admin_id=$row['ID'];
	}
	$query=mysqli_query($connection,"SELECT Profile_Pic FROM users_details WHERE UserID=$admin_id");
		while($row=mysqli_fetch_array($query)){
			$profile_pic=$row['Profile_Pic'];
		}
}
else{
	header("Location:../front/login1.php");
}


if(isset($_GET['noteid'])){
	$noteid=$_GET['noteid'];
    $query="SELECT * FROM notesattachment WHERE Note_ID=$noteid";
	$result= mysqli_query($connection,$query);
$count=mysqli_num_rows($result);
while($row=mysqli_fetch_array($result)){
	$path=$row['Path'];
	
}
$query="SELECT Note_Title FROM notes WHERE ID=$noteid";
$result= mysqli_query($connection,$query);
while($row=mysqli_fetch_array($result)){
	$title=$row['Note_Title'];
}
if($count==1){
header('Cache-Control:public');
header('Content-Description:File Transfer');
header('Content-Disposition:attachment; filename='.$title.'.pdf');
header('Control-Type:application/pdf');
header('Content-Transfer-Encoding:binary');
readfile($path);

$downloader_Entry=mysqli_query($connection,"UPDATE downloads SET AttachmentDownloadedDate=NOW(),IsAttachmentDownloaded=1 WHERE NoteID=$noteid AND DownloaderID=$userid AND IsSellerHasAllowedDownload=1");

}
else{
	echo $title."title";
	$zipname = $title . '.zip';
    $zip = new ZipArchive;
    $zip->open($zipname, ZipArchive::CREATE);
    $query = mysqli_query($connection, "SELECT Path FROM notesattachment WHERE Note_ID=$noteid");
    while ($row = mysqli_fetch_assoc($query)) {
        $attact_id = $row['Path'];
        $zip->addFile($attact_id);
    }
    $zip->close();
    header('Content-Type: application/zip');
    header('Content-disposition: attachment; filename=' . $zipname);
    header('Content-Length: ' . filesize($zipname));
    readfile($zipname);
	$downloader_Entry=mysqli_query($connection,"UPDATE downloads SET AttachmentDownloadedDate=NOW(),IsAttachmentDownloaded=1 WHERE NoteID=$noteid AND DownloaderID=$userid  AND IsSellerHasAllowedDownload=1");
}

}
if(isset($_POST['search'])){
	$search_result=$_POST['search_result'];
$query_search=mysqli_query($connection,"SELECT reports.NoteID,users.FirstName,users.LastName,notes.Note_Title,notes.Category,reports.ID,reports.CreatedDate,reports.Remarks FROM reports  LEFT JOIN users ON reports.userID=users.ID  LEFT JOIN notes ON reports.NoteID=notes.ID WHERE users.FirstName LIKE '%$search_result%' OR users.LastName LIKE '%$search_result%'  OR reports.remarks LIKE '%$search_result%' OR reports.CreatedDate LIKE '%$search_result%' OR reports.IsActive LIKE '%$search_result%' AND reports.IsActive='1' ORDER BY reports.CreatedDate DESC");
if(!$query_search){
	 echo mysqli_error($connection);
}
}
else{
	$query_search=mysqli_query($connection,"SELECT reports.NoteID,users.FirstName,users.LastName,notes.Category,notes.Note_Title,reports.ID,reports.CreatedDate,reports.Remarks FROM reports  LEFT JOIN users ON reports.userID=users.ID  LEFT JOIN notes ON reports.NoteID=notes.ID WHERE reports.IsActive='1' ORDER BY reports.CreatedDate DESC");
if(!$query_search){
	echo mysqli_error($connection);
}

}

if(isset($_GET['delete_id'])){
	$deleteid=$_GET['delete_id'];
	$query_delete=mysqli_query($connection,"UPDATE reports SET IsActive=0 WHERE ID=$deleteid");
	if(!$query_delete){
		mysqli_error($connection);
	}
	header("Location:admin-spamreports.php");
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
     <link  rel="stylesheet" href="css/bootstrap/bootstrap.min.4.5.css">
     <!--css-->
     <link rel="stylesheet"  href="css/style.css">
<!--responsive css-->
     <link rel="stylesheet"  href="css/responsive.css">
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
						<a href="admin-dashboard.php"><img src="images/images/logo.png"></a><span id="mobile-nav-open-btn">
							&#9776;</span>
					</div>
					<!--main menu-->

					<div class="collapse navbar-collapse">
						<ul class="navbar-nav pull-right ">
							<li class="nav-item"><a class="smooth-scroll nav-link " href="admin-dashboard.php">Dashboard</a></li>

							<li class="nav-item dropdown"><a class="smooth-scroll nav-link " href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Notes</a>
								<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
									<a class="dropdown-item" href="admin-notes-under-review.php">Notes Under Review</a>
									<a class="dropdown-item " href="admin-published-notes.php">Published Notes</a>
									<a class="dropdown-item" href="admin-downloaded-notes.php">Downloaded Notes</a>
									<a class="dropdown-item " href="admin-rejected-notes.php">Rejected Notes</a>
								</div>
							</li>
							<li class="nav-item"><a class="smooth-scroll nav-link" href="admin-members.php">Members</a></li>
							<li class="nav-item dropdown"><a class="smooth-scroll nav-link active" href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Reports</a>
								<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
									<a class="dropdown-item active" href="admin-spamreports.php">Spam Reports</a>
								</div>
							</li>
							<li class="nav-item dropdown"><a class="smooth-scroll nav-link " href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Settings</a>
								<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
									<a class="dropdown-item " href="admin-manage-system.php">Manage System Configuration</a>
									<a class="dropdown-item " href="admin-manage-administration.php">Manage Administration</a>
									<a class="dropdown-item " href="admin-manage-category.php">Manage Category</a>

									<a class="dropdown-item" href="admin-manage-type.php">Manage Type</a>
									<a class="dropdown-item " href="admin-manage-country.php">Manage Countries</a>
								</div>
							</li>
							<li class="nav-item dropdown"><a class="smooth-scroll nav-link pic-nav " href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							
							<?php echo "<img src='$profile_pic'>";?></a>
								<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
									<a class="dropdown-item" href="admin-myprofile.php">Update Profile</a>
									<a class="dropdown-item" href="../front/change-password.php">Change Password</a>
									<a class="dropdown-item dd-logout" onclick='javascript:logout($(this));return false;' href="../front/logout.php"><p>Logout</p></a>
								</div>
							</li>
							<li class="nav-item"><a class="smooth-scroll nav-link" onclick='javascript:logout($(this));return false;' id="button-nav" href="../front/logout.php">
									<p>Logout</p>
								</a></li>
						</ul>
					</div>
					<!--mobile menu-->
					<div id="mobile-nav">
						<div class="navbar-header">
							<img src="images/images/logo.png">
							<!--mobile menu close button-->
							<span id="mobile-nav-close-btn">&times;</span>
						</div>

						<div id="mobile-nav-content">
							<ul class="navbar-nav  ">
								<li class="nav-item"><a class="smooth-scroll nav-link " href="admin-dashboard.php">Dashboard</a></li>

								<li class="nav-item dropdown"><a class="smooth-scroll nav-link " href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Notes</a>
									<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
										<a class="dropdown-item" href="admin-notes-under-review.php">Notes Under Review</a>
										<a class="dropdown-item " href="admin-published-notes.php">Published Notes</a>
										<a class="dropdown-item" href="admin-downloaded-notes.php">Downloaded Notes</a>
										<a class="dropdown-item " href="admin-rejected-notes.php">Rejected Notes</a>
									</div>
								</li>
								<li class="nav-item"><a class="smooth-scroll nav-link " href="admin-members.php">Members</a></li>
								
								<li class="nav-item dropdown"><a class="smooth-scroll nav-link active" href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Reports</a>
									<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
										<a class="dropdown-item active" href="admin-spamreports.php">Spam Reports</a>
									</div>
								</li>
								<li class="nav-item dropdown"><a class="smooth-scroll nav-link " href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Settings</a>
									<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
										<a class="dropdown-item " href="admin-manage-system.php">Manage System Configuration</a>
										<a class="dropdown-item " href="admin-manage-administration.php">Manage Administration</a>
										<a class="dropdown-item " href="admin-manage-category.php">Manage Category</a>

										<a class="dropdown-item" href="admin-manage-type.php">Manage Type</a>
										<a class="dropdown-item " href="admin-manage-country.php">Manage Countries</a>
									</div>
								</li>
								<li class="nav-item dropdown"><a class="smooth-scroll nav-link pic-nav " href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								
							<?php echo "<img src='$profile_pic'>";?></a>
									<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
										<a class="dropdown-item" href="admin-myprofile.php">Update Profile</a>
										<a class="dropdown-item" href="../front/change-password.php">Change Password</a>
										<a class="dropdown-item dd-logout" onclick='javascript:logout($(this));return false;' href="../front/logout.php"><p>Logout</p></a>
									</div>
								</li>
								<li class="nav-item"><a class="smooth-scroll nav-link" onclick='javascript:logout($(this));return false;' id="button-nav" href="../front/logout.php">
										<p>Logout</p>
									</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</nav>


	</header>

   
 <section id="in-progress-notes"  class="admin-manage">
   <div class="container">
       <div class="admin-manage-admin admin-members">

       <form action="admin-spamreports.php" method="post">
        <div class="row no-gutters horizontal-heading">
           <div class="col-md-12 col-sm-12 col-lg-6 col-12">
            <h3>Spam Reports</h3></div>
            
              <div class="dashboard-search"> 
                <input type="text" class="form-control" id="search-text-dashboard"  placeholder="&#xF002  Search" name="search_result" style="font-family:Sans-serif, FontAwesome">
                
                <button type="submit"  class="btn btn-primary btn-search dashboard-btn" name="search">Search</button>
                </div>
                </div>
		   </div></div></form>
     
    <div class="container">
     <div class="table-responsive">
      <table class="table" id="spamreports-table">
  <thead>
    <tr>
      <th scope="col" class="text-center">SR NO.</th>
      <th scope="col">REPORTED BY</th>
      <th scope="col">NOTE TITLE</th>
      <th scope="col">CATEGORY</th>
       <th scope="col">DATE EDITED</th>
       <th scope="col">REMARK</th>
      <th scope="col">ACTION</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
  <?php
				
				while($row=mysqli_fetch_assoc($query_search)){
					$fname=$row['FirstName'];
					$lname=$row['LastName'];
					$category_id=$row['Category'];
					$note_title=$row['Note_Title'];
					$added_date=$row['CreatedDate'];
			$remark=$row['Remarks'];
					$report_id=$row['ID'];
					$noteid=$row['NoteID'];
$query_category=mysqli_query($connection,"SELECT ID,Category_name FROM category WHERE ID=$category_id");
while($row=mysqli_fetch_assoc($query_category)){
	$category_name=$row['Category_name'];
}

					echo "
					<tr>
					<td class='text-center'></td>
					<td>$fname $lname</td>
					<td>$note_title</td>
					<td>$category_name</td>
					<td>$added_date</td>
					<td>$remark</td>
					<td class='text-center'>
					<a onclick='Reports(this);return false;' href='admin-spamreports.php?delete_id=$report_id'><img src='images/images/delete.png'></a></td>
					
					<td><div class='dropleft text-center'><a id='dropdownMenuLink'  data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' ><img src='images/images/dots.png' ></a>
					<div class='dropdown-menu' aria-labelledby='dropdownMenuLink'>
				<a class='dropdown-item' href='admin-spamreports.php?noteid=$noteid'>Download Notes</a>
					 <a class='dropdown-item' href='note-details.html'>View More Details</a>
					  </div></div></td>
				
					";
				}?>
					
  </tbody>
</table>
      </div>
      </div>
      
    
</section>

 <div class="admin-footer"><hr><div class="container"><div class="row"><div class="col-md-6 col-sm-4 col-xs-3 col-3">
vesion 1.1.24
       </div>
        <div class="col-md-6 col-sm-8 col-xs-9 col-9 text-right">
             <p>Copyright <span>&#169;</span> Tatvasoft All rights reserved.</p>
             </div></div></div></div>
       
       
        <!--jquery-->
  <script src="js/jquery.js"></script> 
  <!--bootstrap-->
   <script src="js/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="js/bootstrap/bootstrap.min.4.5.js"></script>
  
    


    
	<script>
    $(document).ready(function () {

var rejectedNotesTable = $('#spamreports-table').DataTable({
    "order": [[ 4, "desc" ]],
    "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
        //debugger;
        var index = iDisplayIndexFull + 1;
        $("td:first", nRow).html(index);
        return nRow;
    },
    'sDom': '"top"i',
    "iDisplayLength": 5,
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
    </body></html>