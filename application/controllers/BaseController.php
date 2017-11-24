<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BaseController extends MX_Controller {

	private $data_view = [];

	public function __construct(array $data_view = [])
	{
		parent::__construct();
		$this->data_view = $data_view;
	}

	protected function getDataView(array $data_view = [])
	{
		return $this->data_view;
	}

	protected function serveJSON($data)
	{
		echo json_encode($data);
	}

}
