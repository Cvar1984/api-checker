<?php

require __DIR__ . '/vendor/autoload.php';

$client = new \GuzzleHttp\Client();

$api_list = file($argv[1], FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

foreach ($api_list as $api_key) {
  $response = $client->request('GET', 'https://www.virustotal.com/api/v3/users/' . $api_key . '/overall_quotas', [
    'headers' => [
      'accept' => 'application/json',
      'x-apikey' => $api_key,
    ],
  ]);

  $result = $response->getBody();
  $result = json_decode($result, true);

  $api_hourly_used = $result['data']['api_requests_hourly']['user']['used'];
  $api_hourly_max = $result['data']['api_requests_hourly']['user']['allowed'];
  $api_daily_used = $result['data']['api_requests_daily']['user']['used'];
  $api_daily_max = $result['data']['api_requests_daily']['user']['allowed'];
  $api_monthly_used = $result['data']['api_requests_monthly']['user']['used'];
  $api_monthly_max = $result['data']['api_requests_monthly']['user']['allowed'];

  printf('Api key: %s%s', $api_key, PHP_EOL);
  printf('Hourly Usage: %s/%s%s', $api_hourly_used, $api_hourly_max, PHP_EOL);
  printf('Daily Usage: %s/%s%s', $api_daily_used, $api_daily_max, PHP_EOL);
  printf('Monthly Usage: %s/%s%s', $api_monthly_used, $api_monthly_max, PHP_EOL);

  echo PHP_EOL;
}
