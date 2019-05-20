<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Ubench;
use App;

class BaseCommand extends Command
{
    public $bench;

    public function __construct()
    {
        parent::__construct();

        $this->bench  = new Ubench;
        $this->bench->start();

        $this->is_ask = false;
    }

    public function printBenchInfo()
    {
        // As estatísticas acabaram e as informações podem ser impressas.
        $this->bench->end();

        $this->info('-------');
        $this->info('-------');
        $this->info(_t("Execução de comando concluída, demorada: :time, uso de memória: :memory", [
            'time' => $this->bench->getTime(),
            'memory' => $this->bench->getMemoryUsage()
        ]));
        $this->info('-------');
        $this->info('-------');
    }

    public function execShellWithPrettyPrint($command)
    {
        $this->info('---');
        $this->info($command);
        $output = shell_exec($command);
        $this->info($output);
        $this->info('---');
    }

    public function productionCheckHint($message = '')
    {
        $message = $message ?: _t('Esta é uma operação "muito perigosa"');
        if (App::environment('production')
            && !$this->option('force')
            && !$this->confirm(_t('Você está no ambiente de 「Production」, :message! Você tem certeza de que quer fazer isso? [y|N]', ['message' => $message]))
        ) {
            exit(_t('Terminação de comando'));
        }
    }
}
