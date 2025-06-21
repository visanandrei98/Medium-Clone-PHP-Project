<x-app-layout> {{-- Layout principal definit în App\View\Components\AppLayout --}}

    <div class="py-4"> {{-- Padding vertical (Tailwind: padding-top/bottom 1rem) --}}
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8"> {{-- Container central cu lățime maximă și padding pe ecrane mari --}}
        
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg"> {{-- Card alb cu umbră și colțuri rotunjite --}}
                <div class="p-4 text-gray-900"> {{-- Padding + text gri închis --}}
                    
                    <x-category-tabs> {{-- Componentă custom Blade pentru taburi categorie --}}
                        No Categories {{-- Text fallback afișat dacă nu sunt categorii --}}
                    </x-category-tabs>

                </div>
            </div>

            <div class="mt-8 text-gray-900"> {{-- Margine sus + culoare text pentru secțiunea cu postările --}}
                
                @forelse ($posts as $p) {{-- Dacă există postări în $posts, le parcurge --}}
                    <x-post-item :post="$p"></x-post-item> {{-- Afișează fiecare postare folosind componenta post-item --}}
                @empty {{-- Dacă NU există postări… --}}
                    <div class="text-center text-gray-400 py-16">No Posts Found</div> {{-- Afișează mesaj fallback --}}
                @endforelse

            </div>

            {{ $posts->links() }} {{-- Afișează link-urile de paginare generate de Laravel pentru colecția $posts --}}
        
        </div>
    </div>

</x-app-layout> {{-- Închide layout-ul principal --}}
