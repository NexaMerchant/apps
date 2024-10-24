<?php

namespace NexaMerchant\Apps\Console\Commands\Plugin;

use Illuminate\Console\Command;
use Exception;
use GuzzleHttp\Client;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plugin:install {name} {--version=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install a plugin from the NexaMerchant App Store';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->argument('name');
        $version = $this->option('version');

        $this->info("Installing plugin $name");

        // download the plugin from the NexaMerchant App Store
        // extract the plugin to the plugins directory
        // update the plugins.json file

        // if version is not provided, install the latest version
        if ($version) {
            $this->info("Installing version $version");
        } else {
            $this->info("Installing the latest version");
        }

        // search the plugin in the NexaMerchant App Store
        $client = new Client([
            'timeout'  => 20.0,
            'debug' => false,
        ]);
        $host = config("Apps.url");
        if(empty($host)) {
            throw new Exception("Please config the Apps url");
            return false;
        }

        $base_url = $host ."/api/Apps/detail/".$name.'/'.$version;


        try {
            $response = $client->get($base_url, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'X-Access-Token' => "Bearer ".config("Apps.token"),
                ]
            ]);
    
            $this->info("Response: ".$response->getStatusCode());

            //var_dump($response->getBody()->getContents());
        
            $response = json_decode($response->getBody()->getContents(),true);

        }catch(Exception $e) {
            $this->error($e->getMessage());
        }

        // download the plugin zip file
        $zipFile = $response['data']['apps']['zip_file'];
        $zipFileName = $response['data']['apps']['zip_file_name'];

        $this->info("Downloading the plugin zip file: $zipFileName");

        $zipFilePath = storage_path("Apps/") . $name . "/" . $zipFileName;

        // check the zipFile Directory
        if (!file_exists(storage_path("Apps/") . $name)) {
            mkdir(storage_path("Apps/") . $name, 0777, true);
        }

        $client->request('GET', $zipFile, ['sink' => $zipFilePath]);

        $this->info("Plugin zip file downloaded successfully");

        // extract the plugin zip file

        $zip = new \ZipArchive;
        $res = $zip->open($zipFilePath);
        if ($res === TRUE) {
            $zip->extractTo(base_path('plugins'));
            $zip->close();
            $this->info("Plugin $name extracted successfully");
        } else {
            $this->error("Failed to extract the plugin $name");
        }



        $this->info("Plugin $name installed successfully");
    }
}