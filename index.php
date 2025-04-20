<?php

require __DIR__ . "/vendor/autoload.php";

$client = new Google\Client;

$client->setClientId("245230819719-r4qdbj8vsfll3d33pkfrm8f05qg7h6o8.apps.googleusercontent.com");
$client->setClientSecret("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");
$client->setRedirectUri("http://localhost/redirect.php");

$client->addScope("email");
$client->addScope("profile");

$url = $client->createAuthUrl();

?>
<!DOCTYPE html>
<html>
<head>
    <title>Google Login Example</title>
</head>
<body>

    <a href="<?= $url ?>">Sign in with Google</a>

</body>
</html>