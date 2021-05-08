<?php
include "../front/db.php";
if(isset($_GET['selected_search'])){
    $selected_search=$_GET['selected_search'];
}
else {
    $selected_search="";
}
if(isset($_GET['selected_month'])&&!empty($_GET['selected_month'])){
	$selected_month=$_GET['selected_month'];
	$selected_month = explode("-", $selected_month);
}
else{
	$selected_month="";
}
$query_publish_notes="";

$query_publish_notes="SELECT notes.ID,notes.Note_Title,notes.Category,notes.Is_Paid,notes.Price,notes.Actioned_By,notes.PublishedDate,referencedata.Value,users.FirstName,users.LastName,category.Category_name,notesattachment.Path FROM notes LEFT JOIN notesattachment ON notes.ID=notesattachment.Note_ID LEFT JOIN users ON notes.Actioned_By=users.ID LEFT JOIN category ON notes.Category=category.ID LEFT JOIN referencedata ON notes.Is_Paid=referencedata.ID WHERE (notes.Note_Title LIKE '%$selected_search%' OR category.Category_name LIKE '%$selected_search%' OR notes.Price  LIKE '%$selected_search%' OR users.FirstName LIKE '%$selected_search%' OR users.LastName LIKE '%$selected_search%' OR referencedata.Value LIKE '%$selected_search%')AND notes.Status=9 ";

$query_publish_notes.= (!empty($selected_month)&&$selected_month!="")? "AND MONTH(notes.PublishedDate) =$selected_month[1] AND YEAR(notes.PublishedDate) =$selected_month[0] ":"";

$query_publish_notes.=" ORDER BY notes.PublishedDate DESC";
$result=mysqli_query($connection,$query_publish_notes);

?>
<div class="container">
			<div class="table-responsive">
				<table class="table" id="dashboard-table">
					<thead>
						<tr>
							<th scope="col">SR NO.</th>
							<th scope="col">TITLE</th>
							<th scope="col">CATEGORY</th>
							<th scope="col">ATTACHMENT SIZE</th>
							<th scope="col">SELL TYPE</th>
							<th scope="col">PRICE</th>
							<th scope="col">PUBLISHER</th>
							<th scope="col">PUBLISHED DATE</th>
							<th scope="col" class="wrap">NUMBER OF DOWNLOADS</th>
							<th scope="col"></th>
						</tr>
					</thead>
					<tbody>

                    <?php
                     function getSize($path) {
                        $bytes = filesize($path);
                        $s = array('b', 'Kb', 'Mb', 'Gb');
                        if($bytes!=0){
                        $e = floor(log($bytes)/log(1024));
                        return sprintf( '%.2f ' . $s[$e], ( $bytes/pow( 1024, floor($e) ) ) );
                    }}
					while($row=mysqli_fetch_assoc($result)){
						$note_title=$row['Note_Title'];
						$category=$row['Category_name'];
						$path=$row['Path'];
                        $sell_type=$row['Value'];
              $price=$row['Price'];
$published_date=$row['PublishedDate'];
$fname=$row['FirstName'];
$lname=$row['LastName'];
$noteid=$row['ID'];
$query_download=mysqli_query($connection,"SELECT DISTINCT NoteID,DownloaderID FROM downloads WHERE NoteID=$noteid");
if(!$query_download){
    echo mysqli_error($connection);
}
$count_Download=mysqli_num_rows($query_download);
if(empty($price)){
    $price="0";
}              
if(!empty($path)){      
$size=getSize($path);}
else{
    $size="NA";
}			echo "<tr>
						<td scope='col'>1</td>
						<td scope='col'><a href='admin-note-details.php?noteid=$noteid'>$note_title</a></td>
						<td scope='col'>$category</td>
                        <td>$size</td>
                        <td>$sell_type</td>
                        <td>$price</td>
                        <td>$fname $lname</td>
                        <td>$published_date</td>
                        <td>$count_Download</td>
                        <td class='text-center'>
								<div class='dropleft'><a id='dropdownMenuLink' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><img src='images/images/dots.png'></a>
									<div class='dropdown-menu' aria-labelledby='dropdownMenuLink'>
										<a class='dropdown-item' href='admin-dashboard.php?noteid=$noteid'>Download Note</a>
										<a class='dropdown-item' href='admin-note-details.php?noteid=$noteid'>View more deaits</a>
                                        <a class='dropdown-item' data-toggle='modal' data-title='$note_title' data-id='$noteid' id='unpublish-notes' data-target='#unpublishpopup' >UnPublish</a>
										
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
        
		<div class="modal fade" id="unpublishpopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
			<button type="submit" onclick='Unpublish(this);return false;' name="submit_review" class="btn btn-primary" id="modal-btn">Unpublish</button>
			<button type="button"  class="close" data-dismiss="modal" aria-label="Close" id="modal-btn">
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
	$('#unpublishpopup').modal('show');
});

		
    $(document).ready(function () {
var rejectedNotesTable = $("#dashboard-table").DataTable({
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