<?php

namespace App\Http\Controllers;

use App\Models\Option;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\RedirectResponse;
use App\Services\ProductService;
use Illuminate\View\View;

/**
 * Class ProductController
 * @package App\Http\Controllers\ProductController
 * 
 * @author Muhammad Imran Israr (mimranisrar6@gmail.com)
 */
class ProductController extends Controller
{
    public $productService = null;

    public function __construct(ProductService $service)
    {
        $this->productService = $service;
    }

    /**
     * Display the index page with a list of products.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View 
    {
        return view('products.index', [
            'products' => $this->productService->get(Product::class)
        ]);        
    }

    /**
     * Create a new product.
     *
     * This function is responsible for rendering the 'create' view for adding a new product.
     *
     * @return \Illuminate\View\View The rendered 'products.create' view.
     */
    public function create(): View
    {
        return view('products.create', [
            'options' => $this->productService->get(Option::class)
        ]);
    }

    /**
     * Store a new or update an existing product.
     *
     * @param \App\Http\Requests\ProductRequest $request The HTTP request containing the product data.
     * @return \Illuminate\Http\RedirectResponse A redirect response after the transaction is completed.
     */
    public function store(ProductRequest $request): RedirectResponse
    {
        try {
            return DB::transaction(function()use($request){
                        $product = Product::updateOrCreate(['id' => $request->id], $request->only('name', 'description'));
                        
                        // delete removed sizes
                        $this->productService->deleteSize($request, $product);

                        // update or create sizes and sync options
                        $this->productService->updateOrCreateSize($request, $product);

                        $message = ($product->id) ? 'Product updated!':'Product created!' ;

                        return redirect()->route('products.index')->with('success', $message);
                    });   
        } catch (\Throwable $th) {
            return back()->with('fail', $th->getMessage());
        }
    }

    /**
     * Edit a product.
     *
     * Retrieves the product with the specified ID along with its associated sizes and options
     * from the database and passes the data to the 'products.create' view for editing.
     *
     * @param int $id The ID of the product to be edited.
     * @return \Illuminate\Contracts\View\View The view for editing the product.
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the product with the given ID is not found.
     */
    public function edit($id): View
    {
        $product = Product::where('id', $id)->with('sizes.options')->firstOrFail();

        return view('products.create', [
            'options' => $this->productService->get(Option::class),
             'product' => $product
            ]);
    }

    /**
     * Delete a product.
     *
     * @param Product $product The product to be deleted.
     *
     * @return RedirectResponse A redirect response after deleting the product.
     */
    public function delete(Product $product): RedirectResponse
    {
        try{
            $product->delete();
            return redirect()->route('products.index')->with('success', 'Product deleted!');
        } catch (\Throwable $th) {
            return back()->with('fail', $th->getMessage());
        }
    }
}
