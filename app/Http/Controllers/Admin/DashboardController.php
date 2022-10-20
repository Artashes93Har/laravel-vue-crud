<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin/dashboard');
    }

    public function postProducts(): JsonResponse
    {
        $products = Product::with('category')
            ->orderBy('id', 'DESC')
            ->paginate(5);
        return response()->json(['products' => $products]);
    }

    public function changeStatus(Request $request) {
        $product = Product::find($request
            ->input('id'))
            ->update(['status' => $request->input('status')]);

        return response()->json([
            'status' => 'success'
        ]);
    }
}
