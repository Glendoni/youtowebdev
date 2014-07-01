<?php include("../includes/connection.php"); ?>
<?php
header('Content-Type: text/xml');

echo '<?xml version="1.0" encoding="UTF-8"?>
<root>';
$get_articles = "SELECT count(*) as count from meetings";

$articles = mysqli_query($con,$get_articles);

while ($article = mysqli_fetch_array($articles)){
      
    echo '
       <item>
          <value>'.$article[count].'</value>
		          <text>Booked This Month</text>

      </item>';
}
echo '</root>';
?>