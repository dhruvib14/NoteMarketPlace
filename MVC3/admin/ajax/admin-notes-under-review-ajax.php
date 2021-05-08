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

$query_publish_notes="SELECT DISTINCT notes.ID,notes.Note_Title,notes.Category,notes.SellerID,referencedata.Value,notes.Is_Paid,notes.Price,notes.Actioned_By,notes.CreatedDate,users.FirstName,users.LastName,category.Category_name FROM notes  LEFT JOIN users ON notes.SellerID=users.ID LEFT JOIN referencedata ON notes.Status=referencedata.ID LEFT JOIN category ON notes.Category=category.ID  WHERE notes.Status=7 OR notes.Status=8";

$query_publish_notes.=(!empty($selected_search)&&$selected_search!="")?" AND (referencedata.Value LIKE '%$selected_search%' OR notes.Price LIKE '%$selected_search%' OR notes.Note_Title LIKE '%$selected_search%' OR category.Category_name LIKE '%$selected_search%' OR notes.Admin_Remarks  LIKE '%$selected_search%' OR users.FirstName LIKE '%$selected_search%' OR users.LastName LIKE '%$selected_search%' OR notes.PublishedDate LIKE '%$selected_search%')":"";

$query_publish_notes.= (!empty($selected_seller)&&$selected_seller!="")? " AND  notes.SellerID=$selected_seller ":"";

$query_publish_notes.=" ORDER BY PublishedDate DESC";

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
                        <th scope="col">SR NO.</th>
							<th scope="col">NOTE TITLE</th>
							<th scope="col">CATEGORY</th>
							<th scope="col">SELLER</th>
							<th scope="col"></th>
							<th scope="col">DATE ADDED</th>
							<th scope="col">STATUS</th>
							<th scope="col" class="text-center">ACTION</th>
							<th scope="col"></th>
						</tr>
					</thead>
					<tbody>
					

                    <?php
                     
					while($row=mysqli_fetch_assoc($result)){
						$note_title=$row['Note_Title'];
						$category=$row['Category_name'];
                     $status=$row['Value'];
						$seller_fname=$row['FirstName'];
						$seller_lname=$row['LastName'];
						$noteid=$row['ID'];
						$seller_id=$row['SellerID'];
						$modified_date=$row['CreatedDate'];
						


		echo "<tr>
						<td scope='col'>1</td>
						<td scope='col'><a href='../admin/admin-note-details.php?noteid=$noteid'>$note_title</a></td>
						<td scope='col'>$category</td>
                       
						<td>$seller_fname $seller_lname</td>
						<td><a href='admin-member-details.php?id=$seller_id'><img src='images/images/eye.png'></a></td>
                        
                        <td>$modified_date</td>
                       
							<td>$status</td>
                       
                            <td><button type='submit' class='btn btn-primary approve-btn'  onclick='javascript:approve($(this));return false;'  ><a  href='admin-notes-under-review.php?approveid=$noteid'>Approve</a></button>
                            <button type='submit' class='btn btn-primary reject-btn' data-toggle='modal' data-title='$note_title' data-id='$noteid' id='unpublish-notes' data-target='#rejectpopup' >Reject</button>
                            <button type='submit' class='btn btn-primary inreview-btn' onclick='javascript:inreview($(this));return false;' ><a href='admin-notes-under-review.php?reviewid=$noteid'>InReview</a></button>
                       </td>
                        
                        <td>
								<div class='dropleft'><a id='dropdownMenuLink' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><img src='images/images/dots.png'></a>
									<div class='dropdown-menu' aria-labelledby='dropdownMenuLink'>
										<a class='dropdown-item' href='admin-notes-under-review?noteid=$noteid'>Download Note</a>
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

		<div class="modal fade" id="rejectpopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<form method="post"><div class="modal-dialog" role="document">
	<div class="modal-content">
		<div class="modal-header">
		
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		
		<div class="modal-body">

		<input style="margin-bottom:30px;border:none; color:#6266a6; font-weight: 600; font-size:30px;" name="title_for_report" id="title_for_report" value="<?php echo $note_title;?>">
		<br><input name="noteid_for_report" style="border:none; "  id="noteid_for_report" value="<?php echo $noteid?>" hidden>
		
		
			<label for="exampleInputName">remarks* </label>
			<textarea class="form-control comment input-field" rows="3" name="remarks" placeholder="remarks"></textarea>					
		</div>
		<div class="modal-footer">
			<button type="submit" onclick='reject(this);return false;' name="submit_review" class="reject-btn btn btn-primary" >Unpublish</button>
			<button type="submit"  class="close btn btn-primary " style="background-color:#f1f1f1f;" data-dismiss="modal" aria-label="Close" >
			<span aria-hidden="true">Cancel</span>
			</button>
		</div></form>
		
	</div>
</div></form>
</div>

		<script>

		//note id getter via data id
$(document).on("click", "#unpublish-notes", function() {
	$('#noteid_for_report').val($(this).data('id'));
	$('#title_for_report').val($(this).data('title'));
	$('#rejectpopup').modal('show');
});

function reject() {
	if (confirm("Are you sure you want to reject seller request?")) {
		window.location=anchor.attr("href");
	} else {
		txt = "You pressed Cancel!";
	}
}
	
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
<script>
function Unpublish() {
	if (confirm("Are you sure you want to Unpublish this note?")) {
		window.location=anchor.attr("href");
	} else {
		txt = "You pressed Cancel!";
	}
}
</script>
<script src="js/datatables.js"></script>
