<?php

namespace App\Modules\News\Boards;

use App\Models\Activity;

class News
{
    public function prepareData($user, $topic, $blog)
    {
        // Carrega Noticias





        // Carrega Bolsas de Valores
    }

    public function showData()
    {

        $news = NewsModel::where()->get();

        dd($news);
    }
}
