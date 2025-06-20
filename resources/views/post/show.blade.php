<x-app-layout> {{-- Folosește layout-ul global definit de Laravel Breeze --}}
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg px-8">
                <h1 class="text-2xl font-bold mb-4">
                    {{ $post->title }}
                </h1>

                <!--User Avatar -->
                <div class="flex gap-4">
                    @if($post->user->image)
                        <img src="{{ $post->user->imageUrl()}}" alt="{{ $post->user->name }}"
                            class="w-16 h-16 rounded-full">
                    @else
                        <img src="https://static.everypixel.com/ep-pixabay/0329/8099/0858/84037/3298099085884037069-head.png"
                            alt="Dummy Avatar" class="w-16 h-16 rounded-full">
                    @endif


                    <div>
                        <div>
                            <h3>
                                {{ $post->user->name }}
                            </h3>
                            &middot;
                            <a href="#" class="text-emerald-500">
                                Follow
                            </a>

                        </div>

                        <div class="flex gap-4 text-sm text-gray-600">

                            {{ $post->readTime() }} min read

                            &middot;

                            {{ $post->created_at->format('M d, Y') }}

                        </div>

                    </div>


                </div>
                <!--User Avatar -->

                <!--Clap Section -->
                <x-clap-button />
                <!--Clap Section -->
                
                <!--Content Section -->
                <div class="mt-8">
                    <img src="{{$post->imageUrl()}} " alt="{{ $post->title }}" class="w-full">
                </div>

                <div class="mt-4">
                    {{ $post->content }}
                </div>

                <div class="mt-8 text-gray-600">
                    <span class="px-4 mb-4 inline-block py-2 bg-gray-300 rounded text-black-100 rounded-xl">
                        {{ $post->category->name }}
                    </span>
                </div>

                <!--Clap Section -->
                <x-clap-button />
                <!--Clap Section -->

            </div>
        </div>
    </div>
</x-app-layout>