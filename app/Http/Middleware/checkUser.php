<?php

namespace App\Http\Middleware;

use App\Repositories\UserRepository;
use Closure;

class checkUser
{

    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = $this->userRepository->findWhere(['email'=>$request->username]);

        if($user['0']->activated){
            return $next($request);
        }

        return false;
    }
}
