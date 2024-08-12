<?php
namespace NexaMerchant\Apps\Console\Commands;


class UnInstall extends CommandInterface
{
    protected $signature = 'apps:uninstall {name}';

    protected $description = 'Uninstall an app';

    public function getAppVer() {
        return config("apps.ver");
    }

    public function getAppName() {
        return config("apps.name");
    }

    public function handle()
    {
        $name = $this->argument('name');

        if(empty($name)) {
            $this->error("App name is required!");
            return false;
        }

        $this->info("Uninstall app: $name");

        if (!$this->confirm('Do you wish to continue?')) {
            // ...
            $this->error("App $name Uninstall cannelled!");
            return false;
        }

        $dir = $this->getBaseDir($name);
        $this->info($dir);

        if(!file_exists($dir)) {
            $this->error("App $name not exists!");
            return false;
        }

        $this->info("Remove app $name...");
        
        try {
            $result = shell_exec("composer remove ".config($name.".composer"));


        }catch(\Exception $e) {
            $this->error("App $name update failed!". $e->getMessage());
            return false;
        }
    }
}