<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditProductRequest;
use App\Http\Requests\StoreProductRequest;
use App\Jobs\ProcessProductCreated;
use App\Models\Products;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Products::orderBy("created_at", "desc")->get();
        
        return view("index", ["products" => $products]);
    }

    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();

        $product = Products::create([
            "NAME" => $data["NAME"],
            "ARTICLE" => $data["ARTICLE"],
            "STATUS" => $data["AVAILABLE"],
            "DATA" => $data["ATTRS"],
        ]);

        ProcessProductCreated::dispatch($product);
        
        return ["status" => "ok", "product_id" => $product->id];
    }

    public function destroy($product_id){

        $check = Products::find($product_id);

        if (!empty($check)){
            Products::destroy($product_id);
        }

        return ["status" => "ok"];
    }

    public function update(EditProductRequest $request, $product_id){
        
        $data = $request->validated();

        $check = Products::find($product_id);

        $name_check = Products::where(["ARTICLE" => $data["ARTICLE"]])->where("id", "!=", $data["id"])->count();

        if ($name_check){
            abort(422, "Продукт с таким артикулем уже существует");
        }

        if (!empty($check)){
            Products::where(["id" => $product_id])->update([
                "NAME" => $data["NAME"],
                "ARTICLE" => $data["ARTICLE"],
                "STATUS" => $data["AVAILABLE"],
                "DATA" => $data["ATTRS"],
            ]);
        }

        return ["status" => "ok"];
    }
}
