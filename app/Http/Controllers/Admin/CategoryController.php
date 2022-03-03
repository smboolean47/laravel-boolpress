<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();

        return view("admin.categories.index", compact("categories"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.categories.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validazione
        $request->validate([
            "name" => "required|string|max:255|unique:categories,name"
        ]);

        $data = $request->all();

        // creo la categoria
        $newCategory = new Category();
        $newCategory->name = $data["name"];
        $newCategory->slug = Str::of($newCategory->name)->slug("-");
        $newCategory->save();

        // redirect alla show della categoria creata
        return redirect()->route("categories.show", $newCategory->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return view("admin.categories.show", compact("category"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view("admin.categories.edit", compact("category"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        // validazione
        $request->validate([
            "name" => "required|string|max:255|unique:categories,name,{$category->id}"
        ]);

        $data = $request->all();

        // modifico la categoria
        $category->name = $data["name"];
        $category->slug = Str::of($category->name)->slug("-");
        $category->save();

        // redirect alla show della categoria modificata
        return redirect()->route("categories.show", $category->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();

        // redirect alla index delle categorie
        return redirect()->route("categories.index");
    }
}
