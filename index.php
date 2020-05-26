<?php
declare( strict_types = 1 );

use Hearts\App;

// If we have any composer dependencies, we should probably load them
require __DIR__ . '/vendor/autoload.php';

?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="public/style.css">
  <title>XoneFobic / Hearts</title>
</head>
<body>
<?php

try {
  $app = new App();
  $app->gameOn();
} catch (Exception $exception) {
  die( 'Well, that went wrong.' );
}

?>
</body>
</html>
