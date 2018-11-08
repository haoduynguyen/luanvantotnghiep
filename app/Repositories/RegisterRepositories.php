<?php 
namespace App\Repositories; 
use Illuminate\Support\ServiceProvider; 
class RegisterRepositories extends ServiceProvider 
{ 
  public function register() 
  { 
 
        $this->app->bind( 
           'App\Repositories\Interfaces\CaRepositoryInterface', 
           'App\Repositories\Repository\CaRepository' 
 
        ); 
        $this->app->bind( 
           'App\Repositories\Interfaces\DangKyMuonPhongRepositoryInterface', 
           'App\Repositories\Repository\DangKyMuonPhongRepository' 
 
        ); 
        $this->app->bind( 
           'App\Repositories\Interfaces\DangKyNghiRepositoryInterface', 
           'App\Repositories\Repository\DangKyNghiRepository' 
 
        ); 
        $this->app->bind( 
           'App\Repositories\Interfaces\HocKyRepositoryInterface', 
           'App\Repositories\Repository\HocKyRepository' 
 
        ); 
        $this->app->bind( 
           'App\Repositories\Interfaces\LichDayRepositoryInterface', 
           'App\Repositories\Repository\LichDayRepository' 
 
        ); 
        $this->app->bind( 
           'App\Repositories\Interfaces\LichDayTuanRelationRepositoryInterface', 
           'App\Repositories\Repository\LichDayTuanRelationRepository' 
 
        ); 
        $this->app->bind( 
           'App\Repositories\Interfaces\MonHocRepositoryInterface', 
           'App\Repositories\Repository\MonHocRepository' 
 
        ); 
        $this->app->bind( 
           'App\Repositories\Interfaces\NhomLopRepositoryInterface', 
           'App\Repositories\Repository\NhomLopRepository' 
 
        ); 
        $this->app->bind( 
           'App\Repositories\Interfaces\PhongMayRepositoryInterface', 
           'App\Repositories\Repository\PhongMayRepository' 
 
        ); 
        $this->app->bind( 
           'App\Repositories\Interfaces\RoleRepositoryInterface', 
           'App\Repositories\Repository\RoleRepository' 
 
        ); 
        $this->app->bind( 
           'App\Repositories\Interfaces\ThuRepositoryInterface', 
           'App\Repositories\Repository\ThuRepository' 
 
        ); 
        $this->app->bind( 
           'App\Repositories\Interfaces\TuanMuonPhongRelationRepositoryInterface', 
           'App\Repositories\Repository\TuanMuonPhongRelationRepository' 
 
        ); 
        $this->app->bind( 
           'App\Repositories\Interfaces\TuanRepositoryInterface', 
           'App\Repositories\Repository\TuanRepository' 
 
        ); 
        $this->app->bind( 
           'App\Repositories\Interfaces\UserProfileRepositoryInterface', 
           'App\Repositories\Repository\UserProfileRepository' 
 
        ); 
        $this->app->bind( 
           'App\Repositories\Interfaces\UserRepositoryInterface', 
           'App\Repositories\Repository\UserRepository' 
 
        ); 
        $this->app->bind( 
           'App\Repositories\Interfaces\UserRoleRelationRepositoryInterface', 
           'App\Repositories\Repository\UserRoleRelationRepository' 
 
        ); 
  } 
} 
