<?php namespace App\Phphub\Presenters;

use Laracasts\Presenter\Presenter;
use App\Models\Site;

class SitePresenter extends Presenter
{
    public function linkWithUTMSource()
    {
        return linkWithUTMSource($this->link);
    }

    public function icon($size = 40)
    {
        if (!$this->favicon) {
            return cdn('assets/images/emoji/arrow_right.png');
        }

        $path = 'uploads/sites/' . $this->favicon;
        if (strpos($path, '.ico') === false) {
            return cdn($path)."?imageView2/1/w/{$size}/h/{$size}";
        } else {
            return cdn($path);
        }
    }
}
