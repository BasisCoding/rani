<?php namespace Ams\Api\Controllers;

use Ams\API\Classes\ApiController;

use Ams\Asset\Models\Asset as AssetModels;
use Ams\Api\Transformers\AssetTransformer;
use Ams\Asset\Models\AssetItem as AssetItemModels;
use Ams\Api\Transformers\AssetItemTransformer;
use Ams\Asset\Models\Category as CategoryModels;
use Ams\Api\Transformers\AssetCategoryTransformer;

class AssetItems extends ApiController
{

    /**
     * [get description]
     * @return array fetch all assets
     */
    public function get()
    {
        $assets = AssetModels::orderBy('id', 'desc')->take(25)->get();
        return response()->json([
            'result'    => true,
            'response'  => $this->respondwithCollection($assets, new AssetTransformer)
        ]);
    }

    /**
     * [category description]
     * @return arary fetch all categories
     */
    public function category()
    {
        $categories = CategoryModels::whereNull('parent_id')->orderBy('name')->get();
        return response()->json([
            'result'   => true,
            'response' => $this->respondwithCollection($categories, new AssetCategoryTransformer)
        ]);
    }

    /**
     * [search description]
     * @return array search by description
     */
    public function search()
    {
        $name   = post('name');
        $assets = AssetItemModels::where('name', 'like', '%'.$name.'%')->take(25)->get();
        return response()->json([
            'result'    => true,
            'response'  =>  $this->respondwithCollection($assets, new AssetTransformer)
        ]);
    }

    /**
     * [detail description]
     * @return array search by id
     */
    public function detail()
    {
        $id     = input('id');
        $assets = AssetItemModels::find($id);
        return response()->json([
            'result'   => true,
            'response' => $this->respondwithItem($assets, new AssetTransformer)
        ]);
    }

    /**
     * [code description]
     * @return array search by code
     */
    public function code()
    {
        $code   = input('code');
        $assets = AssetItemModels::whereCode($code)->first();
        return response()->json([
            'result'    => true,
            'response'  => $this->respondwithItem($assets, new AssetTransformer),
        ]);
    }
}
