# sns-oauth
## oauth2.0 通过回调返回的code获取用户相关信息，支持平台：
* 微博
* 微信
* qq

## 安装
`php composer.phar require leo0o/sns-oauth`
**or**
`composer require leo0o/sns-oauth`

## 使用
```php
try {
    $wechat = new \oauth\OAuth("wechat", [
        'appKey'=>'你的appkey',
        'appSecret'=>'你的appsecret',
        'redirectUrl'=>'回调地址，必传']);
    
    var_dump($wechat->Authrize('回调带回的code'));
} catch (OAuthException $e) {
    var_dump(echo $e->getMessage());
}
```

#### 返回格式：
```php
[
    'nickname'      =>  '',   
    'openid'        =>  '',   
    'sex'           =>  '',   //0未知, 1男, 2女
    'headimgurl'    =>  '',
    'unionid'       =>  ''
]

```