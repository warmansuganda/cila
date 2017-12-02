<?php

abstract class BaseProcessor
{
	protected $output;
	protected $ci;

	public function __construct()
	{
		$this->ci = &get_instance();
	}

	abstract public function setProcessor(string $operation_type, array $data); 

	public function run(string $operation_type, array $data)
	{
		$this->setProcessor($operation_type, $data);
		return $this->output;
	}
}