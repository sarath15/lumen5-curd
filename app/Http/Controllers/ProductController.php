<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function index(){
        $products = $this->product->query()->get();
        // return response($products, '201')
        //           ->header('Content-Type', 'utf-8');
        return response()->json(['data'=>$products, 'code'=>0, 'msg'=>'success'], 200);
    }

    public function get($id)
    {
        $product = $this->product->query()->find($id);
        if (!$product){
            return response()->json(['code'=>-1, 'msg'=>'not found'], 200);
        }
        return response()->json(['data'=>$product, 'code'=>0, 'msg'=>'success'], 200);
    }

    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'desc' => 'string',
            'price' => 'required|numeric|min:0',
            'cnt' => 'required|int|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json(['code'=>-1, 'msg'=>$validator->errors()]);
        }

        $product = new $this->product;
        $product->name = $request->input('name');
        $product->desc = $request->input('desc');
        $product->price = $request->input('price');
        $product->cnt = $request->input('cnt');
        $id = $product->save();

        return response()->json(['id'=>$product->id, 'code'=>0, 'msg'=>'success'], 200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'desc' => 'string',
            'price' => 'required|numeric|min:0',
            'cnt' => 'required|int|min:0'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $product = $this->product->query()->find($id);
        $items = array('name', 'desc', 'price', 'cnt');   
        foreach ($items as $key => $value) {
            if ($request->input($value)){
                $product->$value = $request->input($value);
            }
        }
        $product->save();
        return response()->json(['code'=>0, 'msg'=>'success'], 200);
    }

    public function delete($id)
    {
        $product = $this->product->query()->find($id);
        if (!$product) {
            return response()->json(['code'=>0, 'msg'=>'not found'], 200);
        }

        $product->delete();
        return response()->json(['code'=>0, 'msg'=>'success'], 200);
    }
}
