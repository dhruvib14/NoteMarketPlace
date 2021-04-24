<?php
include "db.php";

//ternary operator to store data
if(isset($_GET['selected_search'])){
    $selected_search = $_GET['selected_search'];
    echo $selected_search;}
    else
    $selected_search = "";

if(isset($_GET['selected_type'])){
    $selected_type = $_GET['selected_type'] ;
  }
    else  $selected_type = "";

if(isset($_GET['selected_category']))
     $selected_category = $_GET['selected_category'] ;
     else
     $selected_category = "";

if(isset($_GET['selected_university'])){
     $selected_university = $_GET['selected_university'] ;
    }
     else
     $selected_university = "";

if(isset($_GET['selected_course']))
    $selected_course = $_GET['selected_course'] ;
    else $selected_course = "";

if(isset($_GET['selected_country']))
    $selected_country = $_GET['selected_country'] ;
    else $selected_country = "";

if(isset($_GET['selected_rating']))
     $selected_rating = $_GET['selected_rating']; 
     else
     $selected_rating = "";

//to get all the notes
$all_note_query = "SELECT DISTINCT notes.ID,notes.Note_Title,notes.Note_types,notes.Category,notes.PublishedDate,
                   notes.Note_Display_Picture,notes.Note_Pages,notes.University,notes.Course
                   FROM notes 
                   LEFT JOIN review_rating 
                   ON review_rating.NoteID=notes.ID 
                   WHERE notes.IsActive=1 
                   AND Note_Title LIKE '%$selected_search%' 
                   /*AND Note_types LIKE '%$selected_type%'
                   AND Category LIKE '%$selected_category%'
                   AND University LIKE'%$selected_university%'
                   AND Course LIKE'%$selected_course%'
                   AND Country LIKE '%$selected_country%'
                   */";

$query_append = "";

//to append all the query
($selected_type != 0 && $selected_type != "")
    ? $query_append .= " AND Note_types='$selected_type'" : "";

($selected_category != 0 && $selected_category != "")
    ? $query_append .= " AND Category='$selected_category'" : "";

($selected_university != 0 && $selected_university != "")
    ? $query_append .= " AND University='$selected_university'" : "";

($selected_course != 0 && $selected_course != "")
    ? $query_append .= " AND Course_Code='$selected_course'" : "";

($selected_country != 0 && $selected_country != "")
    ? $query_append .= " AND Country='$selected_country'" : "";

($selected_rating != 0 && $selected_rating != "")
    ? $query_append .= " AND ratings>$selected_rating " : "";


//display total count
$filter_search_result_all = mysqli_num_rows(mysqli_query($connection, $all_note_query . $query_append));
echo  $filter_search_result_all;

//pagination
(!empty(isset($_GET['page']))) && ($_GET['page'] != "") ? $page = $_GET['page'] : $page = 1;
$limit = 10;
$total_page = ceil($filter_search_result_all / $limit);
($page < 1) ? $page = 1 : "";
($filter_search_result_all > 0 && $total_page < $page) ? $page = $total_page : "";
$start_from = ($page - 1) * $limit;



