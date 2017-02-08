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
        $this->app->singleton(
            'App\Repositories\AdminUserRepositoryInterface',
            'App\Repositories\Eloquent\AdminUserRepository'
        );

        $this->app->singleton(
            'App\Repositories\AdminUserRoleRepositoryInterface',
            'App\Repositories\Eloquent\AdminUserRoleRepository'
        );

        $this->app->singleton( 'App\Repositories\UserRepositoryInterface', 'App\Repositories\Eloquent\UserRepository' );

        $this->app->singleton( 'App\Repositories\FileRepositoryInterface', 'App\Repositories\Eloquent\FileRepository' );

        $this->app->singleton(
            'App\Repositories\ImageRepositoryInterface',
            'App\Repositories\Eloquent\ImageRepository'
        );

        $this->app->singleton(
            'App\Repositories\SiteConfigurationRepositoryInterface',
            'App\Repositories\Eloquent\SiteConfigurationRepository'
        );

        $this->app->singleton(
            'App\Repositories\UserServiceAuthenticationRepositoryInterface',
            'App\Repositories\Eloquent\UserServiceAuthenticationRepository'
        );

        $this->app->singleton(
            'App\Repositories\PasswordResettableRepositoryInterface',
            'App\Repositories\Eloquent\PasswordResettableRepository'
        );

        $this->app->singleton(
            'App\Repositories\UserPasswordResetRepositoryInterface',
            'App\Repositories\Eloquent\UserPasswordResetRepository'
        );

        $this->app->singleton(
            'App\Repositories\AdminPasswordResetRepositoryInterface',
            'App\Repositories\Eloquent\AdminPasswordResetRepository'
        );

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

        $this->app->singleton(
            'App\Repositories\ProductRepositoryInterface',
            'App\Repositories\Eloquent\ProductRepository'
        );

        $this->app->singleton(
            'App\Repositories\ProductOptionRepositoryInterface',
            'App\Repositories\Eloquent\ProductOptionRepository'
        );

        $this->app->singleton(
            'App\Repositories\CategoryRepositoryInterface',
            'App\Repositories\Eloquent\CategoryRepository'
        );

        $this->app->singleton(
            'App\Repositories\SubcategoryRepositoryInterface',
            'App\Repositories\Eloquent\SubcategoryRepository'
        );

        $this->app->singleton(
            'App\Repositories\UnitRepositoryInterface',
            'App\Repositories\Eloquent\UnitRepository'
        );

        $this->app->singleton(
            'App\Repositories\LogRepositoryInterface',
            'App\Repositories\Eloquent\LogRepository'
        );

        $this->app->singleton(
            'App\Repositories\PropertyRepositoryInterface',
            'App\Repositories\Eloquent\PropertyRepository'
        );

        $this->app->singleton(
            'App\Repositories\PropertyValueRepositoryInterface',
            'App\Repositories\Eloquent\PropertyValueRepository'
        );

        $this->app->singleton(
            'App\Repositories\ProductImageRepositoryInterface',
            'App\Repositories\Eloquent\ProductImageRepository'
        );

        $this->app->singleton(
            'App\Repositories\ImportPriceHistoryRepositoryInterface',
            'App\Repositories\Eloquent\ImportPriceHistoryRepository'
        );

        $this->app->singleton(
            'App\Repositories\ExportPriceHistoryRepositoryInterface',
            'App\Repositories\Eloquent\ExportPriceHistoryRepository'
        );

        $this->app->singleton(
            'App\Repositories\ImportRepositoryInterface',
            'App\Repositories\Eloquent\ImportRepository'
        );

        $this->app->singleton(
            'App\Repositories\ImportDetailRepositoryInterface',
            'App\Repositories\Eloquent\ImportDetailRepository'
        );

        $this->app->singleton(
            'App\Repositories\ProductOptionPropertyRepositoryInterface',
            'App\Repositories\Eloquent\ProductOptionPropertyRepository'
        );

        $this->app->singleton(
            'App\Repositories\ExportRepositoryInterface',
            'App\Repositories\Eloquent\ExportRepository'
        );

        $this->app->singleton(
            'App\Repositories\ExportDetailRepositoryInterface',
            'App\Repositories\Eloquent\ExportDetailRepository'
        );

        $this->app->singleton(
            'App\Repositories\StoreRepositoryInterface',
            'App\Repositories\Eloquent\StoreRepository'
        );

        /* NEW BINDING */
    }
}
