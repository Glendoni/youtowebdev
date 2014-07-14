<?php
class Companies extends CI_Controller {
public function __construct() {
parent::__construct();
$this->load->model(‘lat_model’);
}
function index () {
if ($query = $this->lat_model->ambil_data()){
$data['rowrecord']=$query;
}
$this->load->view(‘viewlat’, $data);
}
}
?>