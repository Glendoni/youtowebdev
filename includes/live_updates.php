<?php
include('connection.php');

$content=$_POST['content'];
echo $assignsql = "update business set assigned = 1 where id = '$content'";
pg_query($con,$assignsql);


?>
