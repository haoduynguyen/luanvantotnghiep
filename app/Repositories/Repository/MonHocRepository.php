<?php

namespace App\Repositories\Repository;

use App\Models\MonHoc;
use App\Repositories\Interfaces\MonHocRepositoryInterface;

class MonHocRepository implements MonHocRepositoryInterface
{
    private $monHoc;

    public function __construct()
    {
        $this->monHoc = new MonHoc();
    }


    public function get($id, $columns = array('*'))
    {
        $data = $this->monHoc->find($id, $columns);
        if ($data) {
            return $data;
        }
        return null;

    }

    public function all($columns = array('*'))
    {
        $listData = $this->monHoc->get($columns);
        foreach ($listData as $k => $v) {
            $v->ngay_bat_dau = date('d-m-Y', strtotime($v->ngay_bat_dau));
            $v->ngay_ket_thuc = date('d-m-Y', strtotime($v->ngay_ket_thuc));
        }
        return $listData;
    }

    public function paginate($perPage = 15, $columns = array('*'))
    {
        $listData = $this->monHoc->paginate($perPage, $columns);
        return $listData;
    }

    public function save(array $data)
    {
        return $this->monHoc->create($data);

    }

    public function update(array $data, $id)
    {
        $dep = $this->monHoc->find($id);
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

        $data = $this->monHoc->where($column, $value)->first();
        if ($data) {
            return $data;
        }
        return null;


    }

    public function getByMultiColumn(array $where, $columnsSelected = array('*'))
    {

        $data = $this->monHoc;

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

        $data = $this->monHoc->where($column, $value)->get();
        if ($data) {
            return $data;
        }
        return null;


    }

    public function getListByMultiColumn(array $where, $columnsSelected = array('*'))
    {

        $data = $this->monHoc;

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
        $del = $this->monHoc->find($id);
        if ($del !== null) {
            $del->delete();
            return true;
        } else {
            return false;
        }
    }

    public function deleteMulti(array $data)
    {
        $del = $this->monHoc->whereIn("id", $data["list_id"])->delete();
        if ($del) {

            return true;
        } else {
            return false;
        }
    }



} 