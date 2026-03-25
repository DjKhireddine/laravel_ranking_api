<?php

namespace App\Product;

use App\Http\Controllers\Controller;
use HttpResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProductController extends Controller
{
    public function __construct(private Product $productModel)
    {

    }
    public function index(): JsonResponse
    {
        return new JsonResponse($this->productModel->all());
    }

    public function show(string $id): JsonResponse
    {
        return new JsonResponse(["message" => "Product Detail: $id"]);
    }

    public function create(Request $request): JsonResponse
    {
        $product = new Product($request->all());
        $product->save();
        return new JsonResponse(["message" => "Product saved"]);
    }

    private function replace(Request $request, string $id): JsonResponse
    {
        return new JsonResponse([
            "message" => "Product full replace: $id",
            "request" => $request->all(),
        ]);
    }

    private function update(Request $request, string $id): JsonResponse
    {
        return new JsonResponse([
            "message" => "Product partial update: $id",
            "request" => $request->all(),
        ]);
    }
}
