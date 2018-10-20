<?php namespace App\Http\Controllers\Traits;

use Auth;
use Socialite;
use Illuminate\Http\Request;
use App\Models\User;
use Flash;

trait SocialiteHelper
{
    protected $oauthDrivers = [
        'github' => 'github',
        'facebook' => 'facebook',
        'linkedin' => 'linkedin',
        'twitter' => 'twitter',
        'google' => 'google',
        'wechat' => 'weixin'
    ];

    public function oauth(Request $request)
    {
        $driver = $request->input('driver');
        $driver = !isset($this->oauthDrivers[$driver]) ? 'github' : $this->oauthDrivers[$driver];

        if (Auth::check() && Auth::user()->register_source == $driver) {
            return redirect('/');
        }

        return Socialite::driver($driver)->redirect();
    }

    public function getUserFromSocialite($driver)
    {
        if ($driver!=='twitter') {
            return Socialite::with($this->oauthDrivers[$driver])->stateless()->user();
        }
        return Socialite::with($this->oauthDrivers[$driver])
            ->userFromTokenAndSecret(
                getenv('TWITTER_CLIENT_ID'),
                getenv('TWITTER_CLIENT_SECRET')
            )->user();
    }

    public function callback(Request $request)
    {
        $driver = $request->input('driver');

        if (
            !isset($this->oauthDrivers[$driver])
            || (Auth::check() && Auth::user()->register_source == $driver)
        ) {
            return redirect()->intended('/');
        }

        $oauthUser = $this->getUserFromSocialite($driver);                                                                                                                                                                                                                                                                                                                                                                                                                                                         
        $user = User::getByDriver($driver, $oauthUser->id);
        
        if (Auth::check()) {
            if ($user && $user->id != Auth::id()) {
                Flash::error(lang('Sorry, this socialite account has been registed.', ['driver' => lang($driver)]));
            } else {
                $this->bindSocialiteUser($oauthUser, $driver);
                Flash::success(lang('Bind Successfully!', ['driver' => lang($driver)]));
            }

            return redirect(route('users.edit_social_binding', Auth::id()));
        }

        if ($user) {
            return $this->loginUser($user);
        }

        return $this->userNotFound($driver, $oauthUser);
    }

    public function bindSocialiteUser($oauthUser, $driver)
    {
        $currentUser = Auth::user();

        if ($driver == 'github') {
            $currentUser->github_id = $oauthUser->id;
            $currentUser->github_url = $oauthUser->user['url'];
        } elseif ($driver == 'linkedin') {
            $currentUser->linkedin_id = $oauthUser->id;
        } elseif ($driver == 'twitter') {
            $currentUser->twitter_id = $oauthUser->id;
        } elseif ($driver == 'google') {
            $currentUser->facebook_id = $oauthUser->id;
        } elseif ($driver == 'facebook') {
            $currentUser->facebook_id = $oauthUser->id;
        } elseif ($driver == 'wechat') {
            $currentUser->wechat_openid = $oauthUser->id;
            $currentUser->wechat_unionid = $oauthUser->user['unionid'];
        }

        $currentUser->save();
    }
}
