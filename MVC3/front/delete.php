<?php
include "db.php";
$id = $_GET['id'];
$id = mysqli_real_escape_string($connection, $id);
$delete_note = mysqli_query($connection, "UPDATE notes SET IsActive=0 WHERE ID=$id");

if ($delete_note) {
    header('Location:dashboard.php');
} else {
   echo "please try again";
}