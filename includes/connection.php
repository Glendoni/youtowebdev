<?php
# This function reads your DATABASE_URL configuration automatically set by Heroku
# the return value is a string that will work with pg_connect
function pg_connection_string() {
  return "dbname=d4fe0utkch87if host=ec2-54-225-101-64.compute-1.amazonaws.com port=5432 user=emzuqjnejgtsmy password=x3rl2UygsLvpFvXc2Lw62BdFsU sslmode=require";
}
 
# Establish db connection
$db = pg_connect(pg_connection_string());
if (!$db) {
    echo "Database connection error."
    exit;
}
 
$result = pg_query($db, "SELECT statement goes here");
?>