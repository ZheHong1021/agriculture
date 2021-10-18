# 高科大農業環境資訊平台


從Github將 Laravel專案clone後如何重建
[參考連結](https://campus-xoops.tn.edu.tw/modules/tad_book3/page.php?tbsn=37&tbdsn=1255)

```cmd=
// 先確認自己有沒有載 git
git --version

// output: git version 2.24.0.windows.2 (這是我的的 git版本)
```

【載入專案】
```cmd=
git clone https://github.com/ZheHong1021/agriculture.git

cd agriculture // 移動到該目錄下

composer install // composer重建相關套件，此時會重建vendor目裡的內容

npm install // 還原 npm所載的套件，node_modules
```

<br>

【設定專案】
```cmd=
cp .env.example .env // 還原.env設定檔
php artisan key:generate // 產生器來產生APP KEY
```

<br>

【設定資料庫】
```php=
// .env
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:DBkCQrH+eS0x7t4QYltnBWe+RF82Dtp9LMRvrS0wdkM=   // 產生器產生的結果(每個都不一樣)
APP_DEBUG=true
APP_URL=http://agriculture.test

LOG_CHANNEL=stack
LOG_LEVEL=debug

DB_CONNECTION=sqlsrv  // 要使用的資料庫連線 (mysql、pgsql、sqlsrv)
DB_HOST=DESKTOP-95GTT1R\SQLEXPRESS // 伺服器名稱(sqlsrv)
DB_PORT=1433 // port(sqlsrv: 1433、 mysql: 3306)
DB_DATABASE=agriculture // 資料庫名稱
DB_USERNAME=sa // 使用者帳號
DB_PASSWORD=haha45La // 使用者密碼

```

<br>

```php=
// config/database.php
'default' => env('DB_CONNECTION', 'sqlsrv'),  // sqlsrv可以改成其他的(看使用哪個資料庫連線)


'sqlsrv' => [
    'driver' => 'sqlsrv',
    'url' => env('DATABASE_URL'),
    'host' => env('DB_HOST', 'DESKTOP-95GTT1R\SQLEXPRESS'),  // MS SQL的伺服器密碼
    'port' => env('DB_PORT', '1433'), // Port
    'database' => env('DB_DATABASE', 'agriculture'), // 資料庫名稱
    'username' => env('DB_USERNAME', 'sa'), // 使用者名稱
    'password' => env('DB_PASSWORD', 'haha45La'), // 使用者密碼
    'charset' => 'utf8',
    'prefix' => '',
    'prefix_indexes' => true,
],
```
