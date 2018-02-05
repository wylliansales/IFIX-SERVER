<?php

namespace App\Http\Middleware;

use App\Repositories\UserRepository;
use Closure;

class AddScopes
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

        $scopes = "";
        if($user['0']->scopes)
        foreach ($user['0']->scopes as $key => $value){
            $scopes .=  "$key ";
        }

        $request->request->add([
            "scope" => $scopes
        ]);

        return $next($request);
    }
}
