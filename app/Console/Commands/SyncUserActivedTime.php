<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Cache;

class SyncUserActivedTime extends Command
{
    protected $signature = 'phphub:sync-user-actived-time';


    protected $description = 'Sincronizar tempo ativo do usuário';


    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $data = Cache::pull(config('phphub.actived_time_for_update'));
        if (!$data) {
            $this->error(_t('Erro: Nenhum registro!'));
            return false;
        }

        foreach ($data as $user_id => $last_actived_at) {
            User::query()->where('id', $user_id)
                         ->update(['last_actived_at' => $last_actived_at]);
        }

        $this->info(_t('Feito!'));
    }
}
