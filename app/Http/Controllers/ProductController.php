<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductSearchRequest;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;


class ProductController extends ApiController
{
    /**
     * @param ProductSearchRequest $request
     * @param ProductService $postService
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(ProductSearchRequest $request, ProductService $postService)
    {
        $response = $postService->_list($request);
        return $this->successResponseWithData($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
