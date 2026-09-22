<?php

namespace App\Providers;

use App\Models\ItemPenjualan;
use App\Models\Penjualan;
use App\Models\Produk;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider AS ServiceProvider;
use Illuminate\pagination\Paginator;
use App\Models\User;
use Carbon\Carbon;
use App\Policies\DashboardPolicy;
use App\Policies\ItemPenjualanPolicy;
use App\Policies\PenjualanPolicy;
use App\Policies\ProdukPolicy;



class AppServiceProvider extends ServiceProvider
{
    protected $policies =[
        User::class    => DashboardPolicy::class,
        Produk::class  => ProdukPolicy::class,
        Penjualan::class => PenjualanPolicy::class,
        ItemPenjualan::class => ItemPenjualanPolicy::class
    ];
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapfive();
        Carbon::setLocale('id');
        $this->registerPolicies();
    }
}
