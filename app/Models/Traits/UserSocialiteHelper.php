<?php namespace App\Models\Traits;

use App\Models\User;

trait UserSocialiteHelper
{
    public static function getByDriver($driver, $id)
    {
        $functionMap = [
            'github' => 'getByGithubId',
            'twitter' => 'getByTwitterId',
            'facebook' => 'getByFacebookId',
            'google' => 'getByGoogleId',
            'wechat' => 'getByWechatId',
            'linkedin' => 'getByLinkedinId',
        ];
        $function = $functionMap[$driver];
        if (!$function) {
            return null;
        }

        return self::$function($id);
    }

    public static function getByGithubId($id)
    {
        return User::where('github_id', '=', $id)->first();
    }

    public static function getByTwitterId($id)
    {
        return User::where('twitter_id', '=', $id)->first();
    }

    public static function getByFacebookId($id)
    {
        return User::where('facebook_id', '=', $id)->first();
    }

    public static function getByGoogleId($id)
    {
        return User::where('google_id', '=', $id)->first();
    }

    public static function getByWechatId($id)
    {
        return User::where('wechat_openid', '=', $id)->first();
    }

    public static function getByLinkedinId($id)
    {
        return User::where('linkedin_id', '=', $id)->first();
    }
}
