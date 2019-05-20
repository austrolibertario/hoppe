<?php

namespace App\Modules\News\Entrada;

use App\Models\Activity;

class Entrada
{
    public function __construct()
    {
        
    }

    public  static function getInputs($type = 'news')
    {
        $inputs = [
            'news' => [
                (new \App\Modules\News\Bots\Entrada\G1()),
                (new \App\Modules\News\Bots\Entrada\LeituraAncap()),
                (new \App\Modules\News\Bots\Entrada\Portaldobitcoin())
            ],
            'markets' => [
                (new \App\Modules\News\Bots\Entrada\Cripto())
            ]
        ];
        return $inputs[$type];
    }

    public static function executeForEachInputs($function, $type = 'news')
    {
        $inputs = self::getInputs($type);
        foreach($inputs as $input)
        {
            $input->execForEachResult($function);
        }
    }
}
