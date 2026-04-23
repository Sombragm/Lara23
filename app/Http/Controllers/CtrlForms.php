<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
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

        return redirect()->route('categorias')->with('success', 'Categoria creada correctamente.');
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

        return redirect()->route('categorias')->with('success', 'Categoria actualizada correctamente.');
    }

    public function destroyCategoria($id)
    {
        $category = Category::findOrFail($id);
        try {
            $category->delete();
            return redirect()->route('categorias')->with('success', 'Categoria eliminada correctamente.');
        } catch (QueryException $e) {
            return redirect()
                ->route('categorias')
                ->with('error', 'No se puede eliminar la categoria porque esta enlazada a uno o mas productos.');
        }
    }

    public function Productos(){
        $products = Product::with('category')
            ->orderBy('id', 'asc')
            ->paginate(50)
            ->withQueryString();
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

        return redirect()->route('productos', [
            'page' => $request->input('page', 1),
        ])->with('success', 'Producto creado correctamente.');
    }

    public function editProduct(Request $request, $id)
    {
        $products = Product::with('category')
            ->orderBy('id', 'asc')
            ->paginate(50)
            ->withQueryString();
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

        return redirect()->route('productos', [
            'page' => $request->input('page', 1),
        ])->with('success', 'Producto actualizado correctamente.');
    }

    public function destroyProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('productos', [
            'page' => $request->input('page', 1),
        ])->with('success', 'Producto eliminado correctamente.');
    }
}
