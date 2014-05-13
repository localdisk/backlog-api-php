backlog-api-php
===============
[Backlog](http://www.backlog.jp/) API の PHP Wrapper です。

### インストール

[Composer](http://getcomposer.org) を使用してインストールします

```bash
# Install Composer
curl -sS https://getcomposer.org/installer | php

# Add NHK API を require セクションに追加
php composer.phar require localdisk/backlog-api-php:dev-master
```

### 使い方

```php
require 'vendor/autoload.php';

// 第1引数はプロジェクトのURL
// 第2引数はユーザ名
// 第3引数はパスワードを指定してください
$api = new Backlog\Api('https://demo.backlog.jp', 'demo', 'demo');

// 結果は配列で返却されます
// 引数が不正等のエラーは例外が発生します
$res = $api->getProjects();
```