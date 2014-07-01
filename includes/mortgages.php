
<!--  $sectorsql = ?-->
<?php
$mortgagelistsql = "SELECT distinct M.provider, M.businessid,M.mortgage_id,M.status,
DATE_FORMAT(M.start,'%d/%m/%Y') AS startdate
FROM mortgages M where businessid = '".$business_id."' AND search = 1 order by status ASC, startdate desc
";
$mortgagelistresult=mysqli_query( $con, $mortgagelistsql );
$mortgagelistcount=mysqli_num_rows( $mortgagelistresult );
if ( $mortgagelistcount=="0" ) {
  $mortgages .='
  <div class="alert alert-warning alert-dismissable">
  No Mortgage Data Registered</div>';}
else {
  $mortgages .='
  <table class="table table-hover">
    <thead>
      <tr>
        <th class="col-md-7">Provider</th>
        <th class="col-md-3">Status</th>
        <th class="col-md-2">Start Date</th>
      </tr>
    </thead>
  <tbody>';

  while ( $mortgagelistrow = mysqli_fetch_array( $mortgagelistresult ) ) {
    if ( $mortgagelistrow['status']==="Satisfied" ) {
      $mtrclass = "danger";}
    else {
      $mtrclass = "";
    }
    $mortgages .='

        <tr class="'.$mtrclass.'">
          <td class="col-md-7">'.$mortgagelistrow['provider'].'</td>
          <td class="col-md-3">'.$mortgagelistrow['status'].'</td>
          <td class="col-md-2">'.$mortgagelistrow['startdate'].'</td>
        </tr>';}


  $mortgages.='</tbody>
    </table>';

}
$sectorresult = mysqli_query( $con, $sectorsql );
{  $mortgages.=' <h5>'.$sectorrow['sector'].'</h5>';}
$mortgages .='



</div>
</div>

';?>
<?php echo $mortgages;?>
