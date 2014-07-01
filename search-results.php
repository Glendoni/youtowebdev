<?php include("includes/header.php"); ?>
<?php 
//GET SEARCH CRITERIA
$search = $_GET['search'];
$agencyname = $_GET['agency_name']; 
//GET COMPANY ID
$businessid = $_GET['businessid']; 
if (empty($businessid) || ($businessid == "")){
$businessidsql = "";
}
else {
$businessidsql = "AND B.id = '$businessid'";
}

$agencyname = htmlspecialchars($agencyname); 
// changes characters used in html to their equivalents, for example: < to &gt;
$agencyname = mysql_real_escape_string($agencyname);
// makes sure nobody uses SQL injection
$agencyname = "AND B.name LIKE '%".$agencyname."%'";
//TURNOVER//
$turnoverfrom = $_GET['turnover_from']; 
$turnoverto = $_GET['turnover_to']; 
if (empty($turnoverfrom) && (!empty($turnoverto))){
$turnoverfrom = "0";
}
if (empty($turnoverto) && (!empty($turnoverfrom))){
$turnoverto = "100000000";
}
if (!empty($turnoverto) || (!empty($turnoverfrom))){
	//$turnoverselect="T.turnover,";
	$turnoverjoin = "INNER
  JOIN ( SELECT T.turnover as latestturnover, businessid
              , MAX(added) AS added
           FROM turnover T
         GROUP
             BY T.businessid ) AS T
    ON T.businessid = B.id
";
$turnoversql = "AND latestturnover between $turnoverfrom AND $turnoverto";

}
//EMPLOYEES//
$employeesfrom = $_GET['employees_from']; 
$employeesto = $_GET['employees_to']; 
if (empty($employeesfrom) && (!empty($employeesto))){
$employeesfrom = "0";
}
if (empty($employeesto) && (!empty($employeesfrom))){
$employeesto = "20000";
}
if (!empty($employeesto) || (!empty($employeesfrom))){
	$employeeselect = "E.count,";
$employeejoin = "LEFT JOIN employee_count E
ON B.id = E.businessid
LEFT JOIN
(
SELECT count, date, businessid
FROM employee_count order by date desc
)
Z ON E.businessid = B.id AND E.date = Z.date";
$employeessql = "AND E.count between $employeesfrom AND $employeesto";
$searchorder = "Group by B.id order by E.count desc";
}
//SECTOR//
$sectorsearch = $_GET['sector']; 
if (empty($sectorsearch) || (in_array('All', $_GET["sector"]))){
$sectorsql = "";
}
else {
$sectorjoin = "LEFT JOIN sectors S ON B.id=S.businessid";
$sectorsql = '';
$numItems = count($_GET["sector"] );
$i = 0;
foreach($_GET["sector"] as $sector) {
  if(++$i === $numItems) {
    $sectorsql2 .= " S.sector = '$sector'";
  }	  else {  $sectorsql1 .= " S.sector = '$sector' OR";}
  $sectorsql = 'AND ('.$sectorsql1." ".$sectorsql2.") AND S.search = 1";
}    
// remove the last OR

}
//PROVIDER//
$providersearch = $_GET['provider']; 
if (empty($sectorsearch) || ($providersearch == "All")){
$providerjoin = "";
$providersql = "";
}
else {
$providerjoin = "INNER JOIN mortgages M ON B.id=M.businessid";
$providersql = "AND M.status='Outstanding' AND M.search = '1' AND M.provider ='".$providersearch."'";
}
//MORTGAGE END DATE//
$mortgage_end_from = $_GET['mortgage_end_from']; 
$mortgage_end_to = $_GET['mortgage_end_to']; 
if (empty($mortgage_end_from) && (!empty($mortgage_end_to))){
$mortgage_end_from = "0";
}
if (empty($mortgage_end_to) && (!empty($mortgage_end_from))){
$mortgage_end_to = "365";
}
if (!empty($mortgage_end_to) || (!empty($mortgage_end_from))){
$mortgage_endsql = "AND dayofyear(M.start) - dayofyear(curdate()) between $mortgage_end_from and $mortgage_end_to AND M.search = 1 AND M.status = 'Outstanding'";
$providerjoin = "INNER JOIN mortgages M ON B.id=M.businessid";
$searchorder = "Group by B.id order by dayofyear(start) - dayofyear(curdate()) Asc";
}
//COMPANY AGE//
$company_age_from = $_GET['company_age_from']; 
$company_age_to = $_GET['company_age_to']; 
if (empty($company_age_from) && (!empty($company_age_to))){
$company_age_from = "0";
}
if (empty($company_age_to) && (!empty($company_age_from))){
$company_age_to = "100";
}
if (!empty($company_age_to) || (!empty($company_age_from))){

 $company_age_from_calculate = date("Y-d-m", strtotime("-".$company_age_from." year"));
$company_age_to_calculate = date("Y-d-m", strtotime("-".$company_age_to." year"));

$company_agesql = "AND B.founded >= '$company_age_to_calculate'  AND B.founded <= '$company_age_from_calculate'";
$searchorder = "order by founded desc"; 
 
}
else {
	$searchorder = "Group by B.id order by B.name asc";
};
//GET SAVED SEARCH LIST//
$listsearch = $_GET['list'];
if ($listsearch==="1" ){
$listsearchsql = "AND B.assigned = ".$user_id;
}
//GET SAVED SEARCH LIST//
$savedlist = $_GET['savedlist'];
if ($savedlist>"0" ){
$savedlistsql = "AND B.id IN (select businessid from companylist where list_id = ".$savedlist.")";
}

?>
<body>
<!--GET NAV-->
<?php include("includes/nav.php"); ?>
<!-- Main -->
<div class="container">
<div class="row">
<?php include("includes/left-menu-search.php"); ?><!-- /col-3 -->
<div class="col-md-9">
<a href="#"><strong><i class="glyphicon glyphicon-dashboard"></i> My Dashboard</strong></a><hr>
<div class="col-md-12">     
       
<?php include("includes/search-results.php"); ?>
</div>
</div><!--/col-span-9-->
</div><!-- /Row -->
</div><!-- /Container -->
<?php include("includes/add_business_modal.php"); ?>
<?php include("includes/footer.php"); ?>