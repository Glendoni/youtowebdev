<?php
ob_start();
?>
<?php include('connection.php'); ?>
<?php
// Define $myusername and $mypassword 
$myusername = $_POST['myusername']; 
$mypassword = $_POST['mypassword']; 
$myusername = stripslashes($myusername);
$mypassword = stripslashes($mypassword);

$myusername = pg_escape_string($myusername);

$mypassword = pg_escape_string($mypassword);

$encrypted_mypassword = md5($mypassword);
// print("SELECT * FROM users WHERE username='$myusername' and password='$encrypted_mypassword' and active = '1'");
$sql="SELECT * FROM users WHERE username='$myusername' and password='$encrypted_mypassword' and active = '1'";

$result=pg_query($con,$sql);


while($row = pg_fetch_array($result))
{
$user_name = $row['user_name'];
$user_id = $row['id'];
$user_email = $row['username'];
//$user_level = $row['user_level'];
//$user_brand = $row['user_brand'];
$user_manager = $row['user_manager'];
}
$count=pg_num_rows($result);

if($count==1){
pg_query($con,"UPDATE users SET `user_lastlogin` = now() where username='$myusername'");

// Register $myusername, $mypassword and redirect to file "login_success.php"
session_start();
 $_SESSION['user_name'] 	= $user_name;
$_SESSION['user_email'] 	= $user_email;
$_SESSION['user_id']		= $user_id;
$_SESSION['user_level'] 	= $user_level;
$_SESSION['user_brand']	= $user_brand;
$_SESSION['user_manager']	= $user_manager;
header("location:../index.php");
}
else {
header("location:../login.php?status=incorrect");
}
ob_end_flush();
?>