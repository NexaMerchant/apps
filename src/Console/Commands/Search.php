<?php
namespace NexaMerchant\Apps\Console\Commands;

use GuzzleHttp\Client;

class Search extends CommandInterface 
{
    protected $signature = 'apps:search {name} {--type=} {--category=} {--sort=} {--order=} {--limit=} {--page=}';

    protected $description = 'list an app {name} {--type=} {--category=} {--sort=} {--order=} {--limit=} {--page=}';

    protected $type = null;

    public function getAppVer() {
        return config("apps.ver");
    }

    public function getAppName() {
        return config("apps.name");
    }

    public function handle()
    {
        $name = $this->argument('name');

        $this->type = $this->option('type');
        $category = $this->option('category');

        if(empty($this->type)) {
            $this->type = 'all';
        }

        if(empty($name)) {
            $this->error("App name is required!");
            return false;
        }

        $client = $this->setClient();

        $response = $client->get('/api/v1/apps/search', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'X-Access-Token' => "Bearer ".config("apps.token"),
            ],
            'query' => [
                'name' => $name,
                'type' => $this->type,
                'category' => $category,
                'sort' => $this->option('sort'),
                'order' => $this->option('order'),
                'limit' => $this->option('limit'),
                'page' => $this->option('page'),
            ]
        ]);

        //$this->info("Response: ".$response->getStatusCode());
    
        $response = json_decode($response->getBody()->getContents(),true);

        $this->error("Search for: ".$name);
        $this->info("Total: ".$response['data']['total']);

        $this->table(
            ['ID','App Name', 'App Slug','App Code','App Description','App Version','App Author','App Email','App URL','App Icon','App Status','App Type','App Category','App Tags','App Price','App License','App Require','App Require PHP','App Require Laravel','App Require MySQL'],
            $response['data']['data']
        );


        
    }
}