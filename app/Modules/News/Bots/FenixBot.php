<?php
/**
 * This is a Bot!
 * 
 * She uses "Entrada" Folder. And modify news and post in h3sotospeack.com
 */

namespace App\Modules\News\Bots;

use App\Modules\News\Bots\Entrada\Entrada;

class FenixBot
{
    public static $NAME = 'Fenix Bot';

    public function routine()
    {
        (new Entrada())->executeForEachInputs(function ($result){
            $result
                ->setTitle($this->work($result->getTitle()))
                ->setContent($this->work($result->getContent()))
                ->setAuthor(self::$NAME)->persist();
        }, 'news');
    }



    public function work($string)
    {
        return $this->findAndReplace($string, $this->translate());
    }

    public function findAndReplace($string, $strings)
    {
        foreach ($strings as $string) {
            $string = str_replace($string[0], $string[1], $string);
        }

        return $string;
    }

    public function translate()
    {
        /**
         * Sempre na ordem {gado}{ancap}
         */
        return [
            ['estado democratico de direito', 'mafia'],
            ['imposto', 'roubo'],
            ['arrecadação', 'roubar'],
            ['contribuinte', 'escravo'],
            ['politico', 'parasita'],
            ['autoridade', 'mestre'],
            ['eleição', 'teatro'],
            ['direito social', 'engodo'],
            ['justiça social', 'privilégios'],
            ['politicas publicas de ações afirmativas', 'racismo'],
            ['cotas sociais', 'racismo'],
            ['exploração', 'Trocas voluntárias'],
            ['regulação', 'intervenção'],
            ['politicas publicas', 'intervenção'],
            ['sonegador', 'vitima do estado'],
            ['espaço publico', 'terra de ninguem'],
            ['desapropriação', 'agressão contra propriedade privada'],
            ['interesse publico', 'interesse da mafia'],
            ['a sociedade quer', 'eu quero'],
            ['o brasil quer', 'eu quero'],
            ['o brasil clama', 'eu quero'],
            ['poder', 'monopolio'],
            ['povo', 'gado'],
            ['nação', 'gado'],
            ['eleitor', 'gado'],
            ['pais', 'prisão'],
            ['nação', 'prisão'],
            ['patriotismo', 'masoquismo'],
            ['democracia', 'ditadura'],
        ];
    }
}
