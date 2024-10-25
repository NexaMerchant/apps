<?php
namespace NexaMerchant\Apps\Console\Commands;


class Install extends CommandInterface 

{
    protected $signature = 'apps:install {name}';

    protected $description = 'Install an app';

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
        $this->info("Install app: $name");

        if (!$this->confirm('Do you wish to continue?')) {
            // ...
            $this->error("App $name Install cannelled!");
            return false;
        }
        
        $dir = $this->getBaseDir($name);
        $this->info($dir);

        exit;

        if(file_exists($dir)) {
            $this->error("App $name already exists!");
            //return false;
        }

        $this->info("Installing app $name...");
        
        try {
            $result = shell_exec("composer require ".config($name.".composer"));

            //var_dump($result);
            //$this->info("App $name installed successfully!");

        }catch(\Exception $e) {
            $this->error("App $name install failed!". $e->getMessage());
            return false;
        }
        


        
        


    }
}