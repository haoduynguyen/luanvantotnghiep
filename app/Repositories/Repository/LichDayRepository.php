<?php

namespace App\Repositories\Repository;

use App\Models\LichDay;
use App\Repositories\Interfaces\LichDayRepositoryInterface;

class LichDayRepository implements LichDayRepositoryInterface
{
    private $lichDay;

    public function __construct()
    {
        $this->lichDay = new LichDay();
    }


    public function get($id, $columns = array('*'))
    {
        $data = $this->lichDay->find($id, $columns);
        if ($data) {
            return $data;
        }
        return null;

    }

    public function all($columns = array('*'))
    {
        $listData = $this->lichDay->get($columns);
        return $listData;
    }

    public function paginate($perPage = 15, $columns = array('*'))
    {
        $listData = $this->lichDay->paginate($perPage, $columns);
        return $listData;
    }

    public function save(array $data)
    {
        return $this->lichDay->create($data);

    }

    public function update(array $data, $id)
    {
        $dep = $this->lichDay->find($id);
        if ($dep) {
            foreach ($dep->getFillable() as $field) {
                if (array_key_exists($field, $data)) {
                    $dep->$field = $data[$field];
                }
            }
            if ($dep->save()) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getByColumn($column, $value, $columnsSelected = array('*'))
    {

        $data = $this->lichDay->where($column, $value)->first();
        if ($data) {
            return $data;
        }
        return null;


    }

    public function getByMultiColumn(array $where, $columnsSelected = array('*'))
    {

        $data = $this->lichDay;

        foreach ($where as $key => $value) {
            $data = $data->where($key, $value);
        }

        $data = $data->first();


        if ($data) {
            return $data;
        }
        return null;


    }

    public function getListByColumn($column, $value, $columnsSelected = array('*'))
    {

        $data = $this->lichDay->where($column, $value)->get();
        if ($data) {
            return $data;
        }
        return null;


    }

    public function getListByMultiColumn(array $where, $columnsSelected = array('*'))
    {

        $data = $this->lichDay;

        foreach ($where as $key => $value) {
            $data = $data->where($key, $value);
        }

        $data = $data->get();

        if ($data) {
            return $data;
        }
        return null;


    }

    public function delete($id)
    {
        $del = $this->lichDay->find($id);
        if ($del !== null) {
            $del->delete();
            return true;
        } else {
            return false;
        }
    }

    public function deleteMulti(array $data)
    {
        $del = $this->lichDay->whereIn("id", $data["list_id"])->delete();
        if ($del) {

            return true;
        } else {
            return false;
        }
    }
    public function getLichDay($param)
    {
        $data = $this->lichDay->lichDayQuery()
            ->where('hk_id', $param['hk_id'])
            ->whereHas('tuan', function ($query) use ($param) {
                $query->where('tuan_id', $param['tuan_id'])->where('status', 'x');
            })->get();
        return $data;
    }
    public function getLichDayFromGv($param, $user)
    {
        $data = $this->lichDay->lichDayQuery()->where('hk_id', $param['hk_id'])
            ->where('phong_may_id', $param['phong_may_id'])
            ->whereHas('tuan', function ($query) use ($param) {
                $query->where('tuan_id', $param['tuan_id'])->where('status', 'x');
            })->whereHas('user', function ($query) use ($user) {
                $query->where('id', $user->id);
            })->get();
        return $data;
    }
    public function getListDoubleLichDay($data,$param)
    {
        $lichDay = $this->lichDay->lichDayQuery()->where('thu_id', $data->thu_id)
            ->where('nhom_lop_id',$data->nhom_lop_id)
            ->where('phong_may_id',$data->phong_may_id)
            ->where('mon_hoc_id',$data->mon_hoc_id)
            ->where('user_id',$data->user_id)
            ->where('hk_id',$data->hk_id)
            ->whereHas('tuan',function ($query) use($param){
                $query->where('tuan_id',$param['tuan_id'])->where('status', 'x');
            })->get();
        return $lichDay;
    }
} 