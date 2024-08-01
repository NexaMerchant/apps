<?php
namespace NexaMerchant\Apps\Console\Commands;

class Login extends CommandInterface
{
    protected $signature='apps:login';

    protected $description='Login to an app';

    public function getAppVer() {
        return config("Apps.ver");
    }

    public function getAppName() {
        return config("Apps.name");
    } 

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('Login to an app');
    }
}