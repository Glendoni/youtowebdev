<?php
include("connection.php");

$var = @$_POST['id'] ;
echo $updateuser="update business set assigned = 1 where id = '$var'";

$result = pg_query($con,$updateuser) or die(mysqli_error($mysqli));
//added for testing
echo 'var = '.$var;
?>