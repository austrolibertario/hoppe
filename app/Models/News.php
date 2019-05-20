<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cache;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;

class News extends Model
{
    // For admin log
    use RevisionableTrait;
    protected $keepRevisionOf = [
        'deleted_at'
    ];
    use SoftDeletes;

    public static function boot() {
        parent::boot();

        static::saving(function($article) {
            Cache::forget('phphub_news');
        });
    }

    public function setImageUrlAttribute($file_name)
    {
        if (starts_with($file_name, 'http')) {
            $parser_url = explode('/', $file_name);
            $file_name = end($parser_url);
        }

        $this->attributes['image_url'] = 'uploads/news/'.$file_name;
    }

    public function getImageUrlAttribute($file_name)
    {
        if (starts_with($file_name, 'http')) {
            return $file_name;
        }

        return cdn($file_name);
    }

    public static function allByPosition()
    {
        $data = Cache::remember('phphub_News', 60, function(){
            $return = [];
            $data   = News::orderBy('position', 'DESC')
                            ->orderBy('order', 'ASC')
                            ->get();

            foreach ($data as $News) {
                $return[$News->position][] = $News;
            }
            return $return;
        });

        return $data;
    }
}
