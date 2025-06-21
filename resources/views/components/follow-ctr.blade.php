@props(['user']) 
{{-- Primește ca prop un obiect User (folosit în componentă Blade personalizată) --}}

<div 
    {{ $attributes }} {{-- Permite adăugarea de atribute HTML externe (ex: class, id etc.) --}}

    x-data="{ 
        following: {{ $user->isFollowedBy(auth()->user()) ? 'true' : 'false' }}, 
        {{-- Inițializează starea de follow/unfollow (true dacă userul curent îl urmărește pe acest $user) --}}
        
        followersCount: {{ $user->followers()->count() }}, 
        {{-- Numărul inițial de followers, obținut cu Eloquent (count pe relația followers) --}}

        follow() {
            axios.post('/follow/{{ $user->id }}') 
            {{-- Trimite un POST request AJAX către backend pentru toggle follow/unfollow --}}

                .then(res => {
                    this.following = !this.following 
                    {{-- Inversează starea locală (true ↔ false) --}}

                    this.followersCount = res.data.followersCount 
                    {{-- Actualizează numărul de followers în timp real din răspunsul JSON --}}

                })

                .catch(err => {
                    console.log(err) 
                    {{-- Dacă apare o eroare (ex: 403), o afișează în consolă --}}
                })
        }
    }"

    class="w-[320px] border-l px-8"
    {{-- Stil Tailwind: lățime fixă 320px, border stânga, padding pe axa X --}}
>
    {{ $slot }}
    {{-- Slot Blade: permite inserarea de conținut HTML între <x-nume-compon></x-nume-compon> --}}
</div>
