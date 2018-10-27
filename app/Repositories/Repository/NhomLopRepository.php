<?php

namespace App\Repositories\Repository;

use App\Models\NhomLop;
use App\Repositories\Interfaces\NhomLopRepositoryInterface;

class NhomLopRepository implements NhomLopRepositoryInterface
{
    private $nhomLop;

    public function __construct()
    {
        $this->nhomLop = new NhomLop();
    }


    public function get($id, $columns = array('*'))
    {

        $data = $this->nhomLop->find($id, $columns);
        dd($data);
        if ($data) {
            return $data;
        }
        return null;

    }

    public function all($columns = array('*'))
    {
        $listData = $this->nhomLop->get($columns);
        return $listData;
    }

    public function paginate($perPage = 15, $columns = array('*'))
    {
        $listData = $this->nhomLop->paginate($perPage, $columns);
        return $listData;
    }

    public function save(array $data)
    {
        return $this->nhomLop->create($data);

    }

    public function update(array $data, $id)
    {
        $dep = $this->nhomLop->find($id);
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

        $data = $this->nhomLop->where($column, $value)->first();
        if ($data) {
            return $data;
        }
        return null;


    }

    public function getByMultiColumn(array $where, $columnsSelected = array('*'))
    {

        $data = $this->nhomLop;

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

        $data = $this->nhomLop->where($column, $value)->get();
        if ($data) {
            return $data;
        }
        return null;


    }

    public function getListByMultiColumn(array $where, $columnsSelected = array('*'))
    {

        $data = $this->nhomLop;

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
        $del = $this->nhomLop->find($id);
        if ($del !== null) {
            $del->delete();
            return true;
        } else {
            return false;
        }
    }

    public function deleteMulti(array $data)
    {
        $del = $this->nhomLop->whereIn("id", $data["list_id"])->delete();
        if ($del) {

            return true;
        } else {
            return false;
        }
    }

} 