<?php namespace Ams\Api\Controllers;

use Octobro\API\Classes\ApiController;

// use Foo\Bar\Models\Product;
// use Foo\Bar\Transformers\ProductTransformer;

class Products extends ApiController
{
    public function index()
    {
        return  \QrCode::size(500)->format('png')->generate('ItSolutionStuff.com', public_path('images/qrcode.png'));
        return response()->json([
            'result' => true,
        ]);
        $products = Product::get();
        return $this->respondwithCollection($products, new ProductTransformer);
    }
}
