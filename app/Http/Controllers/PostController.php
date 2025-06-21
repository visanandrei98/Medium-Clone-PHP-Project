<?php // Deschide fișierul PHP

namespace App\Http\Controllers; // Namespace PSR-4 → App\Http\Controllers

use App\Http\Requests\PostCreateRequest; // FormRequest pt. validarea la “store”
use App\Http\Requests\PostUpdateRequest; // FormRequest pt. validarea la “update”
use App\Models\Post;                     // Model Eloquent “posts”
use App\Models\Category;                 // Model Eloquent “categories”
use Illuminate\Http\Request;             // Request generic (nu-l folosim direct aici)
use Illuminate\Support\Facades\Auth;     // Facade pentru autentificare
use Illuminate\Support\Str;              // Helper stringuri (nu e folosit aici)

class PostController extends Controller // Controller resource pentru articole
{
    /**
     * Afișează lista de articole (feed).
     */
    public function index() // Route: GET / (alias “dashboard”)
    {
        $user  = auth()->user(); // Obține user logat (sau null dacă guest)

        $query = Post::with(['user', 'media'])   // eager-load relațiile “user” & “media”
                    ->where('published_at', '<=', now()) // doar articole publicate
                    ->withCount('claps')        // adaugă coloana virtuală claps_count
                    ->latest();                 // ORDER BY created_at DESC

        if ($user) {                            // Dacă e logat…
            $ids = $user->following()->pluck('users.id') // toți urmații
                    ->push($user->id)           // + propriul ID
                    ->unique();                // elimină duplicate
            $query->whereIn('user_id', $ids);   // filtrează feed-ul
        }

        $posts = $query->simplePaginate(5);     // paginare simplă (fără count total)

        return view('post.index', [
            'posts' => $posts]); // returnează Blade view
    }

    /**
     * Formular creare articol.
     */
    public function create() // Route: GET /posts/create
    {
        $categories = Category::get();          // fetch toate categoriile
        
        return view('post.create', [            // trimite categorii spre view
            'categories' => $categories,
        ]);
    }

    /**
     * Salvează articol nou.
     */
    public function store(PostCreateRequest $request) // Route: POST /posts
    {
        $data = $request->validated();          // date curate după rules din FormRequest
        $data['user_id']      = Auth::id();     // atribuie autorul
        $data['published_at'] = now();          // publică imediat

        $post = Post::create($data);            // INSERT în DB

        $post->addMediaFromRequest('image')     // Spatie MediaLibrary – upload fișier
            ->toMediaCollection();              // salvează în collection default

        return redirect()->route('dashboard');  // redirect la feed
    }

    /**
     * Afișează articolul individual.
     */
    public function show(string $username, Post $post) // Route: GET /@user/{post}
    {
        return view('post.show', [              // View detaliu
            'post' => $post,
        ]);
    }

    /**
     * Formular editare articol.
     */
    public function edit(Post $post) // Route: GET /posts/{post}/edit
    {
        if ($post->user_id !== Auth::id()) {    // Protecție: doar autorul editează
            abort(403);                         // HTTP 403 Forbidden
        }
        $categories = Category::get();          // categorii pt. dropdown
        return view('post.edit', [              // trimite date spre view
            'post' => $post,
            'categories' => $categories,
        ]);
    }

    /**
     * Actualizează articolul.
     */
    public function update(PostUpdateRequest $request, Post $post) // PUT /posts/{post}
    {
        if ($post->user_id !== Auth::id()) {    // securitate autor
            abort(403);
        }
        $data = $request->validated();          // rules din PostUpdateRequest

        $post->update($data);                   // UPDATE în DB

        if ($data['image'] ?? false) {          // dacă vine imagine nouă…
            $post->addMediaFromRequest('image') // upload + attach
                ->toMediaCollection();
        }

        return redirect()->route('myPosts');    // redirect la lista proprie
    }

    /**
     * Șterge articolul.
     */
    public function destroy(Post $post) // DELETE /posts/{post}
    {
        if ($post->user_id !== Auth::id()) {    // numai autorul poate șterge
            abort(403);
        }
        $post->delete();                        // soft/hard delete (în funcție de model)

        return redirect()->route('dashboard');  // back la feed
    }

    /**
     * Feed filtrat pe categorie.
     */
    public function category(Category $category) // Route: GET /category/{category}
    {
        $user  = auth()->user();                // user curent sau null

        $query = $category->posts()             // posts() = relație în Model Category
                        ->where('published_at', '<=', now()) // doar publicate
                        ->with(['user', 'media']) // eager-load
                        ->withCount('claps')      // counter
                        ->latest();               // sort desc

        if ($user) {                             // filtre feed ca în index()
            $ids = $user->following()->pluck('users.id')
                    ->push($user->id)
                    ->unique();
            $query->whereIn('user_id', $ids);
        }

        $posts = $query->simplePaginate(5);     // paginare

        return view('post.index', ['posts' => $posts]); // aceeași view reutilizată
    }

    /**
     * Lista articolelor mele.
     */
    public function myPosts() // Route: GET /my-posts
    {
        $user = auth()->user();                 // user curent
        $posts = $user->posts()                 // relație “posts” pe Model User
            ->with(['user', 'media'])           // eager-load
            ->withCount('claps')                // counter
            ->latest()                          // sort desc
            ->simplePaginate(5);                // paginare

        return view('post.index', [             // reuse view index
            'posts' => $posts,
        ]);
    }
}
