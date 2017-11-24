<?php

abstract class BaseProcessor
{
	protected $output;
	
	public function __construct()
	{
		# code...
	}

	abstract public function setProcessor(string $operation_type, array $data); 

	public function run(string $operation_type, array $data)
	{
		$this->setProcessor($operation_type, $data);
		return $this->output;
	}
}