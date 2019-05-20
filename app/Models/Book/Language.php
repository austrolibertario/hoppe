<?php

namespace App\Models;

use Cmgmyr\Messenger\Models\Language as MessengerLanguage;

class Language extends MessengerLanguage
{
    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
