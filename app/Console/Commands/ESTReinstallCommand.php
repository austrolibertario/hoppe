<?php namespace App\Console\Commands;

class ESTReinstallCommand extends BaseCommand
{
    protected $signature = 'est:reinstall {--force : enforce}';

    protected $description = "Redefinir banco de dados, redefinir RABC. Use somente no ambiente local";

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {

        $this->productionCheckHint(_t('Reset database and reset RABC'));

        // fixing db:seed class not found
        $this->execShellWithPrettyPrint('composer dump');

        $this->execShellWithPrettyPrint('php artisan est:dbreset --force');
        $this->execShellWithPrettyPrint('php artisan est:init-rbac');

        $this->execShellWithPrettyPrint('php artisan cache:clear');

        $this->printBenchInfo();
    }
}
