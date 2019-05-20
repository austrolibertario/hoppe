<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use App\Jobs\SendActivateMail;
use Carbon\Carbon;
use Cache;
use Nicolaslopezj\Searchable\SearchableTrait;
use Cmgmyr\Messenger\Traits\Messagable;

/**
 * Traits
 */
use Inani\Larapoll\Traits\Voter;
use Laracasts\Presenter\PresentableTrait;
use Venturecraft\Revisionable\RevisionableTrait;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
// use Illuminate\Foundation\Auth\User as Authenticatable;
// Podem Seguir
use Overtrue\LaravelFollow\Traits\CanFollow;
use Overtrue\LaravelFollow\Traits\CanLike;
use Overtrue\LaravelFollow\Traits\CanFavorite;
use Overtrue\LaravelFollow\Traits\CanSubscribe;
use Overtrue\LaravelFollow\Traits\CanVote;
use Overtrue\LaravelFollow\Traits\CanBookmark;
// Podem Serem Seguidos
use Overtrue\LaravelFollow\Traits\CanBeFollowed;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract
{
    use Traits\UserRememberTokenHelper;
    use Traits\UserSocialiteHelper;
    use Traits\UserAvatarHelper;
    use Traits\UserActivityHelper;

    use Messagable, HasApiTokens, Notifiable, PresentableTrait;
    use SearchableTrait;
    // use Voter;
    use CanFollow, CanLike, CanFavorite, CanSubscribe, CanVote, CanBookmark;
    use CanBeFollowed;

    // For admin log
    use RevisionableTrait;

    use EntrustUserTrait {
        restore as private restoreEntrust;
        EntrustUserTrait::can as may;
    }
    use SoftDeletes { restore as private restoreSoftDelete; }
    
    public $presenter = 'App\Phphub\Presenters\UserPresenter';

    protected $keepRevisionOf = [
        'is_banned'
    ];

    protected $dates = ['deleted_at'];

    protected $table   = 'users';
    protected $guarded = ['id', 'is_banned'];

    protected $searchable = [
        'columns' => [
            'users.name' => 10,
            'users.real_name' => 10,
            'users.introduction' => 10,
        ],
    ];
    
    public function getAuthIdentifierName()
    {
        return 'id';
    }

    public static function boot()
    {
        parent::boot();

        static::created(function ($user) {
            $driver = $user['github_id'] ? 'github' : 'wechat';
            SiteStatus::newUser($driver);

            dispatch(new SendActivateMail($user));
        });

        static::deleted(function ($user) {
            \Artisan::call('phphub:clear-user-data', ['user_id' => $user->id]);
        });
    }

    public function scopeIsRole($query, $role)
    {
        return $query->whereHas('roles', function ($query) use ($role) {
                $query->where('name', $role);
            }
        );
    }

    public function firstName()
    {
        $name = explode(' ', $this->name);
        return $name[0];
    }

    public static function byRolesName($name)
    {
        $data = Cache::remember('phphub_roles_'.$name, 60, function () use ($name) {
            return User::isRole($name)->orderBy('last_actived_at', 'desc')->get();
        });
        return $data;
    }

    public function managedBlogs()
    {
        return $this->belongsToMany(Blog::class, 'blog_managers');
    }

    /**
     * For EntrustUserTrait and SoftDeletes conflict
     */
    public function restore()
    {
        $this->restoreEntrust();
        $this->restoreSoftDelete();
    }

    public function votedTopics()
    {
        return $this->morphedByMany(Topic::class, 'votable', 'votes')->withPivot('created_at');
    }

    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function subscribes()
    {
        return $this->belongsToMany(Blog::class, 'blog_subscribers');
    }

    public function attentTopics()
    {
        return $this->belongsToMany(Topic::class, 'attentions')->withTimestamps();
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class)->recent()->with('topic', 'fromUser')->paginate(20);
    }

    public function revisions()
    {
        return $this->hasMany(Revision::class);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function getIntroductionAttribute($value)
    {
        return str_limit($value, 68);
    }

    public function getPersonalWebsiteAttribute($value)
    {
        return str_replace(['https://', 'http://'], '', $value);
    }

    public function isAttentedTopic(Topic $topic)
    {
        return Attention::isUserAttentedTopic($this, $topic);
    }

    public function subscribe(Blog $blog)
    {
        return $blog->subscribers()->where('user_id', $this->id)->count() > 0;
    }

    public function isAuthorOf($model)
    {
        return $this->id == $model->user_id;
    }

    /**
     * ----------------------------------------
     * UserInterface
     * ----------------------------------------
     */

    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function recordLastActivedAt()
    {
        $now = Carbon::now()->toDateTimeString();

        $update_key = config('phphub.actived_time_for_update');
        $update_data = Cache::get($update_key);
        $update_data[$this->id] = $now;
        Cache::forever($update_key, $update_data);

        $show_key = config('phphub.actived_time_data');
        $show_data = Cache::get($show_key);
        $show_data[$this->id] = $now;
        Cache::forever($show_key, $show_data);
    }
}
