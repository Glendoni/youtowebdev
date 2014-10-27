<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Model extends CI_Model {
	
	const STATUS_OK = 'OK';
	const STATUS_FAIL = 'FAIL';
	
	protected $em; // doctrine entity manager
	protected $errors; // store errors
	protected $status; // status of the response
	protected $warning; // status warnings
	
	public function __construct() {
		parent::__construct();
		$this->errors = array();
		$this->warning = array();
		$dsn = getenv('DATABASE_URL');
		$this->load->database($dsn);
	}

	// status warnings api
	public function addWarning($str){
		return $this->warning[] = $str;
	}
	//return statsu warning to api
	public function getWarning(){
		return $this->warning;
	}
	
	// setter for any errors that have occurred in methods below
	public function addError($str) {
		return $this->errors[] = $str;
	}

	// getter for any errors that have occurred in methods below
	public function getErrors() {
		return $this->errors;
	}

	public function getErrorString() {
		return (count($this->errors) > 0 ? implode(",", $this->errors) : NULL);
	}

	public function setStatusOK() {
		$this->status = self::STATUS_OK;
	}
	
	public function isStatusSuccess(){
		return ($this->status == self::STATUS_OK) ;
	}
	
	public function setStatusFAIL() {
		$this->status = self::STATUS_FAIL;
	}
	
	// sort an array $a by key $subkey
	public function _sort_by($a, $subkey) {
		foreach($a as $k=>$v) {
			$b[$k] = strtolower($v[$subkey]);
		}
		asort($b);
		foreach($b as $key=>$val) {
			$c[] = $a[$key];
		}
		return $c;
	}

}