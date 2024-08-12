<?php
namespace NexaMerchant\Apps\Console\Commands;


class Update extends CommandInterface
{
    protected $signature = 'apps:update {name}';

    protected $description = 'Update an app';

    public function getAppVer() {
        return config("Apps.ver");
    }

    public function getAppName() {
        return config("Apps.name");
    }

    public function handle()
    {
        $name = $this->argument('name');
        if(empty($name)) {
            $this->error("App name is required!");
            return false;
        }
        $this->info("Update app: $name");

        if (!$this->confirm('Do you wish to continue?')) {
            // ...
            $this->error("App $name Update cannelled!");
            return false;
        }
        
        $dir = $this->getBaseDir($name);
        $this->info($dir);

        if(!file_exists($dir)) {
            $this->error("App $name not exists!");
            return false;
        }

        $package = config($name.".composer");
        if(empty($package)) {
            $this->error("App $name not exists!");
            return false;
        }

        $this->info("Updating app $name...");
        
        try {
            $result = shell_exec("composer update ".config($name.".composer"));

            //var_dump($result);
            //$this->info("App $name updated successfully!");

        }catch(\Exception $e) {
            $this->error("App $name update failed!". $e->getMessage());
            return false;
        }
        

    }

}