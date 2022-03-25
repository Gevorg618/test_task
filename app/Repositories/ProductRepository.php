<?php

namespace App\Repositories;

use App\Contracts\ProductInterface;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class ProductRepository implements ProductInterface
{
    /**
     * @var Product
     */
    protected Product $product;

    public function index(Request $request) : Builder
    {

        $query = $this->product->query();

        if ($request->input('product_name')) {
            $query->where('name', 'like', '%'.$request->input('product_name').'%');
        }

        if ($request->input('created_date')) {
            $query->whereDate('created_at', $request->input('created_date'));
        }

        $authorName = $request->input('author_name');

        if ($authorName) {
            $query->with('user',  function ($q) use ($authorName) {
                    $q->where('name', 'like', '%'.$authorName.'%');
            });
        }

        return $query;
    }

    /**
     * ProductRepository constructor.
     */
    public function __construct()
    {
        $this->product = new Product();
    }

    public function store(array $storeBrandData) : Product
    {
        return $this->product->create($storeBrandData);
    }

    public function update(int $productId, array $updateModelData) : bool
    {
        return $this->product->find($productId)->update($updateModelData);
    }

    public function delete(int $productId)
    {
        $this->product->find($productId)->delete();
    }
}
