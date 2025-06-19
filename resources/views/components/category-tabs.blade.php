<ul class="flex flex-wrap justify-center text-sm text-gray-500">
    <li class="me-2">
        <a href="#" class="px-4 py-3 bg-blue-600 text-white rounded-lg active">
            All
        </a>
    </li>
    @foreach ($categories as $category)
        <li class="me-2">
            <a href="#" class="px-4 py-3 rounded-lg hover:bg-gray-100">
                {{ $category->name }}
            </a>
        </li>
    @endforeach
</ul>