<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use  App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('user.dashboard');
    }

    /**
     * @return JsonResponse
     */
    public function getCategories(): JsonResponse
    {
        $categories = Category::where('user_id', auth()->id())
            ->orderBy('id', 'DESC')
            ->paginate(5);

        return response()->json(['categories' => $categories]);

    }

    public function getProducts(): JsonResponse
    {
        $products = Product::where('user_id', auth()->id())
            ->with('category')
            ->orderBy('id', 'DESC')
            ->paginate(5);

        return response()->json(['products' => $products]);
    }

    /**
     * @return JsonResponse
     */
    public function getCategoryList(): JsonResponse
    {
        $categoryList = Category::where(
            'user_id', auth()
                ->id())
                ->get();
        return response()->json(['category_list' => $categoryList]);
    }

    public function addCategory(CategoryRequest $request)
    {
        $category = Category::create([
            'user_id' => auth()->id(),
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);
        return response()->json([
            'status' => 'success',
            'category' => $category,
        ]);

    }

    public function addProduct(ProductRequest $request)
    {
        $product = Product::create([
            'user_id' => auth()->id(),
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'category_id' => $request->input('category_id'),
        ]);

        $product = Product::where('id', $product->id)
            ->with('category')
            ->first();

        return response()->json([
            'status' => 'success',
            'product' => $product,
        ]);
    }
    public function deleteCategory(Request $request)
    {
        $id = $request->input('id');
        Category::find($id)->delete();
        Product::where('category_id', $id)->delete();
        $category = Category::orderBy('id', 'desc')
            ->skip($request->input('current_page') * 5 - 1)
            ->take(1)->first();
        return response()->json(['message' => 'Category deleted!', 'category' => $category]);

    }
    public function deleteProduct(Request $request)
    {
        $id = $request->input('id');
        Product::find($id)->delete();
        $product = Product::orderBy('id', 'desc')
            ->with('category')
            ->skip($request->input('current_page') * 5 - 1)
            ->take(1)->first();
        return response()->json(['message' => 'Product deleted!', 'product' => $product]);
    }


    public function updateCategory(CategoryRequest $request)
    {
        $inputs = $request->only('name', 'description');
        $category = Category::find($request
            ->input('id'))
            ->update($inputs);

        return response()->json([
            'status' => 'success',
            'post'   => $category
        ]);
    }
    public function updateProduct(ProductRequest $request)
    {
        $inputs = $request->only('name', 'price', 'category_id');
        $product = Product::find($request->input('id'))
            ->update($inputs);
        $product = Product::where('id', $request
            ->input('id'))
            ->with('category')
            ->first();

        return response()->json([
            'status' => true,
            'product'   => $product,
        ]);
    }



}
