<?php
namespace NexaMerchant\Apps\Console\Commands;

use GuzzleHttp\Client;

class Search extends CommandInterface 
{
    protected $signature = 'app:search {name}';

    protected $description = 'list an app';

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

        $client = $this->setClient();

        $base_url = config("apps.url")."".$name;
        $this->info("Base URL: ".$base_url);

        $response = $client->get('/api/v1/app/search/', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'X-Access-Token' => "Bearer ".config("apps.token"),
            ]
        ]);

        $this->info("Response: ".$response->getStatusCode());
    
        $response = json_decode($response->getBody()->getContents(),true);

        $this->table(
            ['ID','App Name', 'App Slug','App Code','App Description','App Version','App Author','App Email','App URL','App Icon','App Status','App Type','App Category','App Tags','App Price','App License','App Require','App Require PHP','App Require Laravel','App Require MySQL'],
            $response['data']['apps']
        );


        
    }
}