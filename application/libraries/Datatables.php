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
     * Result Array
     *
     * @var array
     */
    protected $extra_columns = [];

    /**
     * Result Object
     *
     * @var array
     */
    protected $result_object = [];

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
        if (count($input) > 0) {
          $this->input = $input;
        }

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

	public function addColumn($name, $callback)
	{
		$this->extra_columns[$name] = $callback; 
		return $this;
	}

	public function make()
	{
        $this->getResult();
		$this->initColumns();
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

    private function getResult()
    {
        $query = $this->query;
        $this->filteredRecords = $query->count();
        $this->result_object = $this->query->get();
        $this->result_array = array_map(function ($object) {
            return (array) $object;
        }, $this->result_object->toArray());
    }

    private function initColumns()
    {
        if (count($this->extra_columns) > 0) {
            $result = [];
            foreach ($this->result_array as $key => $value) {
                $custome_result = $value;
                foreach ($this->extra_columns as $name => $callback) {
                    $query = $this->result_object[$key];
                    $custome_result[$name] = $callback($query);
                }

                $result[] = $custome_result;
            }

            $this->result_array = $result;
        }
    }
}