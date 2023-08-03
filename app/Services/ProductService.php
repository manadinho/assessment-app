<?php

namespace App\Services;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductService
 * @package App\Services\ProductService
 * 
 * @author Muhammad Imran Israr (mimranisrar6@gmail.com)
 */
class ProductService 
{
    /**
     * Get records from the database based on the given condition.
     *
     * @param string $model The fully qualified model class name.
     * @param array $condition An associative array representing the conditions for the query.
     * @return \Illuminate\Database\Eloquent\Collection The collection of records matching the condition.
     */
    public function get($model, array $condition = []): Collection
    {
        // todo we can manage where clauses for complex queries as well in future
        return $model::where($condition)->get();
    }
    
    /**
     * Update or create sizes for a product based on the given request data.
     *
     * @param ProductRequest $request The request object containing the main options array data and other inputs.
     * @param Product $product The product instance for which the sizes need to be updated or created.
     * @return void
     */
    public function updateOrCreateSize(ProductRequest $request, Product $product): void 
    {
        $options = json_decode($request->mainOptionsArrayData);

        $iteration = 0;

        foreach ($request->names as $name) {
            $child_sizes_array = [];

            $child_sizes_array['name'] = $name;

            $child_sizes_array['price'] = $request->prices[$iteration];

            $child_sizes_array['product_id'] = $product->id;

            $size = Size::updateOrCreate(['id' => $request->sized_ids[$iteration]], $child_sizes_array);

            $size->options()->sync($options[$iteration]);

            $iteration++;
        }

    }

    /**
     * Delete Sizes associated with a Product.
     *
     * This function deletes the sizes of a given Product that are not in the provided list of `sized_ids`.
     *
     * @param \App\Http\Requests\ProductRequest $request The HTTP request object containing the list of sized_ids.
     * @param \App\Models\Product $product The Product model instance for which sizes need to be deleted.
     * @return void
     */
    public function deleteSize(ProductRequest $request, Product $product): void
    {
        Size::where('product_id', $product->id)->whereNotIn('id', $request->sized_ids)->delete();
    }
}
