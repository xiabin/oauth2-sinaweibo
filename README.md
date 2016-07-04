# SinaWeibo Provider for OAuth 2.0 Client

[![license](https://img.shields.io/github/license/xiabin/oauth2-sinaweibo.svg?maxAge=2592000)](https://github.com/xiabin/oauth2-sinaweibo/blob/master/LICENSE.md)
[![Packagist](https://img.shields.io/packagist/v/xiabin/oauth2-sinaweibo.svg?maxAge=2592000?style=plastic)](https://packagist.org/packages/xiabin/oauth2-sinaweibo)
[![Build Status](https://travis-ci.org/xiabin/oauth2-sinaweibo.svg?branch=master)](https://travis-ci.org/xiabin/oauth2-sinaweibo)
[![Coverage Status](https://scrutinizer-ci.com/g/xiabin/oauth2-sinaweibo/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/xiabin/oauth2-sinaweibo/code-structure)
[![Quality Score](https://scrutinizer-ci.com/g/thephpleague/oauth2-github/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/xiabin/oauth2-sinaweibo/)
[![Packagist](https://img.shields.io/packagist/dt/xiabin/oauth2-sinaweibo.svg?maxAge=2592000)](https://packagist.org/packages/xiabin/oauth2-sinaweibo)


 这个组件基于 PHP League's [OAuth 2.0 Client](https://github.com/thephpleague/oauth2-client).

## 安装

用composer安装:

```
composer require xiabin/oauth2-sinaweibo
```

## 用例


### 获取token

```php
$provider = new Xiabin\OAuth2\Client\Provider\SinaWeibo([
    'clientId'          => '{github-client-id}',
    'clientSecret'      => '{github-client-secret}',
    'redirectUri'       => 'https://example.com/callback-url',
]);

if (!isset($_GET['code'])) {

    //如果没有code就去获取
    $authUrl = $provider->getAuthorizationUrl();
    $_SESSION['oauth2state'] = $provider->getState();
    header('Location: '.$authUrl);
    exit;

  //判断state与之前使用的是否一致
} elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {

    unset($_SESSION['oauth2state']);
    exit('Invalid state');

} else {

    //获取accesstoken
    $token = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code']
    ]);

    ...
}
```

## 测试

``` bash
$ ./vendor/bin/phpunit
```



## License

The MIT License (MIT). Please see [License File](https://github.com/xiabin/oauth2-sinaweibo/blob/master/LICENSE.md  ) for more information.
