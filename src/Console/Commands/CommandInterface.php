<?php
namespace NexaMerchant\Apps\Console\Commands;

use Illuminate\Console\Command;
abstract class CommandInterface extends Command
{

    abstract protected function getAppVer(); // app ver
    abstract protected function getAppName(); //app name

    public function getBaseDir($name) {
        $base_dir = config("Apps.base_dir");
        $name = trim($name);
        $name = ucfirst($name);
        $dir = base_path().$base_dir.'/'.$name;
        return $dir;
    }

    public function ucfirstAppName($name) {
        $name = trim($name);
        $name = ucfirst($name);
        return $name;
    }
}