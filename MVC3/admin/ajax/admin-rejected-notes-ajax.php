<?php
include "../db.php";
if(isset($_GET['selected_search'])){
    $selected_search=$_GET['selected_search'];
}
else {
	$selected_search="";
}

if(isset($_GET['selected_seller'])&&!empty($_GET['selected_seller'])){
	$selected_seller=$_GET['selected_seller'];
}else {
	$selected_seller="";
}


$query_publish_notes="";

$query_publish_notes="SELECT DISTINCT notes.ID,notes.Note_Title,notes.Category,notes.SellerID,notes.Actioned_By,users.FirstName,users.LastName,category.Category_name,notes.ModifiedDate,notes.Admin_Remarks FROM notes  LEFT JOIN users ON notes.SellerID=users.ID LEFT JOIN category ON notes.Category=category.ID  WHERE notes.Status=10";

$query_publish_notes.=(!empty($selected_search)&&$selected_search!="")?" AND (notes.Note_Title LIKE '%$selected_search%' OR category.Category_name LIKE '%$selected_search%' OR notes.Admin_Remarks  LIKE '%$selected_search%' OR users.FirstName LIKE '%$selected_search%' OR users.LastName LIKE '%$selected_search%' OR notes.ModifiedDate LIKE '%$selected_search%')":"";

$query_publish_notes.= (!empty($selected_seller)&&$selected_seller!="")? " AND  notes.SellerID=$selected_seller ":"";

$query_publish_notes.=" ORDER BY ModifiedDate DESC";

$result=mysqli_query($connection,$query_publish_notes);

if(!$result){
	echo mysqli_error($connection);
}

?>
<div class="container">
			<div class="table-responsive">
            <table class="table" id="rejected-notes-table">
					
						<thead>
						<tr>
							<th scope="col" class="text-center">SR NO.</th>
							<th scope="col">NOTE TITLE</th>
							<th scope="col">CATEGORY</th>
							<th scope="col">SELLER</th>
							<th scope="col"></th>
							<th scope="col">DATE ADDED</th>
							<th scope="col">REJECTED BY</th>
							<th scope="col" class="wrap">REMARKS</th>
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
						$noteid=$row['ID'];
						$seller_id=$row['SellerID'];
						$admin_rejected_id=$row['Actioned_By'];
						$modified_date=$row['ModifiedDate'];
						$remarks=$row['Admin_Remarks'];
						$query_downloader=mysqli_query($connection,"SELECT FirstName,LastName FROM users WHERE ID=$admin_rejected_id");
						while ($row=mysqli_fetch_assoc($query_downloader)) {
							$fname=$row['FirstName'];
							$lname=$row['LastName'];	
						}

		echo "<tr>
						<td scope='col'>1</td>
						<td scope='col'><a href='../admin/admin-note-details.php?noteid=$noteid'>$note_title</a></td>
						<td scope='col'>$category</td>
						<td>$seller_fname $seller_lname</td>
						<td><a href='admin-member-details.php?id=$seller_id'><img src='images/images/eye.png'></a></td>
                        
                        <td>$modified_date</td>
                        <td>$fname $lname</td>
							<td>$remarks</td>
                        <td class='text-center'>
								<div class='dropleft'><a id='dropdownMenuLink' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><img src='images/images/dots.png'></a>
									<div class='dropdown-menu' aria-labelledby='dropdownMenuLink'>
										<a class='dropdown-item' href='admin-rejected-notes.php?noteid=$noteid'>Download Note</a>
										<a class='dropdown-item' href='admin-rejected-notes.php?noteidapprove=$noteid' onclick='approve(this);return false;'>Approve</a>
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
var rejectedNotesTable = $("#rejected-notes-table").DataTable({
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