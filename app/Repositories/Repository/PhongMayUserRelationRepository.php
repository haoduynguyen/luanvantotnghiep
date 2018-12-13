<?php

namespace App\Repositories\Repository;

use App\Repositories\Interfaces\PhongMayUserRelationRepositoryInterface;
use App\Models\PhongMayUserRelation;

class PhongMayUserRelationRepository implements PhongMayUserRelationRepositoryInterface
{
    private $phongMayUserRelation;

    public function __construct()
    {
        $this->phongMayUserRelation = new PhongMayUserRelation();
    }


    public function get($id, $columns = array('*'))
    {
        $data = $this->phongMayUserRelation->find($id, $columns);
        if ($data) {
            return $data;
        }
        return null;

    }

    public function all($columns = array('*'))
    {
        $listData = $this->phongMayUserRelation->get($columns);
        return $listData;
    }

    public function paginate($perPage = 15, $columns = array('*'))
    {
        $listData = $this->phongMayUserRelation->paginate($perPage, $columns);
        return $listData;
    }

    public function save(array $data)
    {
        return $this->phongMayUserRelation->create($data);

    }

    public function update(array $data, $id)
    {
        $dep = $this->phongMayUserRelation->find($id);
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

        $data = $this->phongMayUserRelation->where($column, $value)->first();
        if ($data) {
            return $data;
        }
        return null;


    }

    public function getByMultiColumn(array $where, $columnsSelected = array('*'))
    {

        $data = $this->phongMayUserRelation;

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

        $data = $this->phongMayUserRelation->where($column, $value)->get();
        if ($data) {
            return $data;
        }
        return null;


    }

    public function getListByMultiColumn(array $where, $columnsSelected = array('*'))
    {

        $data = $this->phongMayUserRelation;

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
        $del = $this->phongMayUserRelation->find($id);
        if ($del !== null) {
            $del->delete();
            return true;
        } else {
            return false;
        }
    }

    public function deleteMulti(array $data)
    {
        $del = $this->phongMayUserRelation->whereIn("id", $data["list_id"])->delete();
        if ($del) {

            return true;
        } else {
            return false;
        }
    }

    public function list($user, $param)
    {
        if ($user->role_id == 1) {
            if (isset($param) && !empty($param)) {
                if (!empty($param['check_box_da_sua']) || !empty($param['check_box_dang_sua']) || !empty($param['check_box_chua_sua'] != 0)) {
                    $data = $this->phongMayUserRelation->PhongMayUserRelationQuery()
                        ->whereIn('status', $param)
                        ->where('gv_id', $user->id)
                        ->orderBy('created_at','desc')->get();
                } else {
                    $data = $this->phongMayUserRelation->PhongMayUserRelationQuery()->where('gv_id', $user->id)->orderBy('created_at','desc')->get();
                }
            } else {
                $data = $this->phongMayUserRelation->PhongMayUserRelationQuery()->where('gv_id', $user->id)->orderBy('created_at','desc')->get();
            }
            return $data;
        } else {
            if (isset($param) && !empty($param)) {
                if ($param['check_box_da_sua'] != 0 || $param['check_box_dang_sua'] != 0 || $param['check_box_chua_sua'] != 0) {
                    $data = $this->phongMayUserRelation->PhongMayUserRelationQuery()
                        ->whereIn('status', $param)->get();
                } else {
                    $data = $this->phongMayUserRelation->PhongMayUserRelationQuery()->get();
                    dd($data);
                }
            } else {
                $data = $this->phongMayUserRelation->PhongMayUserRelationQuery()->orderBy('created_at','desc')->get();
            }
            return $data;
        }
    }

    public function show($id)
    {
        $data = $this->phongMayUserRelation->PhongMayUserRelationQuery()->find($id);
        return $data;
    }

    public function exportList($user, $param)
    {
        if ($user->role_id == 1) {
            if (isset($param) && !empty($param)) {
                $data = $this->phongMayUserRelation->PhongMayUserRelationQuery()
                    ->where('gv_id', $user->id)
                    ->where('phong_may_id', $param['phong_may_id'])
                    ->orwhereIn('status',[$param['check_box_chua_sua'],$param['check_box_dang_sua'],$param['check_box_da_sua']])->get();
                return $data;
            }
            $data = $this->phongMayUserRelation->PhongMayUserRelationQuery()->where('gv_id', $user->id)->get();
        } else {
            if (isset($param) && !empty($param)) {
                if (!empty($param['check_box_da_sua']) || !empty($param['check_box_dang_sua']) || !empty($param['check_box_chua_sua'] || !empty($param['phong_may_id']))) {
                    $data = $this->phongMayUserRelation->PhongMayUserRelationQuery()
                        ->where('phong_may_id', $param['phong_may_id'])
                        ->orWhereIn('status', [$param['check_box_chua_sua'], $param['check_box_dang_sua'], $param['check_box_da_sua']])->get();
                    return $data;
                }
            }
            $data = $this->phongMayUserRelation->PhongMayUserRelationQuery()->get();
        }
        return $data;
    }
} 