$filter_search_query = $all_note_query . $query_append . " ORDER BY notes.PublishedDate DESC " . "LIMIT " . $start_from . "," . $limit;
if(!$filter_search_query){
    mysqli_error($connection);
}
$filter_search_result = mysqli_query($connection, $filter_search_query);
?>
<div id="search-result">
    <div class="container">
        <div class="row">
            <div id="search-result-heading">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <?php
                    if ($filter_search_result_all != 0)
                        echo " <h2>Total " . $filter_search_result_all . " notes</h2>";
                    else
                        echo " <h2>No Record Found!</h2>";
                    ?>
                </div>
            </div>
        </div>
    </div>
  
       <div class="container">

            <?php

            //to get all books data
            while ($row = mysqli_fetch_assoc($filter_search_result)) {
               
                $note_id = $row['ID'];
                $note_pic = $row['Note_Display_Picture'];
                $note_title = $row['Note_Title'];
                $university_name = $row['University'];
                $note_page = $row['Note_Pages'];
                $note_pub_date = $row['PublishedDate']; 
                ?>
   
            <div class="col-lg-4 col-md-6 col-sm-6 col-12 single-book-selecter">
                <?php echo "<a href='note-details.php?id=$note_id'>"; ?>

                <!-- display img -->
                <img src='<?php echo $note_pic ?>' class="img-fluid search-img-border" 
                    title='Click to View <?php echo $note_title ?>' alt='Book Cover photo of <?php echo $note_title ?>'>
                <?php echo "</a>
                        <a href='note-details.php?id=$note_id' title='Click to view $note_title'>";
                    ?>
                <div class="search-result-below-img">
                    <ul>
                        <li>
                            <!-- display title     -->
                            <h3> <?php echo $note_title; ?> </h3>
                        </li>
                    </ul>
                    <div class="search-result-data">

                        <!-- university name -->
                        <img class="search-icon-resizer" src="images/images/university.png" alt="university">
                        <h6 class="search-result-data-body">
                            <?php echo (!empty($university_name) && $university_name != '') ? $university_name : 'Not specified' ?>
                        </h6>
                    </div>

                    <!-- notes pages -->
                    <div class="search-result-data">
                        <img class="search-icon-resizer" src="images/images/pages.png" alt="book">
                        <h6 class="search-result-data-body"><?php echo $note_page; ?> Pages</h6>
                    </div>

                    <!-- note publish date -->
                    <div class="search-result-data">
                        <img class="search-icon-resizer" src="images/images/calendar.png" alt="calender">
                        <h6 class="search-result-data-body">
                            <?php echo date('D, F d Y', strtotime($note_pub_date)); ?></h6>
                    </div>

                    <!-- imappropriate count -->
                    <div class="search-result-data">
                        <?php $appropriate_query = mysqli_query($connection, "SELECT 1 FROM review_rating WHERE NoteID=$note_id");
                            $appropriate_count = mysqli_num_rows($appropriate_query);
                            if ($appropriate_count > 0) { ?>
                        <img class="search-icon-resizer" src="images/images/flag.png" alt="flag">
                        <h6 class="search-result-data-body search-result-red">
                            <?php echo $appropriate_count ?>&nbspUser(s) have marked this note as
                            inappropriate</h6>
                        <?php } ?>
                    </div>

                    <?php

                        // display rating
                        $ratiing_getter = mysqli_query($connection, "SELECT AVG(ratings),COUNT(ratings) FROM review_rating WHERE NoteID=$note_id AND isactive=1");
                        while ($row = mysqli_fetch_assoc($ratiing_getter)) {
                            $ratiing_val = $row['AVG(ratings)'];
                            $total_rating = $row['COUNT(ratings)']; ?>

                    <!-- rating display -->
                    <div class="note-page-star-setter">
                        <div id="<?php echo $note_id ?>"></div>
                        <?php echo $total_rating > 0 ? "<h6>" . $total_rating . " Reviews</h6>" : "<h6>No reviews yet!</h6>"; ?>
                    </div>
                    <?php } ?>

                    <div class="notes-star" style="margin-left:20px;">
										<?php for($i=0;$i<$ratiing_val;$i++){
											echo "<img src='images/images/star.png'>";
										}
                                        for($i=0;$i<(5-$ratiing_val);$i++){
											echo "<img src='images/images/star-white.png'>";
										}
									?>		
									</div>
									<?php 
									?>
							</div>
	 
		   </div>
            
            <?php echo "</a>"; } ?>
         
    </div>
</div>


<!-- pagination start -->
<div class="search-pagination">
    <ul class="pagination justify-content-center">
        <?php
        echo "<li class='page-item'><a onclick=" . "showNotes($page-1)" . " class='page-link' ><img src='images/images/left-arrow.png'></a></li>";
        for ($i = 1; $i <= $total_page; $i++) {
            if ($i == $page) {
                echo "<li class='page-item active'><a class='page-link' onclick=" . "showNotes($i)" . ">$i</a></li>";
            } else echo "<li class='page-item'><a class='page-link' onclick=" . "showNotes($i)" . ">$i</a></li>";
        }
        echo "<li class='page-item'><a onclick=" . "showNotes($page+1)" . " class='page-link'><img src='images/images/right-arrow.png'></a></li>";
        ?>
    </ul>
</div>
<!-- pagination end -->