<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request)
    {
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user(),
                'role' => $request->user() ? $request->user()->getRoleNames() : null, // can be removed in the future?
                'permissions' => $request->user() ? $request->user()->getAllPermissions()->pluck('name') : null,
                'modules_available' => $request->user() ? $request->user()->getModulesAvailable() : null
            ],
            'ziggy' => function () {
                return (new Ziggy)->toArray();
            },
        ]);
    }
}
