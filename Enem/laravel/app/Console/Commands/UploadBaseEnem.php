<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Http\Controllers\EnemController;
use Symfony\Component\Console\Input\InputArgument;

class UploadBaseEnem extends Command
{
    protected $signature = 'base:up {path} {--truncate}';
    protected $description = 'Realiza o upload da base dos microdados do Enem para o banco de dados';

    public function handle()
    {
        $inicio = now();

        $valor = $this->argument('path');
        $truncate = $this->option('truncate');

        if($truncate)
            $this->alert('Os dados serão excluídos (opção "--truncate" ativada)');

        $this->info('Enem: STARTING ('.Carbon::now()->format(Carbon::DEFAULT_TO_STRING_FORMAT).')...');
        $this->info(' - Uploading: ' . $valor);

        $controller = new EnemController();
        $res = $controller->uploadAndSaveCSV($valor ?? "C:\Users\b7s\Downloads\TESTE_MICRODADOS_ENEM_2022.csv", $truncate);

        $this->info('  -> Linhas salvas: ' . $res['lines']);

        if(count($res['errors']) > 0)
        {
            $this->warn('  -> Erros: ');

            foreach ($res['errors'] as $e)
                $this->warn('   - ' . $e);
        }

        $fim = now();
        $diffSec = $inicio->diffInSeconds($fim);

        $this->info('Executado em ' . Carbon::createFromTimestamp($diffSec)->format('H:i:s'));
        $this->info('Enem: FINISH ('.Carbon::now()->format(Carbon::DEFAULT_TO_STRING_FORMAT).')');
    }
}
