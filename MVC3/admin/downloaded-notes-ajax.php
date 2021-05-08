<?php
include "../front/db.php";
session_start();


$search_str=(isset($_GET['search']))?$_GET['search']:" ";
$search_note=(isset($_GET['note']))?$_GET['note']:" ";
$search_seller=(isset($_GET['seller']))?$_GET['seller']:" ";
$search_buyer=(isset($_GET['buyer']))?$_GET['buyer']:" ";

$searchQuery = " ";


if(isset($_GET['search']) && !empty($_GET['search']))
{
    $searchQuery .=" AND (d.NoteTitle LIKE '%{$search_str}%' OR d.NoteCategory LIKE '%{$search_str}%')";
}

if(isset($_GET['note']) && !empty($_GET['note']))
{
    $searchQuery .=" AND (d.NoteID=$search_note)";
}

if(isset($_GET['seller']) && !empty($_GET['seller']))
{
    $searchQuery .=" AND (d.SellerID=$search_seller)";
}

if(isset($_GET['buyer']) && !empty($_GET['buyer']))
{
    $searchQuery .=" AND (d.DownloaderID=$search_buyer)";
}
/* 
$search = (isset($_GET['search']) && $_GET['search'] != "" && !empty($_GET['search'])) ? $_GET['search'] : "";
$searchQuery = ($search != "" && $search != 0 && !empty($search))
    ? " AND (d.NoteTitle LIKE '%$search%' OR d.NoteCategory LIKE '%$search%' OR u.FirstName LIKE '%$search%' OR u.LastName LIKE '%$search%' " : "";


$note_id = (isset($_GET['note']) && $_GET['note'] != "" && !empty($_GET['note'])) ? $_GET['note'] : "";
$searchQuery .= ($note_id != "" && $note_id != 0 && !empty($note_id)) ? " AND d.NoteID=$note_id" : "";


$sellerid = (isset($_GET['seller']) && $_GET['seller'] != "" && !empty($_GET['seller'])) ? $_GET['seller'] : "";
$searchQuery .= ($sellerid != "" && $sellerid != 0 && !empty($sellerid)) ? " AND d.SellerID=$sellerid" : "";


$buyerid = (isset($_GET['buyer']) && $_GET['buyer'] != "" && !empty($_GET['buyer'])) ? $_GET['buyer'] : "";
$searchQuery .= ($buyerid != "" && $buyerid != 0 && !empty($buyerid)) ? " AND d.DownloaderID=$buyerid" : ""; */

$select_download_query = "SELECT DISTINCT d.NoteID,d.NoteTitle,d.NoteCategory,
                        u.FirstName AS buyerfname,u.LastName AS buyerlname,
                        u.ID AS buyer_id,us.FirstName AS sellerfname,us.LastName AS sellerlname,
                        us.ID AS seller_id,d.IsPaid,d.PurchasedPrice,d.AttachmentDownloadedDate 
                        FROM downloads d
                        LEFT JOIN users us
                        ON us.ID=d.SellerID
                        LEFT JOIN users u
                        ON u.ID=d.DownloaderID
                        LEFT JOIN referencedata ref
                        ON ref.ID=d.IsPaid
                        WHERE IsSellerHasAllowedDownload=1";

$select_download_query = $searchQuery . $select_download_query;
$result = mysqli_query($connection , $select_download_query);

if($result){
    echo "select";
}else{
    echo "not".mysqli_error($connection);
}

?>

<div class="container">
    <div class="in-progress-notes-table general-table-responsive">
        <div class="table-responsive-xl">
            <table class="table table-bordered" id="myTable">
                <thead>
                    <tr>
                        <th scope="col" class="text-center">sr no.</th>
                        <th scope="col">Note title</th>
                        <th scope="col">category</th> 
                        <th scope="col">Buyer</th>                                    
                        <th scope="col" class="text-center"></th>
                        <th scope="col">Seller</th>
                        <th scope="col"></th>
                        <th scope="col">Sell Type</th>
                        <th scope="col">Price</th>
                        <th scope="col">Downloaded<br>Date/Time</th>                                    
                        <th scope="col" class="text-center"></th>
                    </tr>
                </thead>
                <tbody>

                <?php

                $sr_no = 1;

                while($row = mysqli_fetch_assoc($result)){

                    $note_id = $row['NoteID'];
                    $title = $row['NoteTitle'];
                    $category = $row['NoteCategory'];
                    $buyer = $row['buyerfname'] . ' ' . $row['buyerlname'];
                    $buyer_id = $row['buyer_id'];
                    $seller = $row['sellerfname'] . ' ' . $row['sellerlname'];
                    $seller_id = $row['seller_id'];
                    $sell_type = $row['IsPaid'];
                    $downloaddate = $row['AttachmentDownloadedDate'];
                    $price = $row['PurchasedPrice'];                   
                    
                ?>  
                    <tr>
                        <td class="text-center"><?php echo $sr_no; ?></td>
                        <td class="purple-td">
                            <a style="color:#6255a5;" href="note-detail.php?noteid=<?php echo $note_id; ?>">
                                <?php echo $title; ?>
                            </a>
                        </td>                        
                        <td><?php echo $category; ?></td> 
                        <td><?php echo $buyer; ?></td>
                        <td class="text-center">
                            <a href="members-detail.php?id=<?php echo $buyer_id; ?> ">
                                <img class="eye-img-in-table" src="images/Dashboard/eye.png" alt="edit">
                            </a>
                        </td>                                  
                        <td><?php echo $seller;  ?></td>
                        <td class="text-center">
                            <a href="members-detail.php?id=<?php echo $seller_id; ?> ">
                                <img class="eye-img-in-table" src="images/Dashboard/eye.png" alt="edit">
                            </a>
                        </td>
                        <td>
                            <?php 
                                if($sell_type == 4 ){
                                    echo "Paid";
                                }else if($sell_type == 5){
                                    echo "free";
                                }
                            
                            ?>
                        </td>
                        <td><?php echo $price ; ?></td>
                        <td><?php echo $downloaddate ; ?></td>                                    
                        <td class="text-center visible-overflow-for-dropdown">
                            <div class="dropdown dropdown-dots-table">
                                <a href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <img class="dots-in-table" src="images/Dashboard/dots.png" alt="edit">
                                </a>
                        
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <a class="dropdown-item" href="downloaded-notes.php?dnote_id=<?php echo $note_id  ?>">Download Notes</a>
                                    <a class="dropdown-item" href="note-detail.php?noteid=<?php echo $note_id; ?>">View More Details</a>                                                
                                </div>
                            </div>
                        </td>
                    </tr>

                <?php $sr_no++ ; } ?>
                </tbody>
            </table>
            

        </div>
    </div>
</div> 


<script>
    
    $(document).ready(function () {

        var admin_table = $('#myTable').DataTable({
            //"order": [[3,"desc" ]],
            "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                
            },
            'sDom': '"top"i',
            "iDisplayLength": 5,
            "bInfo": false,
            language: {
                "zeroRecords": "No record found",
                paginate: {
                    next: "<img src='images/pagination/right-arrow.png' alt='next'>",
                    previous: "<img src='images/pagination/left-arrow.png' alt='prev'>"
                }
            }
        });
    });
    </script>

   <!--  datatable js -->
   <script src="js/datatables.js"></script>