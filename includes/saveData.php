<?php
include('connection.php');
if(isSet($_GET['business_id']))
{
$business_id=$_GET['business_id'];
$user_id=$_GET['user_id'];

echo $assignsql = "update business set assigned = $user_id where id = '$business_id'";
mysqli_query($con,$assignsql);
}

?>
<script>window.close();</script>