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

class UnInstall extends CommandInterface 

{
    protected $signature = 'Apps:uninstall';

    protected $description = 'Uninstall Apps an app';

    public function getAppVer() {
        return config("Apps.ver");
    }

    public function getAppName() {
        return config("Apps.name");
    }

    public function handle()
    {
        if (!$this->confirm('Do you wish to continue?')) {
            // ...
            $this->error("App Apps UnInstall cannelled");
            return false;
        }
    }
}