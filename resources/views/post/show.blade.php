<x-app-layout> {{-- Folosește layout-ul global definit de Laravel Breeze --}}
    <div class="py-4">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg px-8">
                <h1 class="text-2xl font-bold mb-4">
                    {{ $post->title }}
                </h1>

                <!--User Avatar -->
                <div class="flex gap-4">
                    <x-user-avatar :user = "$post->user" />


                    <div>
                        <div class="flex gap-2">
                            <a href="{{ route('profile.show', $post->user) }}" class="hover:underline">
                                {{ $post->user->name }}
                            </a>
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