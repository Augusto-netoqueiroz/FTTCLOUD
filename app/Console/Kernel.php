<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

/**
 * Console Kernel
 *
 * Aqui são definidos os comandos Artisan agendados e personalizados.
 */
class Kernel extends ConsoleKernel
{
    /**
     * Define a programação de tarefas para o aplicativo.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Exemplos de agendamento:
        // $schedule->command('inspire')->hourly();
    }

    /**
     * Registra os comandos personalizados do aplicativo.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}