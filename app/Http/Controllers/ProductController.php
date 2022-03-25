<?php

namespace App\Http\Controllers;

use App\Contracts\ProductInterface;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    /**
     *  Get list of products
     *
     * @param Request $request
     * @param ProductInterface $productInterface
     *
     * @return JsonResponse
     */
    public function index(Request $request, ProductInterface $productInterface) : JsonResponse
    {
        $result = $productInterface->index($request);

        return ProductResource::collection($result->paginate(10))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Create new product
     *
     * @param ProductStoreRequest $productStoreRequest
     * @param ProductInterface $productInterface
     *
     * @return JsonResponse
     */
    public function store(ProductStoreRequest $productStoreRequest, ProductInterface $productInterface) : JsonResponse
    {
        $createdModel = $productInterface->store([
            'name' => $productStoreRequest->get('name'),
            'user_id' => Auth::user()->id
        ]);

        return ProductResource::make($createdModel)->response()->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Update product
     *
     * @param ProductStoreRequest $productStoreRequest
     * @param Product $product
     *
     * @param ProductInterface $productInterface
     *
     * @return JsonResponse
     */
    public function update(ProductStoreRequest $productStoreRequest, Product $product, ProductInterface $productInterface):JsonResponse
    {
        $productInterface->update($product->id, [
                'name' => $productStoreRequest->get('name'),
                'user_id' => Auth::user()->id
        ]);

        return ProductResource::collection([])->response()->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * Remove product
     *
     * @param Product $product
     * @param ProductInterface $productInterface
     *
     * @return JsonResponse
     */
    public function destroy(Product $product, ProductInterface $productInterface): JsonResponse
    {
        $productInterface->delete($product->id);
        return ProductResource::collection([])->response()->setStatusCode(Response::HTTP_NO_CONTENT);
    }

    /**
     *  Show product
     *
     * @param Product $product
     *
     * @return JsonResponse
     */
    public function show(Product $product): JsonResponse
    {
        return ProductResource::make($product)->response()->setStatusCode(Response::HTTP_OK);
    }
}
