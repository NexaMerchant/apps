<?php
/**
 * 
 * This file is auto generate by Nicelizhi\Apps\Commands\Create
 * @author Steve
 * @date 2024-07-31 16:40:01
 * @link https://github.com/xxxl4
 * 
 */
namespace NexaMerchant\Apps\Console\Commands;

use Nicelizhi\Apps\Console\Commands\CommandInterface;

class Install extends CommandInterface 

{
    protected $signature = 'Apps:install';

    protected $description = 'Install Apps an app';

    public function getAppVer() {
        return config("Apps.ver");
    }

    public function getAppName() {
        return config("Apps.name");
    }

    public function handle()
    {
        $this->info("Install app: Apps");
        if (!$this->confirm('Do you wish to continue?')) {
            // ...
            $this->error("App Apps Install cannelled");
            return false;
        }
    }
}