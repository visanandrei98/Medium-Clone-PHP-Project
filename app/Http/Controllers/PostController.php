<?php

namespace App\Http\Controllers; // Spațiul de nume al controllerului – specifică unde e poziționat în structură

use App\Http\Requests\PostCreateRequest;
use App\Models\Post;         // Importă modelul Post (legat de tabela posts)
use App\Models\Category;     // Importă modelul Category (legat de tabela categories)
use Illuminate\Http\Request; // Importă clasa Request – folosită pentru a accesa date din formulare HTTP
use Illuminate\Support\Str; // Importă clasa Str pentru a lucra cu slug-uri
use Illuminate\Support\Facades\Auth;


class PostController extends Controller // Controllerul gestionează toate acțiunile legate de modelul Post
{
    /**
     * Afișează lista de postări (homepage).
     * Se folosește în ruta GET /posts sau /
     */
    public function index()
    {
       
        $posts = Post::orderBy('created_at', 'desc')->paginate(5); // Ia ultimele 5 postări paginate
        return view('post.index', [     // Trimite datele către view-ul index.blade.php(din post folder)
            
            'posts' => $posts
        ]);
    }

    /**
     * Afișează formularul de creare a unei noi postări.
     * Se folosește în ruta GET /posts/create
     */
    public function create()
    {
        $categories = Category::get();
        return view('post.create', [
            'categories' => $categories
        ]); // De obicei aici se returnează view-ul: return view('posts.create');
    }

    /**
     * Stochează o nouă postare în baza de date.
     * Se folosește în ruta POST /posts
     */
    public function store(PostCreateRequest $request)
    {
        $data = $request -> validated();

        $image = $data['image'];
        //unset($data['image']);
        $data['user_id'] = Auth::user()->id;
        $data['slug'] = Str::slug($data['title']);

        $imagePath = $image->store('posts', 'public');
        $data['image'] = $imagePath;

        Post::create($data); // Validează, salvează și redirecționează postarea în DB

        return redirect()->route('dashboard');
    }

    /**
     * Afișează o singură postare individual.
     * Se folosește în ruta GET /posts/{id}
     */
    public function show(Post $post)
    {
        // return view('posts.show', compact('post'));
    }

    /**
     * Afișează formularul de editare pentru o postare.
     * Se folosește în ruta GET /posts/{id}/edit
     */
    public function edit(Post $post)
    {
        // return view('posts.edit', compact('post'));
    }

    /**
     * Actualizează o postare existentă în DB.
     * Se folosește în ruta PUT/PATCH /posts/{id}
     */
    public function update(Request $request, Post $post)
    {
        // Validează și salvează modificările
    }

    /**
     * Șterge o postare din DB.
     * Se folosește în ruta DELETE /posts/{id}
     */
    public function destroy(Post $post)
    {
        // $post->delete(); return redirect()->route('posts.index');
    }
}


/**
 * PostController este un Resource Controller standard în Laravel.
 * Controlează tot fluxul CRUD pentru modelul Post:
 * - index() → listare cu pagination
 * - create()/store() → creare
 * - show() → afișare individuală
 * - edit()/update() → editare
 * - destroy() → ștergere
 * În plus, trimite datele (ex: $posts, $categories) către view-uri Blade pentru afișare curată.
 */
