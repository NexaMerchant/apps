<?php
namespace NexaMerchant\Apps\Console\Commands;

use Illuminate\Console\Command;
use Exception;
use GuzzleHttp\Client;
abstract class CommandInterface extends Command
{

    abstract protected function getAppVer(); // app ver
    abstract protected function getAppName(); //app name

    /**
     * 
     * Get Package Base Dir
     * @param string $name
     * @return string
     * @access public
     * 
     */
    public function getBaseDir($name) {
        $base_dir = config("Apps.base_dir");
        $name = trim($name);
        $name = ucfirst($name);
        $dir = base_path().$base_dir.$name.'/';
        return $dir;
    }


    /**
     * 
     * Get Package namespace
     * @param string $name
     * @return string
     * @access public
     * 
     */

    public function ucfirstAppName($name) {
        $name = trim($name);
        $name = ucfirst($name);
        return $name;
    }


    /**
     * 
     * Get Package Config
     * 
     * 
     */
    protected function getPackageConfig($name) {
        $config = config($name);
        if(empty($config)) {
            // read the config file
            $configFile = $this->getBaseDir($name) . "src/Config/".$name.".php";
            if(!file_exists($configFile)) {
                return [];
            }
            
            $config = include $configFile;
        }
        return $config;
    }
}