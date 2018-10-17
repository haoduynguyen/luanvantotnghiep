<?php

namespace App\Repositories\Repository;

use App\Models\UserRoleRelation;
use App\Repositories\Interfaces\UserRoleRelationRepositoryInterface;

class UserRoleRelationRepository implements UserRoleRelationRepositoryInterface
{
    private $userRoleRelation;

    public function __construct()
    {
        $this->userRoleRelation = new UserRoleRelation();
    }


    public function get($id, $columns = array('*'))
    {
        $data = $this->userRoleRelation->find($id, $columns);
        if ($data) {
            return $data;
        }
        return null;

    }

    public function all($columns = array('*'))
    {
        $listData = $this->userRoleRelation->get($columns);
        return $listData;
    }

    public function paginate($perPage = 15, $columns = array('*'))
    {
        $listData = $this->userRoleRelation->paginate($perPage, $columns);
        return $listData;
    }

    public function save(array $data)
    {
        return $this->userRoleRelation->create($data);

    }

    public function update(array $data, $id)
    {
        $dep = $this->userRoleRelation->find($id);
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

        $data = $this->userRoleRelation->where($column, $value)->first();
        if ($data) {
            return $data;
        }
        return null;


    }

    public function getByMultiColumn(array $where, $columnsSelected = array('*'))
    {

        $data = $this->userRoleRelation;

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

        $data = $this->userRoleRelation->where($column, $value)->get();
        if ($data) {
            return $data;
        }
        return null;


    }

    public function getListByMultiColumn(array $where, $columnsSelected = array('*'))
    {

        $data = $this->userRoleRelation;

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
        $del = $this->userRoleRelation->find($id);
        if ($del !== null) {
            $del->delete();
            return true;
        } else {
            return false;
        }
    }

    public function deleteMulti(array $data)
    {
        $del = $this->userRoleRelation->whereIn("id", $data["list_id"])->delete();
        if ($del) {

            return true;
        } else {
            return false;
        }
    }

} 