<?php
use Carbon\Carbon;

class BaseService
{
	protected $ci;
	protected $carbon;
	protected $encrypt;
	
	function __construct()
	{
		$this->ci = &get_instance();
		$this->ci->load->library('datatables');
		$this->carbon = new Carbon;
		$this->datatables = $this->ci->datatables;
		$this->encrypt = $this->ci->encrypt;
	}
}