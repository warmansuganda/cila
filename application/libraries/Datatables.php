<?php
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

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
		$this->input = [
            'draw' => 0
        ];
	}

	public function of($builder, array $input = [])
	{
        // if (count($input) > 0) {
        //   $this->input = $input;
        // }

        $this->query = $builder;
        $this->getTotalRecords($builder); //Total records

        return $this;
	}

	/**
     * Set auto filter off and run your own filter
     *
     * @param callable $callback
     * @return Datatables
     * @internal param $Closure
     */
    public function filter($callback)
    {
        $query = $this->query;
        $this->query = $callback($query);

        return $this;
    }

	public function addColumn($name, $clallback)
	{
		# code...
		return $this;
	}

	public function make()
	{
		$this->getResult();
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

    /**
     * Get total records
     *
     * @return int
     */
    private function getTotalRecords($query)
    {
        return $this->totalRecords = $this->count($query);
    }

    /**
     * Counts current query
     *
     * @return int
     */
    private function count($query)
    {
        return $query->count();
    }

    private function string_contains($haystack, $needles)
    {
        foreach ((array) $needles as $needle)
        {
            if ($needle != '' && strpos($haystack, $needle) !== false) return true;
        }

        return false;
    }

    public function getResult()
    {
        $query = $this->query;
        $this->filteredRecords = $query->count();
    }
}