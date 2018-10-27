<?php 
namespace App\Repositories\Repository; 
 
use App\Repositories\Interfaces\DangKyMuonPhongRepositoryInterface; 
 
class DangKyMuonPhongRepository implements DangKyMuonPhongRepositoryInterface 
{ 
	private $dangKyMuonPhong; 
	public function __construct() { $this->dangKyMuonPhong = new DangKyMuonPhong();}
                 
 
	public function get($id,$columns = array('*'))
        {
                    $data = $this->dangKyMuonPhong->find($id, $columns);
                        if ($data)
                        {
                            return $data;
                        }
                        return null;
        
        }  
	public function all($columns = array('*'))
        {
            $listData = $this->dangKyMuonPhong->get($columns);
            return $listData;
        }  
	public function paginate($perPage = 15,$columns = array('*'))
        {
            $listData = $this->dangKyMuonPhong->paginate($perPage, $columns);
            return $listData;
        }  
	public function save(array $data) 
        {
        return $this->dangKyMuonPhong->create($data);
            
        }  
	public function update(array $data,$id) {
         $dep =  $this->dangKyMuonPhong->find($id);
        if ($dep)
        {
            foreach ($dep->getFillable() as $field)
            {
                if (array_key_exists($field,$data)){
                    $dep->$field = $data[$field];
                }
            }
            if ($dep->save())
            {
                return true;
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
        }  
	public function getByColumn($column,$value,$columnsSelected = array('*')) 
        {
        
             $data = $this->dangKyMuonPhong->where($column,$value)->first();
            if ($data)
            {
                return $data;
            }
            return null;
        
        
        }  
	public function getByMultiColumn(array $where,$columnsSelected = array('*')) 
        {
        
             $data = $this->dangKyMuonPhong;
           
            foreach ($where as $key => $value) {
                $data = $data->where($key, $value);
            }
    
            $data = $data->first();
             
           
            if ($data)
            {
                return $data;
            }
            return null;
        
        
        }  
	public function getListByColumn($column,$value,$columnsSelected = array('*')) 
        {
        
             $data = $this->dangKyMuonPhong->where($column,$value)->get();
            if ($data)
            {
                return $data;
            }
            return null;
        
        
        }  
	public function getListByMultiColumn(array $where,$columnsSelected = array('*')) 
        {
        
             $data = $this->dangKyMuonPhong;
             
              foreach ($where as $key => $value) {
            $data = $data->where($key, $value);
        }

        $data = $data->get();
        
            if ($data)
            {
                return $data;
            }
            return null;
        
        
        }  
	public function delete($id)
        {
            $del = $this->dangKyMuonPhong->find($id);
            if ($del !== null)
            {
                $del->delete();
                return true;
            }
            else{
                return false;
            }
        } 
         
	public function deleteMulti(array $data)
        {
            $del = $this->dangKyMuonPhong->whereIn("id",$data["list_id"])->delete();
            if ($del)
            {
              
                return true;
            }
            else{
                return false;
            }
        } 
         
} 