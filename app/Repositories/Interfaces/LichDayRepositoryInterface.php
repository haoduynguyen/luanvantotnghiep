<?php

namespace App\Repositories\Interfaces;

interface LichDayRepositoryInterface
{
    public function get($id, $columns = array('*'));

    public function all($columns = array('*'));

    public function paginate($perPage = 15, $columns = array('*'));

    public function save(array $data);

    public function update(array $data, $id);

    public function getByColumn($column, $value);

    public function getListByColumn($column, $value, $columnsSelected = array('*'));

    public function delete($id);

    public function deleteMulti(array $data);

    public function getLichDay($param);

    public function getLichDayFromGv($param, $user);

    public function getListByMultiColumn(array $where, $columnsSelected = array('*'));

    public function getByMultiColumn(array $where, $columnsSelected = array('*'));

    public function getListDoubleLichDay($data , $param);
} 