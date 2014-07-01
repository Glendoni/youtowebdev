<?php

include("connection.php");

 $term=$_GET["term"];
 
 $query="
  SELECT name from business where name like '%".$term."%' order by name";
 $json=array();
 
    while($student=mysqli_fetch_array($con,$query)){
         $json[]=array(
                    'value'=> $student["name"],
                    'label'=>$student["name"]
                        );
    }
 
 echo json_encode($json);
 

?>