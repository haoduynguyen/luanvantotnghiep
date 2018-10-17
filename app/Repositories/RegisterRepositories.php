<?php 
namespace App\Repositories; 
use Illuminate\Support\ServiceProvider; 
class RegisterRepositories extends ServiceProvider 
{ 
  public function register() 
  { 
 
        $this->app->bind( 
           'App\Repositories\Interfaces\haoRepositoryInterface', 
           'App\Repositories\Repository\haoRepository' 
 
        ); 
        $this->app->bind( 
           'App\Repositories\Interfaces\TestRepositoryInterface', 
           'App\Repositories\Repository\TestRepository' 
 
        ); 
        $this->app->bind( 
           'App\Repositories\Interfaces\UserRepositoryInterface', 
           'App\Repositories\Repository\UserRepository' 
 
        ); 
  } 
} 
