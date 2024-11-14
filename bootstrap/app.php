<?php

use App\Http\Middleware\KaryawanMiddleware;
use App\Http\Middleware\OwnerMiddleware;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'karyawanMiddleware' => KaryawanMiddleware::class,
            'ownerMiddleware' => OwnerMiddleware::class
        ]);
    })
    ->withSchedule(function(Schedule $schedule){
        $schedule->command('insert-laporan-stok'); //sesuaikan kapan scheduler harus menjalankan perintah
    })    
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
