<?php
/**
 * This is a Bot!
 * 
 * She uses "Entrada" Folder. And modify news and post in h3sotospeack.com
 */

namespace App\Modules\News\Bots;

use App\Modules\News\Bots\Entrada\Entrada;

class MirrorBot
{
    public function routine()
    {
        (new Entrada())->executeForEachInputs(function ($result){

        }, 'news');
    }

}
