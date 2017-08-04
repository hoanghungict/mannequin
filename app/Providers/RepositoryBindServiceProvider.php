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

    }

    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->singleton(
            \App\Repositories\AdminUserRepositoryInterface::class,
            \App\Repositories\Eloquent\AdminUserRepository::class
        );

        $this->app->singleton(
            \App\Repositories\AdminUserRoleRepositoryInterface::class,
            \App\Repositories\Eloquent\AdminUserRoleRepository::class
        );

        $this->app->singleton(
            \App\Repositories\UserRepositoryInterface::class,
            \App\Repositories\Eloquent\UserRepository::class
        );

        $this->app->singleton(
            \App\Repositories\FileRepositoryInterface::class,
            \App\Repositories\Eloquent\FileRepository::class
        );

        $this->app->singleton(
            \App\Repositories\ImageRepositoryInterface::class,
            \App\Repositories\Eloquent\ImageRepository::class
        );

        $this->app->singleton(
            \App\Repositories\SiteConfigurationRepositoryInterface::class,
            \App\Repositories\Eloquent\SiteConfigurationRepository::class
        );

        $this->app->singleton(
            \App\Repositories\UserServiceAuthenticationRepositoryInterface::class,
            \App\Repositories\Eloquent\UserServiceAuthenticationRepository::class
        );
        $this->app->singleton(
            \App\Repositories\PasswordResettableRepositoryInterface::class,
            \App\Repositories\Eloquent\PasswordResettableRepository::class
        );

        $this->app->singleton(
            \App\Repositories\UserPasswordResetRepositoryInterface::class,
            \App\Repositories\Eloquent\UserPasswordResetRepository::class
        );

        $this->app->singleton(
            \App\Repositories\AdminPasswordResetRepositoryInterface::class,
            \App\Repositories\Eloquent\AdminPasswordResetRepository::class
        );

        $this->app->singleton(
            \App\Repositories\SiteConfigurationRepositoryInterface::class,
            \App\Repositories\Eloquent\SiteConfigurationRepository::class
        );

        $this->app->singleton(
            \App\Repositories\SiteConfigurationRepositoryInterface::class,
            \App\Repositories\Eloquent\SiteConfigurationRepository::class
        );

        $this->app->singleton(
            \App\Repositories\ArticleRepositoryInterface::class,
            \App\Repositories\Eloquent\ArticleRepository::class
        );

        $this->app->singleton(
            \App\Repositories\NotificationRepositoryInterface::class,
            \App\Repositories\Eloquent\NotificationRepository::class
        );

        $this->app->singleton(
            \App\Repositories\UserNotificationRepositoryInterface::class,
            \App\Repositories\Eloquent\UserNotificationRepository::class
        );
            
        $this->app->singleton(
            \App\Repositories\AdminUserNotificationRepositoryInterface::class,
            \App\Repositories\Eloquent\AdminUserNotificationRepository::class
        );

        $this->app->singleton(
            \App\Repositories\CustomerRepositoryInterface::class,
            \App\Repositories\Eloquent\CustomerRepository::class
        );

        $this->app->singleton(
            \App\Repositories\ProvinceRepositoryInterface::class,
            \App\Repositories\Eloquent\ProvinceRepository::class
        );

        $this->app->singleton(
            \App\Repositories\DistrictRepositoryInterface::class,
            \App\Repositories\Eloquent\DistrictRepository::class
        );

        $this->app->singleton(
            \App\Repositories\EmployeeRepositoryInterface::class,
            \App\Repositories\Eloquent\EmployeeRepository::class
        );

        $this->app->singleton(
            \App\Repositories\ProductRepositoryInterface::class,
            \App\Repositories\Eloquent\ProductRepository::class
        );

        $this->app->singleton(
            \App\Repositories\ProductOptionRepositoryInterface::class,
            \App\Repositories\Eloquent\ProductOptionRepository::class
        );

        $this->app->singleton(
            \App\Repositories\CategoryRepositoryInterface::class,
            \App\Repositories\Eloquent\CategoryRepository::class
        );

        $this->app->singleton(
            \App\Repositories\SubcategoryRepositoryInterface::class,
            \App\Repositories\Eloquent\SubcategoryRepository::class
        );

        $this->app->singleton(
            \App\Repositories\UnitRepositoryInterface::class,
            \App\Repositories\Eloquent\UnitRepository::class
        );

        $this->app->singleton(
            \App\Repositories\LogRepositoryInterface::class,
            \App\Repositories\Eloquent\LogRepository::class
        );

        $this->app->singleton(
            \App\Repositories\PropertyRepositoryInterface::class,
            \App\Repositories\Eloquent\PropertyRepository::class
        );

        $this->app->singleton(
            \App\Repositories\PropertyValueRepositoryInterface::class,
            \App\Repositories\Eloquent\PropertyValueRepository::class
        );

        $this->app->singleton(
            \App\Repositories\ProductImageRepositoryInterface::class,
            \App\Repositories\Eloquent\ProductImageRepository::class
        );

        $this->app->singleton(
            \App\Repositories\ImportPriceHistoryRepositoryInterface::class,
            \App\Repositories\Eloquent\ImportPriceHistoryRepository::class
        );

        $this->app->singleton(
            \App\Repositories\ExportPriceHistoryRepositoryInterface::class,
            \App\Repositories\Eloquent\ExportPriceHistoryRepository::class
        );

        $this->app->singleton(
            \App\Repositories\ImportRepositoryInterface::class,
            \App\Repositories\Eloquent\ImportRepository::class
        );

        $this->app->singleton(
            \App\Repositories\ImportDetailRepositoryInterface::class,
            \App\Repositories\Eloquent\ImportDetailRepository::class
        );

        $this->app->singleton(
            \App\Repositories\ProductOptionPropertyRepositoryInterface::class,
            \App\Repositories\Eloquent\ProductOptionPropertyRepository::class
        );

        $this->app->singleton(
            \App\Repositories\ExportRepositoryInterface::class,
            \App\Repositories\Eloquent\ExportRepository::class
        );

        $this->app->singleton(
            \App\Repositories\ExportDetailRepositoryInterface::class,
            \App\Repositories\Eloquent\ExportDetailRepository::class
        );

        $this->app->singleton(
            \App\Repositories\StoreRepositoryInterface::class,
            \App\Repositories\Eloquent\StoreRepository::class
        );

        /* NEW BINDING */
    }
}
