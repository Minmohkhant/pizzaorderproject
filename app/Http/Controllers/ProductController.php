<?php

namespace App\Http\Controllers;


use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    //product list
    public function list(){
        $pizzas = Product::select('products.*','categories.name as category_name')
                ->when(request('key'),function($query){
                $query->where('products.name','like','%'. request('key') .'%');
                })
                ->leftJoin('categories','products.category_id','categories.id')
                ->orderBy('products.created_at','desc')
                ->paginate(3);
        $pizzas -> appends(request()->all());
        return view('admin.products.pizzaList',compact('pizzas'));
    }

    //direct pizza create page
    public function createPage(){
        $categories = Category::select('id','name')->get();
        return view('admin.products.create',compact('categories'));
    }

     //create product
     public function create(Request $request){
        $this->productValidationCheck($request,"create");
        $data = $this->requestProductInfo($request);

            $fileName = uniqid() . $request->file('pizzaImage')->getClientOriginalName();
            $request->file('pizzaImage')->storeAs('public',$fileName);
            $data['image'] = $fileName;


        Product::create($data);
        return redirect()->route('product#list');
    }

    //delete pizza
    public function delete($id){
        Product::where('id',$id)->delete();
        return redirect()->route('product#list')->with(['deleteSuccess' => 'Pizza Delete Success...']);
    }

    //edit pizza
    public function edit($id){
        $pizza = Product::select('products.*','categories.name as category_name')
                        ->leftJoin('categories','products.category_id','categories.id')
                        ->where('products.id',$id)->first();
        return view('admin.products.edit',compact('pizza'));
    }

    //update pizza page
    public function updatePage($id){
        $pizza = Product::where('id',$id)->first();
        $category = Category::get();
        return view('admin.products.update',compact('pizza','category'));
    }

    //pizza update
    public function update(Request $request){
        $this->productValidationCheck($request,"update");
        $data = $this->requestProductInfo($request);


        if($request->hasFile('pizzaImage')){
            $oldImageName = Product::where('id',$request->pizzaId)->first();
            $oldImageName = $oldImageName->image;

            if($oldImageName != null){
                Storage::delete('public/' .$oldImageName);
            }

            $fileName = uniqid() . $request->file('pizzaImage')->getClientOriginalName();
            $request->file('pizzaImage')->storeAs('public',$fileName);
            $data['image'] = $fileName;
        }

        Product::where('id',$request->pizzaId)->update($data);
        return redirect()->route('product#list');
    }

    //request product info
    private function requestProductInfo($request){
        return [
            'category_id' => $request->pizzaCategory,
            'name' => $request->pizzaName,
            'description' => $request->pizzaDescription,
            'price' => $request->pizzaPrice,
            'waiting_time' => $request->pizzaWaitingTime
        ];
    }

    //product validation check
    private function productValidationCheck($request,$action){
        $validationRules =[
            'pizzaName' =>'required|min:5|unique:products,name,' .$request->pizzaId ,
            'pizzaCategory' =>'required',
            'pizzaDescription' =>'required|min:10',
            'pizzaPrice' =>'required',
            'pizzaWaitingTime' =>'required'
        ];

        $validationRules['pizzaImage'] = $action == "create" ? 'required|mimes:jpg,png,jpeg|file' : "mimes:jpg,png,jpeg|file";

        Validator::make($request->all(),$validationRules)->validate();
    }
}
