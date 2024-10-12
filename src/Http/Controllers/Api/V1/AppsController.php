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

    public function __construct() {
        parent::__construct();
    }
    
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

    /**
     * 
     * Get The Apps List
     * @return json
     * @param Request $request
     * @access public
     * 
     * @auther NexaMerchant
     * 
     */
    public function index(Request $request) {

        $name = $request->input('name');
        $limit = $request->input('limit', 10);
        $page = $request->input('page', 1);
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

        $data = $query->paginate($limit, ['*'], 'page', $page);

        $data = [];
        $data['code'] = 200;
        $data['message'] = "success";
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


}