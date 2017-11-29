<?php

class AuthProcessor extends BaseProcessor
{
	private $service;

	public function __construct()
	{
		parent::__construct();
		$this->service = new AuthService();
	}

	public function setProcessor(string $operation_type, array $data)
	{
		try {
			switch ($operation_type) {
				case 'signin':
					$this->output = $this->service->signin($data);
					break;
			}

			return true;
		} catch (Exception $e) {
			$this->output = $e;
			return false;
		}
	}
}