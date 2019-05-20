<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cache;
use Laracasts\Presenter\PresentableTrait;
use App\Phphub\Presenters\SitePresenter;

class Site extends Model
{
    use PresentableTrait;
    protected $presenter = SitePresenter::class;

    protected $guarded = ['id'];

    public static function boot() {
        parent::boot();

        static::saving(function($model) {
            Cache::forget('phphub_sites');
        });
    }

    public static function allFromCache($expire = 1440)
    {
        $data = Cache::remember('phphub_sites', 60, function () {
            $raw_sites = self::orderBy('order', 'desc')->orderBy('created_at', 'desc')->get();
            $sorted = [];

            $sorted['portal'] = $raw_sites->filter(function ($item) {
                return $item->type == 'portal';
            });
            $sorted['discussão'] = $raw_sites->filter(function ($item) {
                return $item->type == 'discussão';
            });
            $sorted['canal'] = $raw_sites->filter(function ($item) {
                return $item->type == 'canal';
            });
            $sorted['blockchain'] = $raw_sites->filter(function ($item) {
                return $item->type == 'blockchain';
            });
            $sorted['site_foreign'] = $raw_sites->filter(function ($item) {
                return $item->type == 'site_foreign';
            });
            $sorted['other'] = $raw_sites->filter(function ($item) {
                return $item->type == 'other';
            });
            return $sorted;
        });
        return $data;
    }
}
