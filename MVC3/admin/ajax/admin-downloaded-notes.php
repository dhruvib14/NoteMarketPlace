<?php
include "../db.php";
if(isset($_GET['selected_search'])){
    $selected_search=$_GET['selected_search'];
}
else {
	$selected_search="";
}
if(isset($_GET['selected_buyer'])&&!empty($_GET['selected_buyer'])){
	$selected_buyer=$_GET['selected_buyer'];
}

else {
	$selected_buyer="";
}

if(isset($_GET['selected_seller'])&&!empty($_GET['selected_seller'])){
	$selected_seller=$_GET['selected_seller'];
}else {
	$selected_seller="";
}

if(isset($_GET['selected_type'])&&!empty($_GET['selected_type'])){
	$selected_type=$_GET['selected_type'];
}
else{
	$selected_type="";
}
$query_publish_notes="";

$query_publish_notes="SELECT DISTINCT notes.ID,notes.Note_Title,downloads.NoteCategory,notes.Is_Paid,notes.Price,referencedata.Value,users.FirstName,users.LastName,category.Category_name,downloads.AttachmentDownloadedDate,downloads.DownloaderID,downloads.SellerID FROM downloads LEFT JOIN notes ON downloads.NoteID=notes.ID LEFT JOIN users ON downloads.SellerID=users.ID LEFT JOIN category ON downloads.NoteCategory=category.ID LEFT JOIN referencedata ON downloads.IsPaid=referencedata.ID WHERE downloads.IsActive=1";

$query_publish_notes.=(!empty($selected_search)&&$selected_search!="")?" AND (notes.Note_Title LIKE '%$selected_search%' OR category.Category_name LIKE '%$selected_search%' OR notes.Price  LIKE '%$selected_search%' OR users.FirstName LIKE '%$selected_search%' OR users.LastName LIKE '%$selected_search%' OR referencedata.Value LIKE '%$selected_search%')":"";

$query_publish_notes.= (!empty($selected_seller)&&$selected_seller!="")? " AND  downloads.SellerID=$selected_seller ":"";

$query_publish_notes.= (!empty($selected_buyer)&&$selected_buyer!="")? " AND  downloads.DownloaderID=$selected_buyer ":"";

$query_publish_notes.= (!empty($selected_type)&&$selected_type!="")? " AND  category.ID=$selected_type ":"";

$query_publish_notes.=" ORDER BY AttachmentDownloadedDate DESC";

$result=mysqli_query($connection,$query_publish_notes);

if(!$result){
	echo mysqli_error($connection);
}

?>
<div class="container">
			<div class="table-responsive">
            <table class="table" id="downloaded-notes-table">
					<thead>
						<tr>
							<th scope="col" class="text-center">SR NO.</th>
							<th scope="col">NOTE TITLE</th>
							<th scope="col">CATEGORY</th>
							<th scope="col">BUYER</th>
							<th scope="col"></th>
							<th scope="col">SELLER</th>
							<th scope="col"></th>
							<th scope="col">SELL TYPE</th>
							<th scope="col">PRICE</th>
							<th scope="col" class="wrap">DOWNLOADED DATE/TIME</th>
							<th scope="col"></th>
						</tr>
					</thead>
					<tbody>

                    <?php
                     
					while($row=mysqli_fetch_assoc($result)){
						$note_title=$row['Note_Title'];
						$category=$row['Category_name'];
						$seller_fname=$row['FirstName'];
						$seller_lname=$row['LastName'];
                        $sell_type=$row['Value'];
                        $price=$row['Price'];
                        $downloaded_date=$row['AttachmentDownloadedDate'];
                        $downloader_id=$row['DownloaderID'];
						$noteid=$row['ID'];
						$seller_id=$row['SellerID'];
						$query_downloader=mysqli_query($connection,"SELECT FirstName,LastName FROM users WHERE ID=$downloader_id");
						while ($row=mysqli_fetch_assoc($query_downloader)) {
						
							$fname=$row['FirstName'];
							$lname=$row['LastName'];	
						}

if(empty($price)){
    $price="0";
}              
if(!empty($path)){      
$size=getSize($path);}
else{
    $size="NA";
}			echo "<tr>
						<td scope='col'>1</td>
						<td scope='col'><a href='../admin/admin-note-details.php?noteid=$noteid'>$note_title</a></td>
						<td scope='col'>$category</td>
						<td>$seller_fname $seller_lname</td>
						<td><a href='admin-member-details.php?id=$seller_id'><img src='images/images/eye.png'></a></td>
                        <td>$fname $lname</td>
						<td><a href='admin-member-details.php?id=$downloader_id'><img src='images/images/eye.png'></a></td>
						<td>$sell_type</td>
                        <td>$price</td>
                        <td>$downloaded_date</td>
                        
                        <td class='text-center'>
								<div class='dropleft'><a id='dropdownMenuLink' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><img src='images/images/dots.png'></a>
									<div class='dropdown-menu' aria-labelledby='dropdownMenuLink'>
										<a class='dropdown-item' href='admin-downloaded-notes.php?noteid=$noteid'>Download Note</a>
										<a class='dropdown-item' href='../admin/admin-note-details.php?noteid=$noteid'>View more deaits</a>
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
		<script>
    $(document).ready(function () {
var rejectedNotesTable = $("#downloaded-notes-table").DataTable({
    "order": [[ 5, "desc" ]],
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