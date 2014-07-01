<?php
session_start();
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];
$user_email = $_SESSION['user_email'];
$user_level = $_SESSION['user_level'];
$user_brand = $_SESSION['user_brand'];
$user_manager = $_SESSION['user_manager'];
if(! isset($user_email) ){
header("location:login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8"> 
        <title>Baselist 2.0</title>
        <meta name="generator" content="Bootply" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link href="css/bootstrap.min.css" rel="stylesheet">
                        <link href="css/custom.css" rel="stylesheet">
                <script src="js/jquery-1.11.0.min.js"></script>
<script type='text/javascript' src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.10.4.custom.js"></script>
<link rel="stylesheet" type="text/css" href="css/jquery-ui-1.10.4.custom.css" />
 <script type="text/javascript">
$(document).ready(function(){
$("#agency_name").autocomplete({
source:'includes/getautocomplete.php',
minLength:1,
response: function(event, ui) {
// ui.content is the array that's about to be sent to the response callback.
if (ui.content.length === 0) {
$("#empty-message").html("<a type='button' class='btn btn-info btn-xs btn-block' href='add_company.php'>No Results Found<br><b>Click To Add</b></button>");
} else {
$("#empty-message").empty();
}
},
select: function( event, ui ) { 
window.location.href = ui.item.link;
}
});
});
</script>
<?php 
include("includes/connection.php");
include_once 'includes/functions.php';
setlocale(LC_MONETARY, 'en_GB');
 ?>
        <!--[if lt IE 9]>
          <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->


</head>