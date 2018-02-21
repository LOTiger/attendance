<?php

namespace App\Http\Controllers\Api;

use App\Services\RsaService;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Laravel\Passport\Http\Controllers\PersonalAccessTokenController;

class LoginController extends PersonalAccessTokenController
{
    use AuthenticatesUsers,ValidatesRequests;

    /**
     * 登录
     * @param Request $request
     * @return array|\Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);
        $request = $this->decriptPassword($request);
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }
        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);
    }

    /**
     * 返回登录失败信息
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        return response(['status' => 401, 'message' => '认证失败']);
    }

    /**
     * 返回因多次登录而锁定账户信息
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    protected function sendLockoutResponse(Request $request)
    {
        $seconds = $this->limiter()->availableIn(
            $this->throttleKey($request)
        );
        $message = \Lang::get('auth.throttle', ['seconds' => $seconds]);
        return response($message, 401);
    }

    /**
     * 获取用户名
     * @return mixed
     */
    public function username()
    {
        return config('passport_login.username', 'email');
    }

    /**
     * 执行登录成功厚德操作
     * @param Request $request
     * @return array
     */
    protected function sendLoginResponse(Request $request)
    {
        $this->clearLoginAttempts($request);
        return $this->authenticated($request, $this->guard()->user());
    }

    /**
     * 认证成功
     * @param Request $request
     * @param $user
     * @return array
     */
    protected function authenticated(Request $request, $user)
    {
        return $this->getTokenResponse($request, $user);
    }

    /**
     * 执行密码认证
     * @param Request $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        return $this->guard()->once(
            $this->credentials($request)
        );
    }

    /**
     * 验证提交的数据
     * @param Request $request
     */
    protected function validateLogin(Request $request)
    {
        $rules = config('passport_login.rules', [
            $this->username() => 'required',
            'password' => 'required',
        ]);
        $this->validate($request, $rules);
    }

    /**
     * 登出
     * @param Request $request
     * @param $tokenId
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request, $tokenId)
    {
        return parent::destroy($request, $tokenId);
    }

    /**
     * 获取用户信息
     * @param Request $request
     * @return mixed
     */
    public function user(Request $request)
    {
        return $this->getUserResponse($request, $this->guard()->user());
    }

    /**
     * 返回用户信息
     * @param Request $request
     * @param $user
     * @return mixed
     */
    protected function getUserResponse(Request $request, $user) {
        return $user;
    }

    /**
     * 获取认证token与用户信息结合的信息
     * @param Request $request
     * @param $user
     * @return string
     */
    public function getTokenName(Request $request, $user)
    {
        return "User #{$user->id} - {$user->email} - {$request->ip()}";
    }

    /**
     * 返回认证成功所需要的token
     * @param Request $request
     * @param $user
     * @param array $scopes
     * @return array
     */
    protected function getTokenResponse(Request $request, $user, array $scopes = [])
    {
        $personalAccessTokenResult = $user->createToken($this->getTokenName($request, $user), $scopes);
        return [
            'status' => 200,
            'accessToken' => $personalAccessTokenResult->accessToken,
            'accessTokenId' => $personalAccessTokenResult->token->id
        ];
    }

    /**
     * 解密密码并合并到request中
     * @param Request $request
     * @return Request
     */
    protected function decriptPassword(Request $request)
    {
        $crypt = new RsaService();
        $crypt->select('rsa_api');
        $request->merge(['password'=>$crypt->decryptPrivate($request->input('password'))]);
        return $request;
    }


}
