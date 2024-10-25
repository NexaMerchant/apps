<?php
namespace NexaMerchant\Apps\Http\Controllers\Api\V1;

use Illuminate\Foundation\Validation\ValidatesRequests;

use NexaMerchant\Apps\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AppsController extends Controller
{

    use ValidatesRequests;

    private $storage;

    private $cache_expire = 60;
    
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

    public function publish(Request $request) {

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

        // check the app owner token todo


        // save the app to the database
        $app = \NexaMerchant\Apps\Models\App::where('name', $name)->first();
        if(is_null($app)) {
            $app = new \NexaMerchant\Apps\Models\App();
            $app->status = 'pending';
            $app->name = $name;
            $app->type = 'apps';
            $app->slug = $name;
            $app->code = $name;
            $app->description = $name;
            $app->author = $name;
            $app->email = $name;
            $app->url = $name;
            $app->category = 'apps';
            $app->tags = 'apps';
            $app->price = 0;
            $app->save();
        }

        // save the app version to the database
        $appVersion = \NexaMerchant\Apps\Models\AppVersion::where('version', $version)->where('app_id', $app->id)->first();
        if(is_null($appVersion)) {
            $appVersion = new \NexaMerchant\Apps\Models\AppVersion();
        }
        
        $appVersion->version = $version;
        $appVersion->description = $name;
        $appVersion->app_id = $app->id;
        $appVersion->status = 'pending';
        $appVersion->save();
        


        $data = [];
        $data['code'] = 200;
        $data['message'] = "success";
        return response()->json($data);
    }

    /**
     * 
     * Serch The Apps List
     * @return json
     * @param Request $request
     * @access public
     * 
     * @auther NexaMerchant
     * 
     */
    public function search(Request $request) {

        $name = $request->input('name');
        $limit = $request->input('limit', 10);
        $page = $request->input('page', 0);
        $type = $request->input('type', 'all');
        $sort = $request->input('sort', 'desc');
        $order = $request->input('order', 'created_at');
        $category = $request->input('category');

        $query = \NexaMerchant\Apps\Models\App::query();
        if($name) {
            $query->where('name', 'like', "%$name%");
        }

        if($type != 'all') {
            $query->where('type', $type);
        }

        if($category) {
            $query->where('category', $category);
        }

        $query->orderBy($order, $sort);


        $items = $query->paginate($limit, ['*'], 'page', $page);

        $data = [];
        $data['code'] = 200;
        $data['message'] = "success";
        $data['data'] = $items;
        return response()->json($data);
    }

    /**
     * 
     * Get The Apps Detail
     * @return json
     * @param Request $request
     * @access public
     * 
     * @auther NexaMerchant
     * 
     */
    public function show(Request $request, $id) {

        // add cache for the app detail
        $app = Cache::remember('apps_detail_' . $id, $this->cache_expire, function() use ($id) {
            return \NexaMerchant\Apps\Models\App::where('id', $id)->first();
        });

        $data = [];
        $data['code'] = 200;
        $data['message'] = "success";
        $data['data'] = $app;
        return response()->json($data);
    }

    /**
     * 
     * Get The Apps Platform Category
     * @return json
     */
    public function category() {

        // add cache for the category

        $category = Cache::remember('apps_category', $this->cache_expire, function() {
            return \NexaMerchant\Apps\Models\App::select('category')->groupBy('category')->get();
        });

        $data = [];
        $data['code'] = 200;
        $data['message'] = "success";
        $data['data'] = $category;
        return response()->json($data);
    }

    /**
     * 
     * Get The Apps Platform Type
     * @return json
     */
    public function type() {

        // add cache for the type
        $type = Cache::remember('apps_type', $this->cache_expire, function() {
            return \NexaMerchant\Apps\Models\App::select('type')->groupBy('type')->get();
        });

        $data = [];
        $data['code'] = 200;
        $data['message'] = "success";
        $data['data'] = $type;
        return response()->json($data);
    }

    /**
     * 
     * Get The Apps Platform list
     * @return json
     */
    public function list(Request $request) {

        $page = $request->input('page', 1);
        $limit = $request->input('limit', 10);

        // add cache for the list
        $list = Cache::remember('apps_list', $this->cache_expire, function() use ($page, $limit) {
            return \NexaMerchant\Apps\Models\App::paginate($limit, ['*'], 'page', $page);
            //return \NexaMerchant\Apps\Models\App::groupBy('code')->get();
        });

        $data = [];
        $data['code'] = 200;
        $data['message'] = "success";
        $data['data'] = $list;
        return response()->json($data);

    }


}