<?php 
namespace NexaMerchant\Apps\Console\Commands;
use Exception;
use GuzzleHttp\Client;

class Publish extends CommandInterface
{

    private $AppName = null;

    private $AppNameLower = null;

    protected $signature = 'apps:publish {--name=}';

    protected $description = 'Publish the apps';


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
        $this->info('Publishing the apps...');
        $name = $this->ask('Please Input your Apps Name?');
        $this->info("Creating app: $name");

        $dir = $this->getBaseDir($name);

        $this->info("dir ". $dir);

        if (!$this->confirm('Do you wish to continue?')) {
            // ...
            $this->error("App $name cannelled");
            return false;
        }

        // if(!$this->checkOnelineAppName($name)) {
        //     $this->error("App $name is not valid");
        //     return false;
        // }

        // create a zip file and add package directory to it
        $this->info("Zipping the app $name");

        $this->AppName = $this->ucfirstAppName($name); //source name

        $this->AppNameLower = strtolower($name);

        $zip = new \ZipArchive();

        try {
             // read the package config info
            $packageConfig = $this->getPackageConfig($name);

            // zip File name include the app name and app version
            $zipFileName = $packageConfig['name'] . "-" . $packageConfig['version'] . ".zip";

            $zip->open($zipFileName, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        } catch (\Exception $e) {
            $this->error("App $name zip failed");
            return false;
        }
       

       $this->addDirToZip($dir, $zip);

        $zip->close();

        $this->info("App $name zipped successfully");

        // move the zip file to the packages storage directory

        $zipFile = storage_path("Apps/") . $this->AppName . "/" . $zipFileName;

        // check the zipFile Directory
        if (!file_exists(storage_path("Apps/") . $this->AppName)) {
            mkdir(storage_path("Apps/") . $this->AppName, 0777, true);
        }



        // $zipFile = base_path() . "/packages/Apps/" . $this->AppName . "/" . $zipFileName;

        $this->info("Moving the app $name to $zipFile");

        rename($zipFileName, $zipFile);

        $this->info("App $name moved successfully");

        // publish the zip file to the storage server use the storage server api

        $this->info("Publishing the app $name");

        $client = $this->setClient();

        $response = $client->request('POST', '/api/v1/apps/publish', [
            'headers' => [
                'X-Access-Token' => "Bearer ".config("Apps.token"),
            ],
            'multipart' => [
                [
                    'name'     => 'file',
                    'contents' => fopen($zipFile, 'r'),
                    'filename' => $zipFileName
                ],
                [
                    'name'     => 'name',
                    'contents' => $this->AppName
                ],
                [
                    'name'     => 'version',
                    'contents' => $packageConfig['version']
                ],
                [
                    'name'     => 'type',
                    'contents' => 'apps'
                ]
            ]
        ]);

        $content = $response->getBody()->getContents();
        $this->info("Response: ".$content);
       // $this->info("App $name published successfully");


    }

    public function addDirToZip($dir, $zipArchive, $zipdir = '')
    {
        if (is_dir($dir)) {
            if ($dh = opendir($dir)) {
                while (($file = readdir($dh)) !== false) {
                    // If file is not a directory, add it to the archive
                    if (!is_dir($dir . $file)) {
                        // Get real and relative path for current file
                        $filePath = $dir . $file;
                        $relativePath = $zipdir . $file;
                        // Add current file to archive
                        $zipArchive->addFile($filePath, $relativePath);
                    } elseif ($file != '.' && $file != '..') {
                        // Add sub-directory to archive
                        $this->addDirToZip($dir . $file . '/', $zipArchive, $zipdir . $file . '/');
                    }
                }
                closedir($dh);
            }
        }
    }

}