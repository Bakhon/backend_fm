<?php

namespace App\Services;

use App\Http\Requests\ProductSearchRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;


/**
 * Class PostService
 * @package App\Services
 */
class ProductService extends Service
{
    /**
     * Get products with relations by filter
     *
     * @param ProductSearchRequest $request
     * @return array
     */
    public function _list(ProductSearchRequest $request): array
    {
        $query = Product::where([]);

        $query->where(function ($query) use ($request) {
            $query->orWhere('name', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
        });

        if (!Gate::allows('products_all')) {
            $query->where(['user_id' => Auth::user()->sub]);
        }

        $queryWithoutLimit = clone $query;

        $query->limit($request->limit);
        $query->offset($request->offset);

        $posts = ProductResource::collection($query->get());

        return [
            'list' => $posts,
            'listCount' => $queryWithoutLimit->count(),
        ];
    }
}
