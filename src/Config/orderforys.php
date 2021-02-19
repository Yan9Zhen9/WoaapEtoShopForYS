<?php
switch (env('APP_ENV')) {
    case 'production':
        $ys_domain = 'https://zhls.qq.com/';
        break;
    default:
        $ys_domain = 'https://test.zhls.qq.com/';
        break;
}
return [
    'ys_domain' => $ys_domain,

    'app_id' => env('YS_APP_ID'),
    'app_secret' => env('YS_APP_SECRET'),
];
