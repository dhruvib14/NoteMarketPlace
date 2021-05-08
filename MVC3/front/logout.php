<?php
session_start();
session_unset();
session_destroy();
header('Location:../front/login1.php');