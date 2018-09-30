<?php 
namespace App\Repositories; 
use Illuminate\Support\ServiceProvider; 
class RegisterRepositories extends ServiceProvider 
{ 
  public function register() 
  { 
 
        $this->app->bind( 
           'App\Repositories\Interfaces\UserRepositoryInterface', 
           'App\Repositories\Repository\UserRepository' 
 
        ); 
  } 
} 
