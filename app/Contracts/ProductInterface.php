<?php

namespace App\Contracts;

use App\Models\Product;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Http\Request;

interface ProductInterface
{
    /**
     * index product
     *
     * @param Request $request
     *
     * @return Builder
     */
    public function index(Request $request) : Builder;

    /**
     * store product.
     *
     * @param array $storeProductData
     * @return Product
     */
    public function store(array $storeProductData) : Product;

    /**
     * update product.
     *
     * @param int $productId
     * @param array $updateProductData
     * @return bool
     */
    public function update(int $productId, array $updateProductData) : bool;

    /**
     * remove product.
     *
     * @param int $productId
     *
     * @return bool
     */
    public function delete(int $productId);
}
