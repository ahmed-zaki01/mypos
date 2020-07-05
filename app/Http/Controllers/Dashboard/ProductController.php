<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Cat;
use App\Product;
use App\ProductTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:read_products'])->only('index');
        $this->middleware(['permission:create_products'])->only('create');
        $this->middleware(['permission:update_products'])->only('edit');
        $this->middleware(['permission:delete_products'])->only('destroy');
    } // end of construct

    public function index(Request $request)
    {

        $cats = Cat::all();

        $products = Product::when($request->search, function ($q) use ($request) {
            return $q->whereTranslationLike('name', '%' . $request->search . '%');
        })->when($request->cat_id, function ($q) use ($request) {
            return $q->where('cat_id', $request->cat_id);
        })->latest()->paginate(5);

        //$products = Product::latest()->paginate(2);

        return view('dashboard.products.index', compact(['cats', 'products']));
    } // end of index


    public function create()
    {
        $cats = Cat::all();
        return view('dashboard.products.create', compact('cats'));
    } // end of create


    public function store(Request $request)
    {
        //dd($request->all());

        $rules = ['cat_id' => 'required|exists:cats,id'];

        foreach (config('translatable.locales') as $locale) {
            $rules += [$locale . '.name' => 'required|string|max:80|unique:product_translations,name'];
            $rules += [$locale . '.desc' => 'required|string'];
        }

        $rules += [
            'img' => 'required|image|mimes:jpg,png,jpeg',
            'purchase_price' => 'required|numeric',
            'sell_price' => 'required|numeric',
            'stock' => 'required|integer',
        ];

        $data = $request->validate($rules);

        $imgNewName = $data['img']->hashName();
        \Image::make($data['img'])->resize(100, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save(public_path('uploads/products/' . $imgNewName));

        $data['img'] = $imgNewName;

        //dd($data);
        Product::create($data);
        session()->flash('status', 'Product added successfully!');
        return redirect(route('dashboard.products.index'));
    } // end of store

    public function edit(Product $product)
    {

        // dd($product);

        $cats = Cat::all();
        return view('dashboard.products.edit', compact(['cats', 'product']));
    } // end of edit


    public function update(Request $request, Product $product)
    {
        $rules = ['cat_id' => 'required|exists:cats,id'];

        foreach (config('translatable.locales') as $locale) {
            $rules += [$locale . '.name' => ['required', 'string', 'max:80', Rule::unique('product_translations', 'name')->ignore($product->id, 'product_id')]];

            $rules += [$locale . '.desc' => 'required|string'];
        }

        $rules += [
            'img' => 'nullable|image|mimes:jpg,png,jpeg',
            'purchase_price' => 'required|numeric',
            'sell_price' => 'required|numeric',
            'stock' => 'required|integer',
        ];

        $data = $request->validate($rules);

        //dd($data);

        if ($data['img']) {
            // check to delete old image from products folder except default.png
            if ($product->img !== 'default.png') {
                Storage::disk('uploads')->delete('products/' . $product->img);
            }

            $imgNewName = $data['img']->hashName();
            \Image::make($data['img'])->resize(100, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/products/' . $imgNewName));

            $data['img'] = $imgNewName;
        } // end of product img condition

        // $data['img'] = 'default.png';
        $product->update($data);

        session()->flash('status', 'Product has been updated successfully!');
        return redirect(route('dashboard.products.index'));
    } // end of update


    public function destroy(Product $product)
    {
        // check to delete old image from products folder except default.png
        if ($product->img !== 'default.png') {
            Storage::disk('uploads')->delete('products/' . $product->img);
        }


        $product->delete();
        session()->flash('status', 'Product has been deleted successfully!');
        return redirect(route('dashboard.products.index'));
    } // end of destroy
}
