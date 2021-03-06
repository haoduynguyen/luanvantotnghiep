<?php

namespace App\Repositories\Repository;

use App\Models\DangKyNghi;
use App\Repositories\Interfaces\DangKyNghiRepositoryInterface;

class DangKyNghiRepository implements DangKyNghiRepositoryInterface
{
    private $dangKyNghi;


    public function __construct()
    {
        $this->dangKyNghi = new DangKyNghi();
    }


    public function get($id, $columns = array('*'))
    {
        $data = $this->dangKyNghi->find($id, $columns);
        if ($data) {
            return $data;
        }
        return null;

    }

    public function all($columns = array('*'))
    {
        $listData = $this->dangKyNghi->get($columns);
        return $listData;
    }

    public function paginate($perPage = 15, $columns = array('*'))
    {
        $listData = $this->dangKyNghi->paginate($perPage, $columns);
        return $listData;
    }

    public function save(array $data)
    {
        return $this->dangKyNghi->create($data);
    }

    public function update(array $data, $id)
    {
        $dep = $this->dangKyNghi->find($id);
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

        $data = $this->dangKyNghi->where($column, $value)->first();
        if ($data) {
            return $data;
        }
        return null;


    }

    public function getByMultiColumn(array $where, $columnsSelected = array('*'))
    {

        $data = $this->dangKyNghi;

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

        $data = $this->dangKyNghi->where($column, $value)->get();
        if ($data) {
            return $data;
        }
        return null;


    }

    public function getListByMultiColumn(array $where, $columnsSelected = array('*'))
    {

        $data = $this->dangKyNghi;

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
        $del = $this->dangKyNghi->find($id);
        if ($del !== null) {
            $del->delete();
            return true;
        } else {
            return false;
        }
    }

    public function deleteMulti(array $data)
    {
        $del = $this->dangKyNghi->whereIn("id", $data["list_id"])->delete();
        if ($del) {

            return true;
        } else {
            return false;
        }
    }

    public function getDSNghi($user)
    {
        if ($user->role_id == 1) {
            $data = $this->dangKyNghi->DangKyNghiQuery()->where('gv_id', $user->id)
                ->where('status','!=',0)->get();
            foreach ($data as $v) {
                $v->lichDay = $v->LichDay->lichDayQuery()->find($v->LichDay->id);
                $v->setRelation('LichDay', null);
                $v->lichDay->setRelation('tuan', null);
                $v->ngay_nghi = date('d-m-Y', strtotime($v->ngay_nghi));
            }
        } else {
            $data = $this->dangKyNghi->DangKyNghiQuery()->get();
            foreach ($data as $v) {
                $v->lichDay = $v->LichDay->lichDayQuery()->find($v->LichDay->id);
                $v->setRelation('LichDay', null);
                $v->lichDay->setRelation('tuan', null);
                $v->ngay_nghi = date('d-m-Y', strtotime($v->ngay_nghi));
            }
        }
        return $data;
    }
} 