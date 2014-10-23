<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Autocomplete extends MY_Controller {
		function __construct() 
	{
		parent::__construct();
		
	}
    public function autocomplete() {
        $search_data = $this->input->post("search_data");
        $query = $this->Autocomplete_model->get_autocomplete($search_data);
        echo "<ul class='autocomplete-holder'>";
        foreach ($query->result() as $row):
            echo "<a href='" . base_url() . "companies/company?id=" . $row->id . "'><li class='autocomplete-item'>" . $row->name . "</li></a>";
        endforeach;
        echo "</ul>";
    }
}