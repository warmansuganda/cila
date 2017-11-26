<?php

use \Firebase\JWT\JWT;

class Token
{
	/**
	 * Holds the instance
	 * @var object
	 */
	protected $ci;

	function __construct()
	{
		$this->ci =& get_instance();
	}

	public function getConfig($key='')
	{
		$this->ci->config->load('jwt');
		$config = config_item('jwt_key');
		return isset($config[$key]) ? $config[$key] : NULL;
	}

	public function encode(array $options)
	{
		return JWT::encode($options, $this->getConfig('private'), 'RS256');
	}

	public function decode(string $token)
	{
		return JWT::decode($token, $this->getConfig('public'), array('RS256'));
	}
}