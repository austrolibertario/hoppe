<?php namespace App\Console\Commands;

class ESTDatabaseResetCommand extends BaseCommand
{
    protected $signature = 'import:data';

    protected $description = "Import external data";

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // @todo Criar Modelos e IMportar Dados
        $urlToGet = 'https://github.com/MiguelMedeiros/imposto-e-roubo/blob/master/src/Data/libertarians.json';
        $urlToGet = 'https://github.com/MiguelMedeiros/imposto-e-roubo/blob/master/src/Data/books.json';
    }
}
