<?php

namespace Database\Factories; // 📦 Namespace-ul pentru toate clasele Factory

use Illuminate\Database\Eloquent\Factories\Factory; // 📥 Importă clasa de bază pentru orice factory
use App\Models\Category; // 📥 Avem nevoie de modelul Category ca să atribuim category_id valid

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 * 📝 Definește că acest factory este pentru modelul Post (ajută la hinting și IDE-uri)
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed> // 📄 Specifică că returnează un array cu chei string și valori mixte
     */
    public function definition(): array
    {
        $title = fake()->sentence(); // 📝 Generează un titlu fals (ex: „Lorem ipsum dolor sit”)

        return [
            'image' => fake()->imageUrl(), // 🖼️ Imagine falsă (URL random)
            'title' => $title,             // 🏷️ Titlul generat mai sus
            'slug' => \Illuminate\Support\Str::slug($title), // 🌐 Creează un slug SEO-friendly din titlu
            'content' => fake()->paragraph(), // 📃 Generează un paragraf fals
            'category_id' => Category::inRandomOrder()->first()->id, 
            // 🔗 Alege aleator o categorie existentă și îi folosește id-ul (foreign key)
            'user_id' => 1, // 👤 Setează user_id fix (temporar) – trebuie înlocuit ulterior cu user random
            'published_at' => fake()->optional()->dateTime(), 
            // 📅 Generează o dată random de publicare sau NULL
        ];
    }
}


// 🏭 Acest factory definește cum arată o instanță falsă a modelului Post pentru testare și populare DB:
// – Generează automat titlu, imagine, slug, conținut și dată publicare
// – Leagă fiecare postare de o categorie existentă (aleasă aleator cu Category::inRandomOrder())
// – user_id este momentan hardcodat la 1 (recomandat: se generează 10 users cu UserFactory și se alege aleator)
// 🔄 Acest factory este apelat în DatabaseSeeder prin Post::factory(100)->create()
// ➕ Avantaj: generezi rapid zeci/sute de postări de test realiste fără a le scrie manual
