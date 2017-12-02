<?php
use \Illuminate\Database\Eloquent\Model as Eloquent;

class BaseModel extends Eloquent
{
	use UuidTrait;

    public $incrementing = false;
    
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
                '_id' => $event->id,
                'messages' => [200, 'Created successfully.', '']
            ];
        } else {
            $result = [
                'messages' => [500, 'Created failed.', '']
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
                    '_id' => $id,
                    'messages' => [200, 'Updated successfully.', '']
                ];
            } else {
                $result = [
                    'messages' => [500, 'Updated failed.', '']
                ];
            }
        } else {
            $result = [
                'messages' => [500, 'Can\'t find id.', '']
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
                    '_id' => $id,
                    'messages' => [200, 'Deleted successfully.', '']
                ];
            } else {
                $result = [
                    'messages' => [500, 'Deleted failed.', '']
                ];
            }
        } else {
            $result = [
                'messages' => [500, 'Can\'t find id.', '']
            ];
        }
        return $result;
    }


}