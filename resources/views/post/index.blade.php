<x-app-layout> {{-- Folosește layout-ul global definit de Laravel Breeze --}}
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <x-category-tabs>
                        No Categories
                    </x-category-tabs>
                </div>
            </div>

            {{-- Afișare postări --}}
            <div class="mt-8">
                @forelse ($posts as $p)
                    <x-post-item :post="$p" />
                @empty
                    <div class="text-center text-gray-400 py-16">
                        No posts yet
                    </div>
                @endforelse
            </div>

            {{-- Paginație --}}
            {{ $posts->onEachSide(1)->links() }}

        </div>
    </div>
</x-app-layout>


{{-- Componenta <x-post-item> afișează fiecare postare individual, evitând duplicarea HTML.

    Variabila $posts vine din controller și e paginată (paginate()).

    Blade @forelse oferă fallback automat („No posts yet”).

    Meniul de categorii se generează din $categories și poate fi legat ulterior la filtrare prin URL.

    onEachSide(1) arată 1 pagină înainte și 1 după pagina curentă în pagination. --}}