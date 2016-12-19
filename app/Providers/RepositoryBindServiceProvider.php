<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryBindServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->singleton('App\Repositories\AdminUserRepositoryInterface',
            'App\Repositories\Eloquent\AdminUserRepository');

        $this->app->singleton('App\Repositories\AdminUserRoleRepositoryInterface',
            'App\Repositories\Eloquent\AdminUserRoleRepository');

        $this->app->singleton('App\Repositories\UserRepositoryInterface', 'App\Repositories\Eloquent\UserRepository');

        $this->app->singleton('App\Repositories\FileRepositoryInterface', 'App\Repositories\Eloquent\FileRepository');

        $this->app->singleton('App\Repositories\ImageRepositoryInterface', 'App\Repositories\Eloquent\ImageRepository');

        $this->app->singleton('App\Repositories\SiteConfigurationRepositoryInterface',
            'App\Repositories\Eloquent\SiteConfigurationRepository');

        $this->app->singleton('App\Repositories\UserServiceAuthenticationRepositoryInterface',
            'App\Repositories\Eloquent\UserServiceAuthenticationRepository');

        $this->app->singleton('App\Repositories\PasswordResettableRepositoryInterface',
            'App\Repositories\Eloquent\PasswordResettableRepository');

        $this->app->singleton('App\Repositories\UserPasswordResetRepositoryInterface',
            'App\Repositories\Eloquent\UserPasswordResetRepository');

        $this->app->singleton('App\Repositories\AdminPasswordResetRepositoryInterface',
            'App\Repositories\Eloquent\AdminPasswordResetRepository');

        $this->app->singleton(
            'App\Repositories\SiteConfigurationRepositoryInterface',
            'App\Repositories\Eloquent\SiteConfigurationRepository'
        );

        $this->app->singleton(
            'App\Repositories\SiteConfigurationRepositoryInterface',
            'App\Repositories\Eloquent\SiteConfigurationRepository'
        );

        $this->app->singleton(
            'App\Repositories\ArticleRepositoryInterface',
            'App\Repositories\Eloquent\ArticleRepository'
        );

        $this->app->singleton(
            'App\Repositories\NotificationRepositoryInterface',
            'App\Repositories\Eloquent\NotificationRepository'
        );

        $this->app->singleton(
            'App\Repositories\UserNotificationRepositoryInterface',
            'App\Repositories\Eloquent\UserNotificationRepository'
        );

        $this->app->singleton(
            'App\Repositories\AdminUserNotificationRepositoryInterface',
            'App\Repositories\Eloquent\AdminUserNotificationRepository'
        );

        $this->app->singleton(
            'App\Repositories\CustomerRepositoryInterface',
            'App\Repositories\Eloquent\CustomerRepository'
        );

        $this->app->singleton(
            'App\Repositories\ProvinceRepositoryInterface',
            'App\Repositories\Eloquent\ProvinceRepository'
        );

        $this->app->singleton(
            'App\Repositories\DistrictRepositoryInterface',
            'App\Repositories\Eloquent\DistrictRepository'
        );

        $this->app->singleton(
            'App\Repositories\EmployeeRepositoryInterface',
            'App\Repositories\Eloquent\EmployeeRepository'
        );

        /* NEW BINDING */
    }
}
