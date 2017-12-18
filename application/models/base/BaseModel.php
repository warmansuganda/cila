<?php
use \Illuminate\Database\Eloquent\Model as Eloquent;

class BaseModel extends Eloquent
{
	use UuidTrait;

    public $incrementing = false;
    private $ci;
    private $encrypt;

    private function ciConstruct()
    {
        $this->ci = &get_instance();
    }
    
    public function scopeData($query, $key = NULL, $orderBy = NULL, $direction = 'asc', $offset = 0, $limit = 0)
    {
        if (is_array($key)) {
            $query->where($key);
        }

        if (!empty($offset) || !empty($limit)) {
            $query->take($limit)->skip($offset);
        }

        if (!empty($orderBy)) {
            $query->orderBy($orderBy, $direction);
        }

        return $query;
    }

    public function scopeCreateOne($query, array $data, $callback = NULL)
    {
        $this->ciConstruct();
        try {
            $event = $query->create($data);
            
            // if contain callback
            if (is_callable($callback)) {
                $callback($query, $event);
            } 

            return [
                'code'    => 200,
                'status'  => 'success',
                'message' => 'Created successfully.',
                'data'    => [
                    '_id' => $this->ci->encrypt->encode($event->id),
                ]
            ];
        } catch (Exception $e) {
            return [
                'code'    => 500,
                'status'  => 'error',
                'message' => 'Created failed.',
                'data'    => $e
            ];
        }
    }

    public function scopeUpdateOne($query, $id, array $data, $callback = NULL)
    {
        $this->ciConstruct();
        try {
            $cursor = $query->find($id);
            if ($cursor) {
                $event = $cursor->update($data);

                // if contain callback
                if (is_callable($callback)) {
                    $callback($query, $event, $cursor);
                } 

                return  [
                    'code'    => 200,
                    'status'  => 'success',
                    'message' => 'Updated successfully.',
                    'data'    => [
                        '_id' => $this->ci->encrypt->encode($id),
                    ]
                ];
            } else {
                return  [
                    'code'    => 500,
                    'status'  => 'error',
                    'message' => 'Can\'t find id.'
                ];
            }
        } catch (Exception $e) {
            return [
                'code'    => 500,
                'status'  => 'error',
                'message' => 'Created failed.',
                'data'    => $e
            ];
        }
    }

    public function scopeDeleteOne($query, $id, $callback = NULL)
    {
        $this->ciConstruct();
        try {
            $cursor = $query->find($id);
            if ($cursor) {
                $event = $cursor->delete();
                
                // if contain callback
                if (is_callable($callback)) {
                    $callback($query, $event, $cursor);
                } 

                return  [
                    'code'    => 200,
                    'status'  => 'success',
                    'message' => 'Deleted successfully.',
                    'data'    => [
                        '_id' => $this->ci->encrypt->encode($id),
                    ]
                ];
            } else {
                return  [
                    'code'    => 500,
                    'status'  => 'error',
                    'message' => 'Can\'t find id.'
                ];
            }
        } catch (Exception $e) {
            return [
                'code'    => 500,
                'status'  => 'error',
                'message' => 'Deleted failed.',
                'data'    => $e
            ];
        }
    }


}