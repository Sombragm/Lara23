<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class CtrlForms extends Controller
{
    public function Categorias(){
        $categories = Category::all();
        return view('categories')->with(compact('categories'));
    }

    public function storeCategoria(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
        ]);

        Category::create($data);

        return redirect()->route('categorias');
    }

    public function editCategoria($id)
    {
        $categories = Category::all();
        $categoryToEdit = Category::findOrFail($id);
        return view('categories')->with(compact('categories', 'categoryToEdit'));
    }

    public function updateCategoria(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
        ]);

        $category = Category::findOrFail($id);
        $category->update($data);

        return redirect()->route('categorias');
    }

    public function destroyCategoria($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('categorias');
    }

    public function Productos(){
        $products = Product::all();
        $categories = Category::all();
        return view('products')->with(compact('products', 'categories'));
    }

    public function storeProduct(Request $request)
    {
        $data = $request->validate([
            'name'            => 'required|string|max:255',
            'description'     => 'nullable|string',
            'descriptionLong' => 'nullable|string',
            'price'           => 'required|numeric',
            'category_id'     => 'nullable|exists:categories,id',
        ]);

        if (!empty($data['category_id'])) {
            $cat = Category::find($data['category_id']);
            $data['category_name'] = $cat?->name;
        }

        Product::create($data);

        return redirect()->route('productos');
    }

    public function editProduct($id)
    {
        $products = Product::all();
        $categories = Category::all();
        $productToEdit = Product::findOrFail($id);
        return view('products')->with(compact('products', 'categories', 'productToEdit'));
    }

    public function updateProduct(Request $request, $id)
    {
        $data = $request->validate([
            'name'            => 'required|string|max:255',
            'description'     => 'nullable|string',
            'descriptionLong' => 'nullable|string',
            'price'           => 'required|numeric',
            'category_id'     => 'nullable|exists:categories,id',
        ]);

        if (!empty($data['category_id'])) {
            $cat = Category::find($data['category_id']);
            $data['category_name'] = $cat?->name;
        } else {
            $data['category_name'] = null;
        }

        $product = Product::findOrFail($id);
        $product->update($data);

        return redirect()->route('productos');
    }

    public function destroyProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('productos');
    }
}
