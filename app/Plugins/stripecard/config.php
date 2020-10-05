<?php

return [

    'stripe' => [
        'model'  => App\Models\User::class,
        'key'    => config('app.stripe_key'),
        'secret' => config('app.stripe_secret'),
    ],

];
