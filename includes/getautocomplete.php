<?php
include("connection.php");

 
 $term=$_GET["term"];
  $sql="SELECT name,id FROM business where name like '%".$term."%' And active = '1' order by name asc limit 15";

 
 $query=pg_query($con,$sql);
 $json=array();
 
    while($student=pg_fetch_array($query)){
         $json[]=array(
'label'=> $student["name"],
'value'=> $student["name"],
'link'=> 'search-results.php?businessid='.$student["id"],

                        );
    }
 
 echo json_encode($json);
 
?>