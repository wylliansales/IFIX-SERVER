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

        $request->request->add([
            "scope" => "manage-user"
        ]);

        return $next($request);
    }
}
