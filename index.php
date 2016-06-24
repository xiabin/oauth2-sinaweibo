<?php
/**
 * Created by PhpStorm.
 * User: xiabin
 * Date: 16/6/24
 * Time: 下午7:38
 */
require 'vendor/autoload.php';

use Xiabin\OAuth2\Client\Provider\SinaWeibo;
error_reporting(E_ALL & ~E_WARNING & ~E_STRICT & ~E_NOTICE);


$provider   =  new SinaWeibo(array(
    'clientId' => '220740538',
    'clientSecret' => 'a749660739087f430872b7039e64187c',
    'redirectUri' => 'http://oauth.pp.cn',
));
session_start();
$_SESSION['a'] = 1;
if (!isset($_GET['code'])) {

    // If we don't have an authorization code then get one
    $authUrl = $provider->getAuthorizationUrl();
    $_SESSION['oauth2state'] = $provider->getState();
    header('Location: '.$authUrl);
    exit;

// Check given state against previously stored one to mitigate CSRF attack
} else {


    // Optional: Now you have a token you can look up a users profile data
    try {

        // Try to get an access token (using the authorization code grant)
        $token = $provider->getAccessToken('authorization_code', [
            'code' => $_GET['code']
        ]);

        // Use these details to create a new profile
        var_dump($token);
    }catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e){
        exit($e->getResponseBody());
    }
    catch (Exception $e) {
        var_dump($e);
        // Failed to get user details
        exit('Oh dear...');
    }

    // Use this to interact with an API on the users behalf
    echo $token->getToken();
}
