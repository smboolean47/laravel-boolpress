<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;
use App\Category;
use App\Tag;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    protected $validationRule = [
        "title" => "required|string|max:100",
        "content" => "required",
        "published" => "sometimes|accepted",
        "category_id" => "nullable|exists:categories,id",
        "image" => "nullable|image|mimes:jpeg,bmp,png|max:2048",
        "tags" => "nullable|exists:tags,id"
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();

        return view("admin.posts.index", compact("posts"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();

        return view("admin.posts.create", compact("categories", "tags"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validazione dei dati
        $request->validate($this->validationRule);
        // creazione del post
        $data = $request->all();

        $newPost = new Post();
        $newPost->fill($data);

        $newPost->published = isset($data["published"]);
       
        $newPost->slug = $this->getSlug($newPost->title);

        // salvo l'immagine se è presente
        if( isset($data['image']) ) {
            $path_image = Storage::put("uploads", $data['image']); // uploads/dklskdlasdklsa.jpg
            $newPost->image = $path_image;
        }

        $newPost->save();

        if ( isset($data["tags"]) ) {
            $newPost->tags()->sync($data["tags"]);
        }
        // redirect al post appena creato
        return redirect()->route("posts.show", $newPost->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view("admin.posts.show", compact("post"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $categories = Category::all();
        $tags = Tag::all();

        return view("admin.posts.edit", compact("post", "categories", "tags"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        // validazione dei dati
        $request->validate($this->validationRule);
        
        // aggiorno il post
        $data = $request->all();

        // se cambia il titolo aggiorno lo slug

        if( $post->title != $data['title'] ) {
            $post->title = $data["title"];

            $slug = Str::of($post->title)->slug("-");

            // se lo slug generato è diverso dallo slug attualmente salvato nel db
            if($slug != $post->slug) {
                $post->slug = $this->getSlug($post->title);
            }
        }

        $post->fill($data);
        $post->published = isset($data["published"]);

        // salvo l'immagine se è presente e cancello la vecchia immagine
        if( isset($data['image']) ) {
            // cancello l'immagine
            Storage::delete($post->image);
            // salvo la nuova immagine
            $path_image = Storage::put("uploads", $data['image']);
            $post->image = $path_image;
        }

        $post->save();

        if ( isset($data["tags"]) ) {
            $post->tags()->sync($data["tags"]);
        }

        // redirect al post modificato
        return redirect()->route("posts.show", $post->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if($post->image) {
            // cancello l'immagine
            Storage::delete($post->image);
        }
        
        $post->delete();

        return redirect()->route("posts.index");
    }
    
    /**
     * Generate an unique slug
     *
     * @param  string $title
     * @return string
     */
    private function getSlug($title)
    {
        $slug = Str::of($title)->slug("-");
        $count = 1;

        // Prendi il primo post il cui slug è uguale a $slug
        // se è presente allora genero un nuovo slug aggiungendo -$count
        while( Post::where("slug", $slug)->first() ) {
            $slug = Str::of($title)->slug("-") . "-{$count}";
            $count++;
        }

        return $slug;
    }
}
