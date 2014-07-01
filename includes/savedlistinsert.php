<?php include('connection.php'); ?>
<?php
 $createdby=$_POST['createdby'];
 $name=$_POST['name'];
 $criteria=$_POST['criteria'];
 $shared=$_POST['sharelist'];

 //Insert Data into mysql
$query=pg_query($con,"INSERT INTO savedlists(createdby, criteria, name, shared) VALUES('$createdby','$criteria','$name','$shared')");
echo "$name list saved successfully!";
?>