<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;
use App\Models\PemeriksaanAwalIbuHamil;
use App\Models\PemeriksaanAwalBalita;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        require_once app_path('Support/helpers.php');
        Carbon::setLocale('id');
        setlocale(LC_TIME, 'id_ID');

        View::composer('layouts.sidebar', function ($view) {
            $today = now()->toDateString();

            $waitingIbu = PemeriksaanAwalIbuHamil::whereDate('tanggal_periksa', $today)
                ->doesntHave('pemeriksaanLanjutan')
                ->count();

            $waitingBalita = PemeriksaanAwalBalita::whereDate('tanggal_periksa', $today)
                ->doesntHave('pemeriksaanLanjutan')
                ->count();

            $view->with(compact('waitingIbu', 'waitingBalita'));
        });
    }
}