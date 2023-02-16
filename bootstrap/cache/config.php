<?php return array (
  'app' => 
  array (
    'name' => 'Laravel',
    'env' => 'local',
    'debug' => true,
    'url' => 'http://localhost:8000',
    'asset_url' => NULL,
    'timezone' => 'UTC',
    'locale' => 'fa',
    'fallback_locale' => 'en',
    'faker_locale' => 'en_US',
    'key' => 'base64:8NVRZDxFw/HRxKJLHBlzweiJAley6SCNWjrlKzn+KRk=',
    'cipher' => 'AES-256-CBC',
    'maintenance' => 
    array (
      'driver' => 'file',
    ),
    'providers' => 
    array (
      0 => 'Illuminate\\Auth\\AuthServiceProvider',
      1 => 'Illuminate\\Broadcasting\\BroadcastServiceProvider',
      2 => 'Illuminate\\Bus\\BusServiceProvider',
      3 => 'Illuminate\\Cache\\CacheServiceProvider',
      4 => 'Illuminate\\Foundation\\Providers\\ConsoleSupportServiceProvider',
      5 => 'Illuminate\\Cookie\\CookieServiceProvider',
      6 => 'Illuminate\\Database\\DatabaseServiceProvider',
      7 => 'Illuminate\\Encryption\\EncryptionServiceProvider',
      8 => 'Illuminate\\Filesystem\\FilesystemServiceProvider',
      9 => 'Illuminate\\Foundation\\Providers\\FoundationServiceProvider',
      10 => 'Illuminate\\Hashing\\HashServiceProvider',
      11 => 'Illuminate\\Mail\\MailServiceProvider',
      12 => 'Illuminate\\Notifications\\NotificationServiceProvider',
      13 => 'Illuminate\\Pagination\\PaginationServiceProvider',
      14 => 'Illuminate\\Pipeline\\PipelineServiceProvider',
      15 => 'Illuminate\\Queue\\QueueServiceProvider',
      16 => 'Illuminate\\Redis\\RedisServiceProvider',
      17 => 'Illuminate\\Auth\\Passwords\\PasswordResetServiceProvider',
      18 => 'Illuminate\\Session\\SessionServiceProvider',
      19 => 'Illuminate\\Translation\\TranslationServiceProvider',
      20 => 'Illuminate\\Validation\\ValidationServiceProvider',
      21 => 'Illuminate\\View\\ViewServiceProvider',
      22 => 'App\\Providers\\AppServiceProvider',
      23 => 'App\\Providers\\AuthServiceProvider',
      24 => 'App\\Providers\\EventServiceProvider',
      25 => 'App\\Providers\\RouteServiceProvider',
    ),
    'aliases' => 
    array (
      'App' => 'Illuminate\\Support\\Facades\\App',
      'Arr' => 'Illuminate\\Support\\Arr',
      'Artisan' => 'Illuminate\\Support\\Facades\\Artisan',
      'Auth' => 'Illuminate\\Support\\Facades\\Auth',
      'Blade' => 'Illuminate\\Support\\Facades\\Blade',
      'Broadcast' => 'Illuminate\\Support\\Facades\\Broadcast',
      'Bus' => 'Illuminate\\Support\\Facades\\Bus',
      'Cache' => 'Illuminate\\Support\\Facades\\Cache',
      'Config' => 'Illuminate\\Support\\Facades\\Config',
      'Cookie' => 'Illuminate\\Support\\Facades\\Cookie',
      'Crypt' => 'Illuminate\\Support\\Facades\\Crypt',
      'Date' => 'Illuminate\\Support\\Facades\\Date',
      'DB' => 'Illuminate\\Support\\Facades\\DB',
      'Eloquent' => 'Illuminate\\Database\\Eloquent\\Model',
      'Event' => 'Illuminate\\Support\\Facades\\Event',
      'File' => 'Illuminate\\Support\\Facades\\File',
      'Gate' => 'Illuminate\\Support\\Facades\\Gate',
      'Hash' => 'Illuminate\\Support\\Facades\\Hash',
      'Http' => 'Illuminate\\Support\\Facades\\Http',
      'Js' => 'Illuminate\\Support\\Js',
      'Lang' => 'Illuminate\\Support\\Facades\\Lang',
      'Log' => 'Illuminate\\Support\\Facades\\Log',
      'Mail' => 'Illuminate\\Support\\Facades\\Mail',
      'Notification' => 'Illuminate\\Support\\Facades\\Notification',
      'Password' => 'Illuminate\\Support\\Facades\\Password',
      'Queue' => 'Illuminate\\Support\\Facades\\Queue',
      'RateLimiter' => 'Illuminate\\Support\\Facades\\RateLimiter',
      'Redirect' => 'Illuminate\\Support\\Facades\\Redirect',
      'Request' => 'Illuminate\\Support\\Facades\\Request',
      'Response' => 'Illuminate\\Support\\Facades\\Response',
      'Route' => 'Illuminate\\Support\\Facades\\Route',
      'Schema' => 'Illuminate\\Support\\Facades\\Schema',
      'Session' => 'Illuminate\\Support\\Facades\\Session',
      'Storage' => 'Illuminate\\Support\\Facades\\Storage',
      'Str' => 'Illuminate\\Support\\Str',
      'URL' => 'Illuminate\\Support\\Facades\\URL',
      'Validator' => 'Illuminate\\Support\\Facades\\Validator',
      'View' => 'Illuminate\\Support\\Facades\\View',
      'Vite' => 'Illuminate\\Support\\Facades\\Vite',
    ),
  ),
  'auth' => 
  array (
    'defaults' => 
    array (
      'guard' => 'web',
      'passwords' => 'users',
    ),
    'guards' => 
    array (
      'web' => 
      array (
        'driver' => 'session',
        'provider' => 'users',
      ),
      'sanctum' => 
      array (
        'driver' => 'sanctum',
        'provider' => NULL,
      ),
    ),
    'providers' => 
    array (
      'users' => 
      array (
        'driver' => 'eloquent',
        'model' => 'App\\Models\\User',
      ),
    ),
    'passwords' => 
    array (
      'users' => 
      array (
        'provider' => 'users',
        'table' => 'password_resets',
        'expire' => 60,
        'throttle' => 60,
      ),
    ),
    'password_timeout' => 10800,
  ),
  'broadcasting' => 
  array (
    'default' => 'log',
    'connections' => 
    array (
      'pusher' => 
      array (
        'driver' => 'pusher',
        'key' => '',
        'secret' => '',
        'app_id' => '',
        'options' => 
        array (
          'host' => 'api-mt1.pusher.com',
          'port' => '443',
          'scheme' => 'https',
          'encrypted' => true,
          'useTLS' => true,
        ),
        'client_options' => 
        array (
        ),
      ),
      'ably' => 
      array (
        'driver' => 'ably',
        'key' => NULL,
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'default',
      ),
      'log' => 
      array (
        'driver' => 'log',
      ),
      'null' => 
      array (
        'driver' => 'null',
      ),
    ),
  ),
  'cache' => 
  array (
    'default' => 'file',
    'stores' => 
    array (
      'apc' => 
      array (
        'driver' => 'apc',
      ),
      'array' => 
      array (
        'driver' => 'array',
        'serialize' => false,
      ),
      'database' => 
      array (
        'driver' => 'database',
        'table' => 'cache',
        'connection' => NULL,
        'lock_connection' => NULL,
      ),
      'file' => 
      array (
        'driver' => 'file',
        'path' => 'C:\\Users\\Matin\\bimaryar\\storage\\framework/cache/data',
      ),
      'memcached' => 
      array (
        'driver' => 'memcached',
        'persistent_id' => NULL,
        'sasl' => 
        array (
          0 => NULL,
          1 => NULL,
        ),
        'options' => 
        array (
        ),
        'servers' => 
        array (
          0 => 
          array (
            'host' => '127.0.0.1',
            'port' => 11211,
            'weight' => 100,
          ),
        ),
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'cache',
        'lock_connection' => 'default',
      ),
      'dynamodb' => 
      array (
        'driver' => 'dynamodb',
        'key' => '',
        'secret' => '',
        'region' => 'us-east-1',
        'table' => 'cache',
        'endpoint' => NULL,
      ),
      'octane' => 
      array (
        'driver' => 'octane',
      ),
    ),
    'prefix' => 'laravel_cache_',
  ),
  'cors' => 
  array (
    'paths' => 
    array (
      0 => 'api/*',
      1 => 'sanctum/csrf-cookie',
    ),
    'allowed_methods' => 
    array (
      0 => '*',
    ),
    'allowed_origins' => 
    array (
      0 => '*',
    ),
    'allowed_origins_patterns' => 
    array (
    ),
    'allowed_headers' => 
    array (
      0 => '*',
    ),
    'exposed_headers' => 
    array (
    ),
    'max_age' => 0,
    'supports_credentials' => false,
  ),
  'database' => 
  array (
    'default' => 'mysql',
    'connections' => 
    array (
      'sqlite' => 
      array (
        'driver' => 'sqlite',
        'url' => NULL,
        'database' => 'laravel',
        'prefix' => '',
        'foreign_key_constraints' => true,
      ),
      'mysql' => 
      array (
        'driver' => 'mysql',
        'url' => NULL,
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'laravel',
        'username' => 'root',
        'password' => '',
        'unix_socket' => '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_general_ci',
        'prefix' => '',
        'prefix_indexes' => true,
        'sticky' => true,
        'strict' => true,
        'engine' => 'InnoDB',
        'options' => 
        array (
        ),
      ),
      'pgsql' => 
      array (
        'driver' => 'pgsql',
        'url' => NULL,
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'laravel',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
        'prefix' => '',
        'prefix_indexes' => true,
        'search_path' => 'public',
        'sslmode' => 'prefer',
      ),
      'sqlsrv' => 
      array (
        'driver' => 'sqlsrv',
        'url' => NULL,
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'laravel',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
        'prefix' => '',
        'prefix_indexes' => true,
      ),
    ),
    'migrations' => 'migrations',
    'redis' => 
    array (
      'client' => 'phpredis',
      'options' => 
      array (
        'cluster' => 'redis',
        'prefix' => 'laravel_database_',
      ),
      'default' => 
      array (
        'url' => NULL,
        'host' => '127.0.0.1',
        'username' => NULL,
        'password' => NULL,
        'port' => '6379',
        'database' => '0',
      ),
      'cache' => 
      array (
        'url' => NULL,
        'host' => '127.0.0.1',
        'username' => NULL,
        'password' => NULL,
        'port' => '6379',
        'database' => '1',
      ),
    ),
  ),
  'filesystems' => 
  array (
    'default' => 'public',
    'disks' => 
    array (
      'local' => 
      array (
        'driver' => 'local',
        'root' => 'C:\\Users\\Matin\\bimaryar\\storage\\app',
        'throw' => false,
      ),
      'public' => 
      array (
        'driver' => 'local',
        'root' => 'C:\\Users\\Matin\\bimaryar\\storage\\app/public',
        'url' => 'http://localhost:8000/storage',
        'visibility' => 'public',
        'throw' => false,
      ),
      's3' => 
      array (
        'driver' => 's3',
        'key' => '',
        'secret' => '',
        'region' => 'us-east-1',
        'bucket' => '',
        'url' => NULL,
        'endpoint' => NULL,
        'use_path_style_endpoint' => false,
        'throw' => false,
      ),
    ),
    'links' => 
    array (
      'C:\\Users\\Matin\\bimaryar\\public\\storage' => 'C:\\Users\\Matin\\bimaryar\\storage\\app/public',
    ),
  ),
  'hashing' => 
  array (
    'driver' => 'bcrypt',
    'bcrypt' => 
    array (
      'rounds' => 10,
    ),
    'argon' => 
    array (
      'memory' => 65536,
      'threads' => 1,
      'time' => 4,
    ),
  ),
  'logging' => 
  array (
    'default' => 'stack',
    'deprecations' => 
    array (
      'channel' => NULL,
      'trace' => false,
    ),
    'channels' => 
    array (
      'stack' => 
      array (
        'driver' => 'stack',
        'channels' => 
        array (
          0 => 'single',
        ),
        'ignore_exceptions' => false,
      ),
      'single' => 
      array (
        'driver' => 'single',
        'path' => 'C:\\Users\\Matin\\bimaryar\\storage\\logs/laravel.log',
        'level' => 'debug',
      ),
      'daily' => 
      array (
        'driver' => 'daily',
        'path' => 'C:\\Users\\Matin\\bimaryar\\storage\\logs/laravel.log',
        'level' => 'debug',
        'days' => 14,
      ),
      'slack' => 
      array (
        'driver' => 'slack',
        'url' => NULL,
        'username' => 'Laravel Log',
        'emoji' => ':boom:',
        'level' => 'debug',
      ),
      'papertrail' => 
      array (
        'driver' => 'monolog',
        'level' => 'debug',
        'handler' => 'Monolog\\Handler\\SyslogUdpHandler',
        'handler_with' => 
        array (
          'host' => NULL,
          'port' => NULL,
          'connectionString' => 'tls://:',
        ),
      ),
      'stderr' => 
      array (
        'driver' => 'monolog',
        'level' => 'debug',
        'handler' => 'Monolog\\Handler\\StreamHandler',
        'formatter' => NULL,
        'with' => 
        array (
          'stream' => 'php://stderr',
        ),
      ),
      'syslog' => 
      array (
        'driver' => 'syslog',
        'level' => 'debug',
      ),
      'errorlog' => 
      array (
        'driver' => 'errorlog',
        'level' => 'debug',
      ),
      'null' => 
      array (
        'driver' => 'monolog',
        'handler' => 'Monolog\\Handler\\NullHandler',
      ),
      'emergency' => 
      array (
        'path' => 'C:\\Users\\Matin\\bimaryar\\storage\\logs/laravel.log',
      ),
    ),
  ),
  'mail' => 
  array (
    'default' => 'smtp',
    'mailers' => 
    array (
      'smtp' => 
      array (
        'transport' => 'smtp',
        'host' => 'mailhog',
        'port' => '1025',
        'encryption' => NULL,
        'username' => NULL,
        'password' => NULL,
        'timeout' => NULL,
        'local_domain' => NULL,
      ),
      'ses' => 
      array (
        'transport' => 'ses',
      ),
      'mailgun' => 
      array (
        'transport' => 'mailgun',
      ),
      'postmark' => 
      array (
        'transport' => 'postmark',
      ),
      'sendmail' => 
      array (
        'transport' => 'sendmail',
        'path' => '/usr/sbin/sendmail -bs -i',
      ),
      'log' => 
      array (
        'transport' => 'log',
        'channel' => NULL,
      ),
      'array' => 
      array (
        'transport' => 'array',
      ),
      'failover' => 
      array (
        'transport' => 'failover',
        'mailers' => 
        array (
          0 => 'smtp',
          1 => 'log',
        ),
      ),
    ),
    'from' => 
    array (
      'address' => 'hello@example.com',
      'name' => 'Laravel',
    ),
    'markdown' => 
    array (
      'theme' => 'default',
      'paths' => 
      array (
        0 => 'C:\\Users\\Matin\\bimaryar\\resources\\views/vendor/mail',
      ),
    ),
  ),
  'payment' => 
  array (
    'default' => 'zarinpal',
    'drivers' => 
    array (
      'local' => 
      array (
        'callbackUrl' => '/callback',
        'title' => 'درگاه پرداخت تست',
        'description' => 'این درگاه *صرفا* برای تست صحت روند پرداخت و لغو پرداخت میباشد',
        'orderLabel' => 'شماره سفارش',
        'amountLabel' => 'مبلغ قابل پرداخت',
        'payButton' => 'پرداخت موفق',
        'cancelButton' => 'پرداخت ناموفق',
      ),
      'fanavacard' => 
      array (
        'baseUri' => 'https://fcp.shaparak.ir',
        'apiPaymentUrl' => '_ipgw_//payment/',
        'apiPurchaseUrl' => 'ref-payment/RestServices/mts/generateTokenWithNoSign/',
        'apiVerificationUrl' => 'ref-payment/RestServices/mts/verifyMerchantTrans/',
        'apiReverseAmountUrl' => 'ref-payment/RestServices/mts/reverseMerchantTrans/',
        'username' => 'xxxxxxx',
        'password' => 'xxxxxxx',
        'callbackUrl' => 'http://yoursite.com/path/to',
      ),
      'atipay' => 
      array (
        'atipayTokenUrl' => 'https://mipg.atipay.net/v1/get-token',
        'atipayRedirectGatewayUrl' => 'https://mipg.atipay.net/v1/redirect-to-gateway',
        'atipayVerifyUrl' => 'https://mipg.atipay.net/v1/verify-payment',
        'apikey' => '',
        'currency' => 'R',
        'callbackUrl' => 'http://yoursite.com/path/to',
        'description' => 'payment using Atipay',
      ),
      'asanpardakht' => 
      array (
        'apiPaymentUrl' => 'https://asan.shaparak.ir',
        'apiRestPaymentUrl' => 'https://ipgrest.asanpardakht.ir/v1/',
        'username' => '',
        'password' => '',
        'merchantConfigID' => '',
        'callbackUrl' => 'http://yoursite.com/path/to',
        'description' => 'payment using asanpardakht',
      ),
      'behpardakht' => 
      array (
        'apiPurchaseUrl' => 'https://bpm.shaparak.ir/pgwchannel/services/pgw?wsdl',
        'apiPaymentUrl' => 'https://bpm.shaparak.ir/pgwchannel/startpay.mellat',
        'apiVerificationUrl' => 'https://bpm.shaparak.ir/pgwchannel/services/pgw?wsdl',
        'terminalId' => '',
        'username' => '',
        'password' => '',
        'callbackUrl' => 'http://yoursite.com/path/to',
        'description' => 'payment using behpardakht',
      ),
      'digipay' => 
      array (
        'apiOauthUrl' => 'https://api.mydigipay.com/digipay/api/oauth/token',
        'apiPurchaseUrl' => 'https://api.mydigipay.com/digipay/api/businesses/ticket?type=0',
        'apiPaymentUrl' => 'https://api.mydigipay.com/digipay/api/purchases/ipg/pay/',
        'apiVerificationUrl' => 'https://api.mydigipay.com/digipay/api/purchases/verify/',
        'username' => 'username',
        'password' => 'password',
        'client_id' => '',
        'client_secret' => '',
        'callbackUrl' => 'http://yoursite.com/path/to',
      ),
      'etebarino' => 
      array (
        'apiPurchaseUrl' => 'https://api.etebarino.com/public/merchant/request-payment',
        'apiPaymentUrl' => 'https://panel.etebarino.com/gateway/public/ipg',
        'apiVerificationUrl' => 'https://api.etebarino.com/public/merchant/verify-payment',
        'merchantId' => '',
        'terminalId' => '',
        'username' => '',
        'password' => '',
        'callbackUrl' => 'http://yoursite.com/path/to',
        'description' => 'payment using etebarino',
      ),
      'idpay' => 
      array (
        'apiPurchaseUrl' => 'https://api.idpay.ir/v1.1/payment',
        'apiPaymentUrl' => 'https://idpay.ir/p/ws/',
        'apiSandboxPaymentUrl' => 'https://idpay.ir/p/ws-sandbox/',
        'apiVerificationUrl' => 'https://api.idpay.ir/v1.1/payment/verify',
        'merchantId' => '',
        'callbackUrl' => 'http://yoursite.com/path/to',
        'description' => 'payment using idpay',
        'sandbox' => false,
      ),
      'irankish' => 
      array (
        'apiPurchaseUrl' => 'https://ikc.shaparak.ir/XToken/Tokens.xml',
        'apiPaymentUrl' => 'https://ikc.shaparak.ir/TPayment/Payment/index/',
        'apiVerificationUrl' => 'https://ikc.shaparak.ir/XVerify/Verify.xml',
        'merchantId' => '',
        'sha1Key' => '',
        'callbackUrl' => 'http://yoursite.com/path/to',
        'description' => 'payment using irankish',
      ),
      'nextpay' => 
      array (
        'apiPurchaseUrl' => 'https://nextpay.org/nx/gateway/token',
        'apiPaymentUrl' => 'https://nextpay.org/nx/gateway/payment/',
        'apiVerificationUrl' => 'https://nextpay.org/nx/gateway/verify',
        'merchantId' => '',
        'callbackUrl' => 'http://yoursite.com/path/to',
        'description' => 'payment using nextpay',
      ),
      'parsian' => 
      array (
        'apiPurchaseUrl' => 'https://pec.shaparak.ir/NewIPGServices/Sale/SaleService.asmx?wsdl',
        'apiPaymentUrl' => 'https://pec.shaparak.ir/NewIPG/',
        'apiVerificationUrl' => 'https://pec.shaparak.ir/NewIPGServices/Confirm/ConfirmService.asmx?wsdl',
        'merchantId' => '',
        'callbackUrl' => 'http://yoursite.com/path/to',
        'description' => 'payment using parsian',
      ),
      'pasargad' => 
      array (
        'apiPaymentUrl' => 'https://pep.shaparak.ir/payment.aspx',
        'apiGetToken' => 'https://pep.shaparak.ir/Api/v1/Payment/GetToken',
        'apiCheckTransactionUrl' => 'https://pep.shaparak.ir/Api/v1/Payment/CheckTransactionResult',
        'apiVerificationUrl' => 'https://pep.shaparak.ir/Api/v1/Payment/VerifyPayment',
        'merchantId' => '',
        'terminalCode' => '',
        'certificate' => '',
        'certificateType' => 'xml_file',
        'callbackUrl' => 'http://yoursite.com/path/to',
      ),
      'payir' => 
      array (
        'apiPurchaseUrl' => 'https://pay.ir/pg/send',
        'apiPaymentUrl' => 'https://pay.ir/pg/',
        'apiVerificationUrl' => 'https://pay.ir/pg/verify',
        'merchantId' => 'test',
        'callbackUrl' => 'http://yoursite.com/path/to',
        'description' => 'payment using payir',
      ),
      'paypal' => 
      array (
        'apiPurchaseUrl' => 'https://www.paypal.com/cgi-bin/webscr',
        'apiPaymentUrl' => 'https://www.zarinpal.com/pg/StartPay/',
        'apiVerificationUrl' => 'https://ir.zarinpal.com/pg/services/WebGate/wsdl',
        'sandboxApiPurchaseUrl' => 'https://www.sandbox.paypal.com/cgi-bin/webscr',
        'sandboxApiPaymentUrl' => 'https://sandbox.zarinpal.com/pg/StartPay/',
        'sandboxApiVerificationUrl' => 'https://sandbox.zarinpal.com/pg/services/WebGate/wsdl',
        'mode' => 'normal',
        'currency' => '',
        'id' => '',
        'callbackUrl' => 'http://yoursite.com/path/to',
        'description' => 'payment using paypal',
      ),
      'payping' => 
      array (
        'apiPurchaseUrl' => 'https://api.payping.ir/v2/pay/',
        'apiPaymentUrl' => 'https://api.payping.ir/v2/pay/gotoipg/',
        'apiVerificationUrl' => 'https://api.payping.ir/v2/pay/verify/',
        'merchantId' => '',
        'callbackUrl' => 'http://yoursite.com/path/to',
        'description' => 'payment using payping',
      ),
      'paystar' => 
      array (
        'apiPurchaseUrl' => 'https://core.paystar.ir/api/pardakht/create/',
        'apiPaymentUrl' => 'https://core.paystar.ir/api/pardakht/payment/',
        'apiVerificationUrl' => 'https://core.paystar.ir/api/pardakht/verify/',
        'gatewayId' => '',
        'signKey' => '',
        'callbackUrl' => 'http://yoursite.com/path/to',
        'description' => 'payment using paystar',
      ),
      'poolam' => 
      array (
        'apiPurchaseUrl' => 'https://poolam.ir/invoice/request/',
        'apiPaymentUrl' => 'https://poolam.ir/invoice/pay/',
        'apiVerificationUrl' => 'https://poolam.ir/invoice/check/',
        'merchantId' => '',
        'callbackUrl' => 'http://yoursite.com/path/to',
        'description' => 'payment using poolam',
      ),
      'sadad' => 
      array (
        'apiPaymentByIdentityUrl' => 'https://sadad.shaparak.ir/api/v0/PaymentByIdentity/PaymentRequest',
        'apiPaymentUrl' => 'https://sadad.shaparak.ir/api/v0/Request/PaymentRequest',
        'apiPurchaseByIdentityUrl' => 'https://sadad.shaparak.ir/vpg/api/v0/Request/PaymentRequest',
        'apiPurchaseUrl' => 'https://sadad.shaparak.ir/Purchase',
        'apiVerificationUrl' => 'https://sadad.shaparak.ir/VPG/api/v0/Advice/Verify',
        'key' => '',
        'merchantId' => '',
        'terminalId' => '',
        'callbackUrl' => '',
        'mode' => 'normal',
        'PaymentIdentity' => '',
        'description' => 'payment using sadad',
      ),
      'saman' => 
      array (
        'apiPurchaseUrl' => 'https://sep.shaparak.ir/Payments/InitPayment.asmx?WSDL',
        'apiPaymentUrl' => 'https://sep.shaparak.ir/payment.aspx',
        'apiVerificationUrl' => 'https://sep.shaparak.ir/payments/referencepayment.asmx?WSDL',
        'merchantId' => '',
        'callbackUrl' => '',
        'description' => 'payment using saman',
      ),
      'sep' => 
      array (
        'apiGetToken' => 'https://sep.shaparak.ir/onlinepg/onlinepg',
        'apiPaymentUrl' => 'https://sep.shaparak.ir/OnlinePG/OnlinePG',
        'apiVerificationUrl' => 'https://sep.shaparak.ir/verifyTxnRandomSessionkey/ipg/VerifyTransaction',
        'terminalId' => '',
        'callbackUrl' => '',
        'description' => 'Saman Electronic Payment for Saderat & Keshavarzi',
      ),
      'sepehr' => 
      array (
        'apiGetToken' => 'https://mabna.shaparak.ir:8081/V1/PeymentApi/GetToken',
        'apiPaymentUrl' => 'https://mabna.shaparak.ir:8080/pay',
        'apiVerificationUrl' => 'https://mabna.shaparak.ir:8081/V1/PeymentApi/Advice',
        'terminalId' => '',
        'callbackUrl' => '',
        'description' => 'payment using sepehr(saderat)',
      ),
      'walleta' => 
      array (
        'apiPurchaseUrl' => 'https://cpg.walleta.ir/payment/request.json',
        'apiPaymentUrl' => 'https://cpg.walleta.ir/ticket/',
        'apiVerificationUrl' => 'https://cpg.walleta.ir/payment/verify.json',
        'merchantId' => '',
        'callbackUrl' => 'http://yoursite.com/path/to',
        'description' => 'payment using walleta',
      ),
      'yekpay' => 
      array (
        'apiPurchaseUrl' => 'https://gate.yekpay.com/api/payment/server?wsdl',
        'apiPaymentUrl' => 'https://gate.yekpay.com/api/payment/start/',
        'apiVerificationUrl' => 'https://gate.yekpay.com/api/payment/server?wsdl',
        'fromCurrencyCode' => 978,
        'toCurrencyCode' => 364,
        'merchantId' => '',
        'callbackUrl' => 'http://yoursite.com/path/to',
        'description' => 'payment using yekpay',
      ),
      'zarinpal' => 
      array (
        'apiPurchaseUrl' => 'https://api.zarinpal.com/pg/v4/payment/request.json',
        'apiPaymentUrl' => 'https://www.zarinpal.com/pg/StartPay/',
        'apiVerificationUrl' => 'https://api.zarinpal.com/pg/v4/payment/verify.json',
        'sandboxApiPurchaseUrl' => 'https://sandbox.zarinpal.com/pg/services/WebGate/wsdl',
        'sandboxApiPaymentUrl' => 'https://sandbox.zarinpal.com/pg/StartPay/',
        'sandboxApiVerificationUrl' => 'https://sandbox.zarinpal.com/pg/services/WebGate/wsdl',
        'zaringateApiPurchaseUrl' => 'https://ir.zarinpal.com/pg/services/WebGate/wsdl',
        'zaringateApiPaymentUrl' => 'https://www.zarinpal.com/pg/StartPay/:authority/ZarinGate',
        'zaringateApiVerificationUrl' => 'https://ir.zarinpal.com/pg/services/WebGate/wsdl',
        'mode' => 'sandbox',
        'merchantId' => 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
        'callbackUrl' => 'http://yoursite.com/path/to',
        'description' => 'payment using zarinpal',
      ),
      'zibal' => 
      array (
        'apiPurchaseUrl' => 'https://gateway.zibal.ir/v1/request',
        'apiPaymentUrl' => 'https://gateway.zibal.ir/start/',
        'apiVerificationUrl' => 'https://gateway.zibal.ir/v1/verify',
        'mode' => 'normal',
        'merchantId' => '',
        'callbackUrl' => 'http://yoursite.com/path/to',
        'description' => 'payment using zibal',
      ),
      'sepordeh' => 
      array (
        'apiPurchaseUrl' => 'https://sepordeh.com/merchant/invoices/add',
        'apiPaymentUrl' => 'https://sepordeh.com/merchant/invoices/pay/id:',
        'apiDirectPaymentUrl' => 'https://sepordeh.com/merchant/invoices/pay/automatic:true/id:',
        'apiVerificationUrl' => 'https://sepordeh.com/merchant/invoices/verify',
        'mode' => 'normal',
        'merchantId' => '',
        'callbackUrl' => 'http://yoursite.com/path/to',
        'description' => 'payment using sepordeh',
      ),
      'rayanpay' => 
      array (
        'apiPurchaseUrl' => 'https://bpm.shaparak.ir/pgwchannel/startpay.mellat',
        'apiTokenUrl' => 'https://pms.rayanpay.com/api/v1/auth/token/generate',
        'apiPayStart' => 'https://pms.rayanpay.com/api/v1/ipg/payment/start',
        'apiPayVerify' => 'https://pms.rayanpay.com/api/v1/ipg/payment/response/parse',
        'username' => '',
        'client_id' => '',
        'password' => '',
        'callbackUrl' => '',
      ),
      'sizpay' => 
      array (
        'apiPurchaseUrl' => 'https://rt.sizpay.ir/KimiaIPGRouteService.asmx?WSDL',
        'apiPaymentUrl' => 'https://rt.sizpay.ir/Route/Payment',
        'apiVerificationUrl' => 'https://rt.sizpay.ir/KimiaIPGRouteService.asmx?WSDL',
        'merchantId' => '',
        'terminal' => '',
        'username' => '',
        'password' => '',
        'SignData' => '',
        'callbackUrl' => '',
      ),
      'vandar' => 
      array (
        'apiPurchaseUrl' => 'https://ipg.vandar.io/api/v3/send',
        'apiPaymentUrl' => 'https://ipg.vandar.io/v3/',
        'apiVerificationUrl' => 'https://ipg.vandar.io/api/v3/verify',
        'callbackUrl' => '',
        'merchantId' => '',
        'description' => 'payment using Vandar',
      ),
      'aqayepardakht' => 
      array (
        'apiPurchaseUrl' => 'https://panel.aqayepardakht.ir/api/v2/create',
        'apiPaymentUrl' => 'https://panel.aqayepardakht.ir/startpay/',
        'apiPaymentUrlSandbox' => 'https://panel.aqayepardakht.ir/startpay/sandbox/',
        'apiVerificationUrl' => 'https://panel.aqayepardakht.ir/api/v2/verify',
        'mode' => 'normal',
        'callbackUrl' => '',
        'pin' => '',
        'invoice_id' => '',
        'mobile' => '',
        'email' => '',
        'description' => 'payment using Aqayepardakht',
      ),
      'azki' => 
      array (
        'apiPaymentUrl' => 'https://api.azkiloan.com',
        'callbackUrl' => 'http://yoursite.com/path/to',
        'fallbackUrl' => 'http://yoursite.com/path/to',
        'merchantId' => '',
        'key' => '',
        'description' => 'payment using azki',
      ),
    ),
    'map' => 
    array (
      'local' => 'Shetabit\\Multipay\\Drivers\\Local\\Local',
      'fanavacard' => 'Shetabit\\Multipay\\Drivers\\Fanavacard\\Fanavacard',
      'asanpardakht' => 'Shetabit\\Multipay\\Drivers\\Asanpardakht\\Asanpardakht',
      'atipay' => 'Shetabit\\Multipay\\Drivers\\Atipay\\Atipay',
      'behpardakht' => 'Shetabit\\Multipay\\Drivers\\Behpardakht\\Behpardakht',
      'digipay' => 'Shetabit\\Multipay\\Drivers\\Digipay\\Digipay',
      'etebarino' => 'Shetabit\\Multipay\\Drivers\\Etebarino\\Etebarino',
      'idpay' => 'Shetabit\\Multipay\\Drivers\\Idpay\\Idpay',
      'irankish' => 'Shetabit\\Multipay\\Drivers\\Irankish\\Irankish',
      'nextpay' => 'Shetabit\\Multipay\\Drivers\\Nextpay\\Nextpay',
      'parsian' => 'Shetabit\\Multipay\\Drivers\\Parsian\\Parsian',
      'pasargad' => 'Shetabit\\Multipay\\Drivers\\Pasargad\\Pasargad',
      'payir' => 'Shetabit\\Multipay\\Drivers\\Payir\\Payir',
      'paypal' => 'Shetabit\\Multipay\\Drivers\\Paypal\\Paypal',
      'payping' => 'Shetabit\\Multipay\\Drivers\\Payping\\Payping',
      'paystar' => 'Shetabit\\Multipay\\Drivers\\Paystar\\Paystar',
      'poolam' => 'Shetabit\\Multipay\\Drivers\\Poolam\\Poolam',
      'sadad' => 'Shetabit\\Multipay\\Drivers\\Sadad\\Sadad',
      'saman' => 'Shetabit\\Multipay\\Drivers\\Saman\\Saman',
      'sep' => 'Shetabit\\Multipay\\Drivers\\SEP\\SEP',
      'sepehr' => 'Shetabit\\Multipay\\Drivers\\Sepehr\\Sepehr',
      'walleta' => 'Shetabit\\Multipay\\Drivers\\Walleta\\Walleta',
      'yekpay' => 'Shetabit\\Multipay\\Drivers\\Yekpay\\Yekpay',
      'zarinpal' => 'Shetabit\\Multipay\\Drivers\\Zarinpal\\Zarinpal',
      'zibal' => 'Shetabit\\Multipay\\Drivers\\Zibal\\Zibal',
      'sepordeh' => 'Shetabit\\Multipay\\Drivers\\Sepordeh\\Sepordeh',
      'rayanpay' => 'Shetabit\\Multipay\\Drivers\\Rayanpay\\Rayanpay',
      'sizpay' => 'Shetabit\\Multipay\\Drivers\\Sizpay\\Sizpay',
      'vandar' => 'Shetabit\\Multipay\\Drivers\\Vandar\\Vandar',
      'aqayepardakht' => 'Shetabit\\Multipay\\Drivers\\Aqayepardakht\\Aqayepardakht',
      'azki' => 'Shetabit\\Multipay\\Drivers\\Azki\\Azki',
    ),
  ),
  'queue' => 
  array (
    'default' => 'database',
    'connections' => 
    array (
      'sync' => 
      array (
        'driver' => 'sync',
      ),
      'database' => 
      array (
        'driver' => 'database',
        'table' => 'jobs',
        'queue' => 'default',
        'retry_after' => 90,
        'after_commit' => true,
      ),
      'beanstalkd' => 
      array (
        'driver' => 'beanstalkd',
        'host' => 'localhost',
        'queue' => 'default',
        'retry_after' => 90,
        'block_for' => 0,
        'after_commit' => true,
      ),
      'sqs' => 
      array (
        'driver' => 'sqs',
        'key' => '',
        'secret' => '',
        'prefix' => 'https://sqs.us-east-1.amazonaws.com/your-account-id',
        'queue' => 'default',
        'suffix' => NULL,
        'region' => 'us-east-1',
        'after_commit' => false,
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'default',
        'queue' => 'default',
        'retry_after' => 90,
        'block_for' => NULL,
        'after_commit' => false,
      ),
    ),
    'failed' => 
    array (
      'driver' => 'database-uuids',
      'database' => 'mysql',
      'table' => 'failed_jobs',
    ),
  ),
  'sanctum' => 
  array (
    'stateful' => 
    array (
      0 => 'localhost',
      1 => 'localhost:3000',
      2 => '127.0.0.1',
      3 => '127.0.0.1:8000',
      4 => '::1',
      5 => 'localhost:8000',
    ),
    'guard' => 
    array (
      0 => 'web',
    ),
    'expiration' => NULL,
    'middleware' => 
    array (
      'verify_csrf_token' => 'App\\Http\\Middleware\\VerifyCsrfToken',
      'encrypt_cookies' => 'App\\Http\\Middleware\\EncryptCookies',
    ),
  ),
  'services' => 
  array (
    'mailgun' => 
    array (
      'domain' => NULL,
      'secret' => NULL,
      'endpoint' => 'api.mailgun.net',
      'scheme' => 'https',
    ),
    'postmark' => 
    array (
      'token' => NULL,
    ),
    'ses' => 
    array (
      'key' => '',
      'secret' => '',
      'region' => 'us-east-1',
    ),
  ),
  'session' => 
  array (
    'driver' => 'file',
    'lifetime' => '120',
    'expire_on_close' => false,
    'encrypt' => false,
    'files' => 'C:\\Users\\Matin\\bimaryar\\storage\\framework/sessions',
    'connection' => NULL,
    'table' => 'sessions',
    'store' => NULL,
    'lottery' => 
    array (
      0 => 2,
      1 => 100,
    ),
    'cookie' => 'laravel_session',
    'path' => '/',
    'domain' => NULL,
    'secure' => NULL,
    'http_only' => true,
    'same_site' => 'lax',
  ),
  'view' => 
  array (
    'paths' => 
    array (
      0 => 'C:\\Users\\Matin\\bimaryar\\resources\\views',
    ),
    'compiled' => 'C:\\Users\\Matin\\bimaryar\\storage\\framework\\views',
  ),
  'flare' => 
  array (
    'key' => NULL,
    'flare_middleware' => 
    array (
      0 => 'Spatie\\FlareClient\\FlareMiddleware\\RemoveRequestIp',
      1 => 'Spatie\\FlareClient\\FlareMiddleware\\AddGitInformation',
      2 => 'Spatie\\LaravelIgnition\\FlareMiddleware\\AddNotifierName',
      3 => 'Spatie\\LaravelIgnition\\FlareMiddleware\\AddEnvironmentInformation',
      4 => 'Spatie\\LaravelIgnition\\FlareMiddleware\\AddExceptionInformation',
      5 => 'Spatie\\LaravelIgnition\\FlareMiddleware\\AddDumps',
      'Spatie\\LaravelIgnition\\FlareMiddleware\\AddLogs' => 
      array (
        'maximum_number_of_collected_logs' => 200,
      ),
      'Spatie\\LaravelIgnition\\FlareMiddleware\\AddQueries' => 
      array (
        'maximum_number_of_collected_queries' => 200,
        'report_query_bindings' => true,
      ),
      'Spatie\\LaravelIgnition\\FlareMiddleware\\AddJobs' => 
      array (
        'max_chained_job_reporting_depth' => 5,
      ),
      'Spatie\\FlareClient\\FlareMiddleware\\CensorRequestBodyFields' => 
      array (
        'censor_fields' => 
        array (
          0 => 'password',
          1 => 'password_confirmation',
        ),
      ),
      'Spatie\\FlareClient\\FlareMiddleware\\CensorRequestHeaders' => 
      array (
        'headers' => 
        array (
          0 => 'API-KEY',
        ),
      ),
    ),
    'send_logs_as_events' => true,
  ),
  'ignition' => 
  array (
    'editor' => 'phpstorm',
    'theme' => 'auto',
    'enable_share_button' => true,
    'register_commands' => false,
    'solution_providers' => 
    array (
      0 => 'Spatie\\Ignition\\Solutions\\SolutionProviders\\BadMethodCallSolutionProvider',
      1 => 'Spatie\\Ignition\\Solutions\\SolutionProviders\\MergeConflictSolutionProvider',
      2 => 'Spatie\\Ignition\\Solutions\\SolutionProviders\\UndefinedPropertySolutionProvider',
      3 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\IncorrectValetDbCredentialsSolutionProvider',
      4 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\MissingAppKeySolutionProvider',
      5 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\DefaultDbNameSolutionProvider',
      6 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\TableNotFoundSolutionProvider',
      7 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\MissingImportSolutionProvider',
      8 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\InvalidRouteActionSolutionProvider',
      9 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\ViewNotFoundSolutionProvider',
      10 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\RunningLaravelDuskInProductionProvider',
      11 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\MissingColumnSolutionProvider',
      12 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\UnknownValidationSolutionProvider',
      13 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\MissingMixManifestSolutionProvider',
      14 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\MissingViteManifestSolutionProvider',
      15 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\MissingLivewireComponentSolutionProvider',
      16 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\UndefinedViewVariableSolutionProvider',
      17 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\GenericLaravelExceptionSolutionProvider',
    ),
    'ignored_solution_providers' => 
    array (
    ),
    'enable_runnable_solutions' => NULL,
    'remote_sites_path' => 'C:\\Users\\Matin\\bimaryar',
    'local_sites_path' => '',
    'housekeeping_endpoint_prefix' => '_ignition',
    'settings_file_path' => '',
    'recorders' => 
    array (
      0 => 'Spatie\\LaravelIgnition\\Recorders\\DumpRecorder\\DumpRecorder',
      1 => 'Spatie\\LaravelIgnition\\Recorders\\JobRecorder\\JobRecorder',
      2 => 'Spatie\\LaravelIgnition\\Recorders\\LogRecorder\\LogRecorder',
      3 => 'Spatie\\LaravelIgnition\\Recorders\\QueryRecorder\\QueryRecorder',
    ),
  ),
  'tinker' => 
  array (
    'commands' => 
    array (
    ),
    'alias' => 
    array (
    ),
    'dont_alias' => 
    array (
      0 => 'App\\Nova',
    ),
  ),
);
