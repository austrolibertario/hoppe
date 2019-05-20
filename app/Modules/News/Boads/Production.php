<?php

namespace App\Modules\News\Boards;

use App\Modules\News\Boards\Component\Book;

class Production
{
    public function getTypes($user, $topic, $blog)
    {
        return [
            Book::class
        ];
    }

    public function showData()
    {

        $markets = Market::where()->get();

        $news = NewsModel::where()->get();

        dd($markets, $news);
    }
}
