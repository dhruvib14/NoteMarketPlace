<?php

include "db.php";

//delete report
if(isset($_GET['reportid'])){
    $reportid=$_GET['reportid'];
    $query=mysqli_query($connection,"UPDATE reports SET IsActive=1 WHERE reportid=$reportid");
}?>