<?php include('connection.php'); ?>
<?php
 $createdby=$_GET['user'];
 $business=$_GET['id'];

 //Insert Data into mysql
$query=mysqli_query($con,"INSERT INTO update_requests(business_id, user_id) VALUES('$business','$createdby')");
?>
<script>window.close();</script>