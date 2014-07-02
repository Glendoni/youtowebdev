<?php
# This function reads your DATABASE_URL configuration automatically set by Heroku
# the return value is a string that will work with pg_connect
#function pg_connection_string() {
#  return "dbname=d4fe0utkch87if host=ec2-54-225-101-64.compute-1.amazonaws.com port=5432 user=emzuqjnejgtsmy password=x3rl2UygsLvpFvXc2Lw62BdFsU sslmode=require";
#}
 
# Establish db connection
#$db = pg_connect(pg_connection_string());
#if (!$db) {
#    echo "Database connection error."
#    exit;
#}
 
#$result = pg_query($db, "SELECT statement goes here");
?>

<?php
# This function reads your DATABASE_URL config var and returns a connection
# string suitable for pg_connect. Put this in your app.
function pg_connection_string_from_database_url() {
  extract(parse_url($_ENV["DATABASE_URL"]));
  return "user=$user password=$pass host=$host dbname=" . substr($path, 1); # <- you may want to add sslmode=require there too
}

# Here we establish the connection. Yes, that's all.
$pg_conn = pg_connect(pg_connection_string_from_database_url());

# Now let's use the connection for something silly just to prove it works:
$result = pg_query($pg_conn, "SELECT relname FROM pg_stat_user_tables WHERE schemaname='public'");

print "<pre>\n";
if (!pg_num_rows($result)) {
  print("Your connection is working, but your database is empty.\nFret not. This is expected for new apps.\n");
} else {
  print "Tables in your database:\n";
  while ($row = pg_fetch_row($result)) { print("- $row[0]\n"); }
}
print "\n";
?>