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
