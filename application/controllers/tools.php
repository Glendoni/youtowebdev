<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tools extends MY_Controller {

	public function update_sonovate_id()
	{
//$conn = pg_pconnect("host=ec2-184-73-219-162.compute-1.amazonaws.com port=5892 dbname=d7vgng5fag3om9 user=uamsnmk9i2in0 password=p47ul5n2vd9jvsaeui6la197nnr");

		$this->load->database();
		 $conn = pg_pconnect("host=".$this->db->hostname." port=".$this->db->port." dbname=".$this->db->database." user=".$this->db->username." password=".$this->db->password."");
$connson = pg_pconnect("host=ec2-54-217-211-247.eu-west-1.compute.amazonaws.com port=5432 dbname=d3k8mv1a7or6bn user=pmpsyelzzvrqpf password=NW3K8kqYtHuy--GKpcC1-E6u04");
if (!$conn) {
  echo "Unable to connect - Baselist";
  exit;
}
 if (!$connson) {
  echo "Unable to connect - Sonovate";
  exit;
}
 $sql ="select A.id,
A.companyregnumber,
A.createdbyuserid,
A.agencyname,
A.dateaccountstatuschanged::date
from AGENCIES A
where A.accountstatus = 'On'
and A.state = 'Active'
order by agencyname desc nulls last";

$result = pg_query($connson,$sql );
if (!$result) {
  echo "An error occurred.\n";
  exit;
}

while ($row = pg_fetch_row($result)) {
	$sonovate_id = $row[0];
	$reg_no = $row[1];
	if (is_numeric($reg_no)) {
         $reg_no = sprintf('%08d', $reg_no);
    } else {
         $reg_no = $reg_no;
    }

$sqlupdate1 ="update companies set sonovate_id = '$sonovate_id' where registration = '$reg_no'";
pg_query($conn,$sqlupdate1 );
echo "Status Updated<br>";
}
pg_close($connson);
pg_close($conn); 	}
}
?>