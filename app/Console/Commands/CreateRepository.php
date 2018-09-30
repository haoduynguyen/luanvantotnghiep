<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateRepository extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'repository {nameRepository}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Repository';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //

        $nameRepository = $this->argument('nameRepository');
        if (!file_exists(app_path('/Repositories/Interfaces') . '/' . $nameRepository . 'RepositoryInterface.php')) {
            $this->_createInterFaces($nameRepository);
            $this->_createRepository($nameRepository);
            $this->_updateRegisterRepositories();
        } else {
            var_dump('File Exits');
        }

    }

    private function _createInterFaces($nameRepository)
    {
        $nameInterFace = $nameRepository . "RepositoryInterface";
        $fileName = $nameInterFace . ".php";
        $myfile = fopen(app_path('/Repositories/Interfaces') . '/' . $fileName, "w");
        $txt = "<?php \n";
        fwrite($myfile, $txt);

        $txt = 'namespace App\Repositories\Interfaces;';
        fwrite($myfile, $txt);

        $txt = " \n \n";
        fwrite($myfile, $txt);

        $txt = 'interface ' . $nameInterFace;
        fwrite($myfile, $txt);
        $txt = " \n";
        fwrite($myfile, $txt);

        $txt = '{';
        fwrite($myfile, $txt);

        $txt = " \n";
        fwrite($myfile, $txt);

        $txt = ' public function get($id,$columns = array(\'*\')); ';
        fwrite($myfile, $txt);

        $txt = " \n";
        fwrite($myfile, $txt);

        $txt = ' public function all($columns = array(\'*\')); ';
        fwrite($myfile, $txt);

        $txt = " \n";
        fwrite($myfile, $txt);

        $txt = ' public function paginate($perPage = 15, $columns = array(\'*\')); ';
        fwrite($myfile, $txt);

        $txt = " \n";
        fwrite($myfile, $txt);

        $txt = ' public function save(array $data) ; ';
        fwrite($myfile, $txt);
        $txt = " \n";
        fwrite($myfile, $txt);

        $txt = ' public function update(array $data,$id) ; ';
        fwrite($myfile, $txt);
        $txt = " \n";
        fwrite($myfile, $txt);

        $txt = ' public function getByColumn($column,$value) ; ';
        fwrite($myfile, $txt);
        $txt = " \n";
        fwrite($myfile, $txt);


        $txt = ' public function getListByColumn($column,$value,$columnsSelected = array(\'*\')) ; ';
        fwrite($myfile, $txt);
        $txt = " \n";
        fwrite($myfile, $txt);

        $txt = ' public function delete($id); ';
        fwrite($myfile, $txt);

        $txt = " \n";
        fwrite($myfile, $txt);

        $txt = ' public function deleteMulti(array $data); ';
        fwrite($myfile, $txt);

        $txt = " \n";
        fwrite($myfile, $txt);


        $txt = '} ';
        fwrite($myfile, $txt);

        fclose($myfile);
    }

    private function _createRepository($name)
    {
        $nameRepository = $name . "Repository";
        $fileName = $nameRepository . ".php";
        $myfile = fopen(app_path('/Repositories/Repository') . '/' . $fileName, "w");
        $txt = "<?php \n";
        fwrite($myfile, $txt);

        $txt = 'namespace App\Repositories\Repository;';
        fwrite($myfile, $txt);

        $txt = " \n \n";
        fwrite($myfile, $txt);

        $txt = 'use App\Repositories\Interfaces' . trim(' \ ') . $nameRepository . "Interface;";
        fwrite($myfile, $txt);

        $txt = " \n \n";
        fwrite($myfile, $txt);

        $txt = 'class ' . $nameRepository . ' implements ' . $nameRepository . 'Interface';
        fwrite($myfile, $txt);
        $txt = " \n";
        fwrite($myfile, $txt);

        $txt = '{';
        fwrite($myfile, $txt);

        $txt = " \n";
        fwrite($myfile, $txt);

        $txt = "\tprivate $" . lcfirst($name) . ";";
        fwrite($myfile, $txt);
        $txt = " \n";
        fwrite($myfile, $txt);
        $txt = "\tpublic function __construct() { \$this->" . lcfirst($name) . " = new " . $name . "();}
                ";
        fwrite($myfile, $txt);
        $txt = " \n";
        fwrite($myfile, $txt);


        $txt = " \n";
        fwrite($myfile, $txt);

        $txt = "\t" . 'public function get($id,$columns = array(\'*\'))
        {
                    $data = $this->' . lcfirst($name) . '->find($id, $columns);
                        if ($data)
                        {
                            return $data;
                        }
                        return null;
        
        } ';
        fwrite($myfile, $txt);

        $txt = " \n";
        fwrite($myfile, $txt);

        $txt = "\t" . 'public function all($columns = array(\'*\'))
        {
            $listData = $this->' . lcfirst($name) . '->get($columns);
            return $listData;
        } ';
        fwrite($myfile, $txt);

        $txt = " \n";
        fwrite($myfile, $txt);

        $txt = "\t" . 'public function paginate($perPage = 15,$columns = array(\'*\'))
        {
            $listData = $this->' . lcfirst($name) . '->paginate($perPage, $columns);
            return $listData;
        } ';
        fwrite($myfile, $txt);

        $txt = " \n";
        fwrite($myfile, $txt);

        $txt = "\t" . 'public function save(array $data) 
        {
        return $this->' . lcfirst($name) . '->create($data);
            
        } ';
        fwrite($myfile, $txt);
        $txt = " \n";
        fwrite($myfile, $txt);

        $txt = "\t" . 'public function update(array $data,$id) {
         $dep =  $this->' . lcfirst($name) . '->find($id);
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
        } ';
        fwrite($myfile, $txt);
        $txt = " \n";
        fwrite($myfile, $txt);

        $txt = "\t" . 'public function getByColumn($column,$value,$columnsSelected = array(\'*\')) 
        {
        
             $data = $this->' . lcfirst($name) . '->where($column,$value)->first();
            if ($data)
            {
                return $data;
            }
            return null;
        
        
        } ';
        fwrite($myfile, $txt);
        $txt = " \n";
        fwrite($myfile, $txt);

        $txt = "\t" . 'public function getByMultiColumn(array $where,$columnsSelected = array(\'*\')) 
        {
        
             $data = $this->' . lcfirst($name) . ';
           
            foreach ($where as $key => $value) {
                $data = $data->where($key, $value);
            }
    
            $data = $data->first();
             
           
            if ($data)
            {
                return $data;
            }
            return null;
        
        
        } ';
        fwrite($myfile, $txt);
        $txt = " \n";
        fwrite($myfile, $txt);


        $txt = "\t" . 'public function getListByColumn($column,$value,$columnsSelected = array(\'*\')) 
        {
        
             $data = $this->' . lcfirst($name) . '->where($column,$value)->get();
            if ($data)
            {
                return $data;
            }
            return null;
        
        
        } ';
        fwrite($myfile, $txt);
        $txt = " \n";
        fwrite($myfile, $txt);

        $txt = "\t" . 'public function getListByMultiColumn(array $where,$columnsSelected = array(\'*\')) 
        {
        
             $data = $this->' . lcfirst($name) . ';
             
              foreach ($where as $key => $value) {
            $data = $data->where($key, $value);
        }

        $data = $data->get();
        
            if ($data)
            {
                return $data;
            }
            return null;
        
        
        } ';
        fwrite($myfile, $txt);
        $txt = " \n";
        fwrite($myfile, $txt);

        $txt = "\t" . 'public function delete($id)
        {
            $del = $this->' . lcfirst($name) . '->find($id);
            if ($del !== null)
            {
                $del->delete();
                return true;
            }
            else{
                return false;
            }
        } 
        ';
        fwrite($myfile, $txt);

        $txt = " \n";
        fwrite($myfile, $txt);


        $txt = "\t" . 'public function deleteMulti(array $data)
        {
            $del = $this->' . lcfirst($name) . '->whereIn("id",$data["list_id"])->delete();
            if ($del)
            {
              
                return true;
            }
            else{
                return false;
            }
        } 
        ';
        fwrite($myfile, $txt);

        $txt = " \n";
        fwrite($myfile, $txt);


        $txt = '} ';
        fwrite($myfile, $txt);

        fclose($myfile);
    }

    private function _updateRegisterRepositories()
    {
        $fileEloquent = \File::allFiles(app_path('/Repositories/Repository'));
        $listFileEloquent = [];

        foreach ($fileEloquent as $file) {
            $pathFile = (string)$file;
            $pathFile = explode('Repositories/Repository', $pathFile);
            if (isset($pathFile[1]) && $pathFile[1] != null) {

                $pathFile = $pathFile[1];
                $pathFile = str_replace('.php', '', $pathFile);
                $pathFile = str_replace('/', '', $pathFile);
                $pathFile = str_replace(trim(' \ '), '', $pathFile);
                $listFileEloquent[] = $pathFile;

            }
        }


        $myfile = fopen(app_path('/Repositories/RegisterRepositories.php'), "w");
        $txt = "<?php \n";
        fwrite($myfile, $txt);

        $txt = 'namespace App\Repositories;';
        fwrite($myfile, $txt);

        $txt = " \n";
        fwrite($myfile, $txt);

        $txt = 'use Illuminate\Support\ServiceProvider;';
        fwrite($myfile, $txt);


        $txt = " \n";
        fwrite($myfile, $txt);

        $txt = 'class RegisterRepositories extends ServiceProvider';
        fwrite($myfile, $txt);


        $txt = " \n";
        fwrite($myfile, $txt);

        $txt = '{';
        fwrite($myfile, $txt);

        $txt = " \n";
        fwrite($myfile, $txt);

        $txt = "  public function register()";
        fwrite($myfile, $txt);
        $txt = " \n";
        fwrite($myfile, $txt);

        $txt = "  {";
        fwrite($myfile, $txt);

        $txt = " \n";
        fwrite($myfile, $txt);


        if ($listFileEloquent) {
            foreach ($listFileEloquent as $fileName) {
                $txt = " \n";
                fwrite($myfile, $txt);

                $txt = '        $this->app->bind(';
                fwrite($myfile, $txt);

                $txt = " \n";
                fwrite($myfile, $txt);

                $txt = "           'App" . trim(' \ ') . "Repositories" . trim(' \ ') . "Interfaces" . trim(' \ ') . $fileName . "Interface',";
                fwrite($myfile, $txt);

                $txt = " \n";
                fwrite($myfile, $txt);

                $txt = "           'App" . trim(' \ ') . "Repositories" . trim(' \ ') . "Repository" . trim(' \ ') . $fileName . "'";
                fwrite($myfile, $txt);

                $txt = " \n";
                fwrite($myfile, $txt);

                $txt = " \n";
                fwrite($myfile, $txt);

                $txt = '        );';
                fwrite($myfile, $txt);
            }
        }


        $txt = " \n";
        fwrite($myfile, $txt);

        $txt = "  }";
        fwrite($myfile, $txt);

        $txt = " \n";
        fwrite($myfile, $txt);
        $txt = '}';
        fwrite($myfile, $txt);

        $txt = " \n";
        fwrite($myfile, $txt);

        fclose($myfile);
    }
}
