<?php

use Illuminate\Support\Str;

// 카카오톡 알림톡 발송 API
return [
    'key' => env('HELLO_MESSAGE_KEY', 'NCSC9TYHE59C2OJI'),
    'secret' => env('HELLO_MESSAGE_SECRET', 'DBSEA9CCDK3X1SLY7OVAXUS5RHJCJPOK'),
    'pf_id' => env('HELLO_MESSAGE_PF_ID', 'KA01PF220906075416189VE2ro53T2Fb'),
    'from' => env('HELLO_MESSAGE_FROM', '0803155233'),
];
