<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Autocomplete extends MY_Controller {
		function __construct() 
	{
		parent::__construct();
		
	}
    public function autocomplete() {
        $search_data = $this->input->post("search_data");
        $query = $this->Autocomplete_model->get_autocomplete($search_data);

        foreach ($query->result() as $row):
            echo "<li><a href='" . base_url() . "companies/company?id=" . $row->id . "'>" . $row->name . "</a></li>";
        endforeach;
    }
}