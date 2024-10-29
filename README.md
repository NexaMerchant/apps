# NexaMerchant/Apps

[![Build Status](https://github.com/NexaMerchant/apps/workflows/Laravel/badge.svg)](https://github.com/NexaMerchant/apps)
[![Release](https://img.shields.io/github/release/NexaMerchant/apps.svg?style=flat-square)](https://github.com/NexaMerchant/apps/releases)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/Nexa-Merchant/apps.svg?style=flat-square)](https://packagist.org/packages/Nexa-Merchant/apps)
[![Total Downloads](https://img.shields.io/packagist/dt/Nexa-Merchant/apps.svg?style=flat-square)](https://packagist.org/packages/Nexa-Merchant/apps)

> NexaMerchant is a apps store for NexaMerchant Platform, NexaMerchant is a free merchant software,you can use it build for ecommence, blog, cms, erp etc

# How to Install


```
NexaMerchant\Apps\Providers\AppsServiceProvider::class,
```
Add it to config/app.php $providers

# How to Install use composer

```
composer require nexa-merchant/apps
```

# How to create a new app packages
```
php artisan apps:create
```

# How to get a user token

```
php artisan apps:login
```

# How to Remove a app packages
```
php artisan apps:remove {app_name}
```

# How to publish a app packages
```
php artisan apps:publish {app_name}
```
