<?php
use \Illuminate\Database\Eloquent\Model as Eloquent;

class BaseModel extends Eloquent
{
	use UuidTrait;

    public $incrementing = false;
    private $ci;
    private $encrypt;

    private function coConstruct()
    {
        $this->ci = &get_instance();
        $this->encrypt = $this->ci->encrypt;
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

    public function scopeCreateOne($query, array $data)
    {
        $event = $query->create($data);

        if ($event) {
            $result = [
                'code'    => 200,
                'status'  => 'success',
                'message' => 'Created successfully.',
                'data'    => [
                    '_id' => $this->encrypt->encode($event->id),
                ]
            ];
        } else {
            $result = [
                'code'    => 500,
                'status'  => 'error',
                'message' => 'Created failed.'
            ];
        }
        return $result;
    }

    public function scopeUpdateOne($query, $id, array $data)
    {
        $cursor = $query->find($id);
        if ($cursor) {
            $event = $cursor->update($data);

            if ($event) {
                $result = [
                    'code'    => 200,
                    'status'  => 'success',
                    'message' => 'Updated successfully.',
                    'data'    => [
                        '_id' => $this->encrypt->encode($id),
                    ]
                ];

            } else {
                $result = [
                    'code'    => 500,
                    'status'  => 'error',
                    'message' => 'Updated failed.'
                ];
            }
        } else {
            $result = [
                'code'    => 500,
                'status'  => 'error',
                'message' => 'Can\'t find id.'
            ];
        }
        return $result;
    }

    public function scopeDeleteOne($query, $id)
    {
        $cursor = $query->find($id);
        if ($cursor) {
            $event = $cursor->delete();

            if ($event) {
                $result = [
                    'code'    => 200,
                    'status'  => 'success',
                    'message' => 'Updated successfully.',
                    'data'    => [
                        '_id' => $this->encrypt->encode($id),
                    ]
                ];

            } else {
                $result = [
                    'code'    => 500,
                    'status'  => 'error',
                    'message' => 'Updated failed.'
                ];
            }
        } else {
            $result = [
                'code'    => 500,
                'status'  => 'error',
                'message' => 'Can\'t find id.'
            ];
        }
        return $result;
    }


}