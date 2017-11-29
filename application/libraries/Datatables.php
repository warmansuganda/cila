<?php

class Datatables
{
	/**
     * Total records
     *
     * @var integer
     */
    protected $totalRecords = 0;

    /**
     * Total filtered records
     *
     * @var integer
     */
    protected $filteredRecords = 0;

    /**
     * Result Array
     *
     * @var array
     */
    protected $result_array = [];

    /**
     * Input
     *
     * @var array
     */
    protected $input = [];


    /**
     * Query object
     *
     * @var Eloquent|Builder
     */
    public $query;



	function __construct()
	{
		# code...
	}

	public function of(array $data, $query)
	{
		$this->data = $data;
		$this->query = $query;
		return $this;
	}

	/**
     * Set auto filter off and run your own filter
     *
     * @param callable $callback
     * @return Datatables
     * @internal param $Closure
     */
    public function filter(Closure $callback)
    {
        $query = $this->query;
        call_user_func($callback, $query);

        return $this;
    }

	public function addColumn($name, $clallback)
	{
		# code...
		return $this;
	}

	public function make(bool $value)
	{
		# code...
		return $this->output();
	}

	/**
     * Render json response
     *
     * @return JsonResponse
     */
    private function output()
    {
        $output = [
            "draw"            => (int) $this->input['draw'],
            "recordsTotal"    => $this->totalRecords,
            "recordsFiltered" => $this->filteredRecords,
            "data"            => $this->result_array,
        ];

        return $output;
    }
}