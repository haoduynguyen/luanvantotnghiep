<?php

namespace App\Repositories\Repository;

use App\Models\DangKyMuonPhong;
use App\Repositories\Interfaces\DangKyMuonPhongRepositoryInterface;


class DangKyMuonPhongRepository implements DangKyMuonPhongRepositoryInterface
{
    private $dangKyMuonPhong;

    public function __construct()
    {
        $this->dangKyMuonPhong = new DangKyMuonPhong();
    }


    public function get($id, $columns = array('*'))
    {
        $data = $this->dangKyMuonPhong->find($id, $columns);
        if ($data) {
            return $data;
        }
        return null;

    }

    public function all($columns = array('*'))
    {
        $listData = $this->dangKyMuonPhong->get($columns);
        return $listData;
    }

    public function paginate($perPage = 15, $columns = array('*'))
    {
        $listData = $this->dangKyMuonPhong->paginate($perPage, $columns);
        return $listData;
    }

    public function save(array $data)
    {
        return $this->dangKyMuonPhong->create($data);

    }

    public function update(array $data, $id)
    {
        $dep = $this->dangKyMuonPhong->find($id);
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

        $data = $this->dangKyMuonPhong->where($column, $value)->first();
        if ($data) {
            return $data;
        }
        return null;


    }

    public function getByMultiColumn(array $where, $columnsSelected = array('*'))
    {

        $data = $this->dangKyMuonPhong;

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

        $data = $this->dangKyMuonPhong->where($column, $value)->get();
        if ($data) {
            return $data;
        }
        return null;


    }

    public function getListByMultiColumn(array $where, $columnsSelected = array('*'))
    {

        $data = $this->dangKyMuonPhong;

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
        $del = $this->dangKyMuonPhong->find($id);
        if ($del !== null) {
            $del->delete();
            return true;
        } else {
            return false;
        }
    }

    public function deleteMulti(array $data)
    {
        $del = $this->dangKyMuonPhong->whereIn("id", $data["list_id"])->delete();
        if ($del) {

            return true;
        } else {
            return false;
        }
    }

    public function getDataSubmit($id)
    {
        $data = $this->dangKyMuonPhong->dkMuonPhongQuery()->find($id);
        return $data;
    }

    public function getDataMuonPhong($param)
    {

        $data = $this->dangKyMuonPhong->dkMuonPhongQuery()->where('hk_id', $param['hk_id'])
            ->whereHas('tuan', function ($query) use ($param) {
                $query->where('tuan_id', $param['tuan_id'])->where('status', 'x');
            })->get();
        return $data;
    }

    public function getDKMuonPhongFromGV($param, $user)
    {
        $data = $this->dangKyMuonPhong->dkMuonPhongQuery()->where('hk_id', $param['hk_id'])
            ->where('phong_may_id', $param['phong_may_id'])
            ->where('user_id', $user->id)
            ->whereHas('tuan', function ($query) use ($param) {
                $query->where('tuan_id', $param['tuan_id'])->where('status', 'x');
            })->get();
        return $data;
    }

    public function getDSMuonPhong($user)
    {
        if ($user->role_id == 1) {

            $data = $this->dangKyMuonPhong->dkMuonPhongQuery()
                ->where('user_id', $user->id)
                ->where('status', '1')->get();
            foreach ($data as $k => $v) {
                $v->ngay_muon = date('d-m-Y', strtotime($v->ngay_muon));
            }
        } else {
            $data = $this->dangKyMuonPhong->dkMuonPhongQuery()->get();
            foreach ($data as $k => $v) {
                $v->ngay_muon = date('d-m-Y', strtotime($v->ngay_muon));
            }
        }
        return $data;
    }
} 