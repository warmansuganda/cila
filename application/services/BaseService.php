<?php
use Carbon\Carbon;

class BaseService
{
	protected $ci;
	protected $carbon;
	
	function __construct()
	{
		$this->ci = &get_instance();
		$this->carbon = new Carbon;
	}
}