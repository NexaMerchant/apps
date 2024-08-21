<?php
namespace NexaMerchant\Apps\Http\Controllers\Api\V1;

use Illuminate\Foundation\Validation\ValidatesRequests;

use NexaMerchant\Apps\Http\Controllers\Api\Controller;

class AppsController extends Controller
{
    
    /**
     * 
     * publish api for the apps upload zip file and publish
     * @return json
     * 
     * @access public
     * 
     * @param file $file
     * @param string $name
     * @param string $version
     * @param string $token
     * 
     * 
     */

    public function publish() {

        // save file to the storage

        // publish the zip file to the storage server use the storage server api

        $file = request()->file('file');

        $name = request()->input('name');

        $version = request()->input('version');

        $token = request()->input('token');

        $zipFileName = $file->getClientOriginalName();

        $zipFile = storage_path("Apps/") . $name . "/" . $zipFileName;

        // check the zipFile Directory
        if (!file_exists(storage_path("Apps/") . $name)) {
            mkdir(storage_path("Apps/") . $name, 0777, true);
        }

        $file->move(storage_path("Apps/") . $name, $zipFileName);

        //$this->info("Moving the app $name to $zipFile");



        $data = [];
        $data['code'] = 200;
        $data['message'] = "success";
        return response()->json($data);
    }


}