<?php

require __DIR__ . "/vendor/autoload.php";

$client = new Google\Client;

$client->setClientId("245230819719-r4qdbj8vsfll3d33pkfrm8f05qg7h6o8.apps.googleusercontent.com");
$client->setClientSecret("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");
$client->setRedirectUri("http://localhost/redirect.php");

if ( ! isset($_GET["code"])) {

    exit("Login failed");

}

$token = $client->fetchAccessTokenWithAuthCode($_GET["code"]);

$client->setAccessToken($token["access_token"]);

$oauth = new Google\Service\Oauth2($client);

$userinfo = $oauth->userinfo->get();

var_dump(
    $userinfo->email,
    $userinfo->familyName,
    $userinfo->givenName,
    $userinfo->name
);