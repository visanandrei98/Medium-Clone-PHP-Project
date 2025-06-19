<?php

namespace Database\Seeders; // 📦 Declară namespace-ul unde se află acest seeder (face parte din seeders oficiale)

use App\Models\User;
use App\Models\Category; // 📥 Importă modelul Category pentru a putea insera în tabela 'categories'
use App\Models\Post;     // 📥 Importă modelul Post pentru a crea postări cu factory
use Illuminate\Support\Facades\Hash;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents; // ❌ (opțional) se poate folosi pentru seedere fără evenimente model

use Illuminate\Database\Seeder; // 📥 Extinde clasa Seeder Laravel – oferă metoda run()

class DatabaseSeeder extends Seeder // 🧱 Seeder-ul principal al aplicației (cheamă toți ceilalți seederi)
{
    /**
     * Seed the application's database.
     */
    public function run(): void // 🚀 Metoda care rulează automat când dai php artisan db:seed
    {
        User::factory()->create([
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]); //Pentru a evita eorri de tipul: "Eloquent: No primary key defined on model App\Models\User" se creeaza un user cu datele de mai sus
       $categories = [
        'Tehnology',
        'Health',
        'Science',
        'Sports',
        'Politics',
        'Entertainment',
       ]; // 📝 Declară un array simplu cu 6 nume de categorii (folosit mai jos în foreach)

       foreach($categories as $category){ // 🔁 Iterează prin fiecare categorie din array
        Category::create([
            'name' => $category,
        ]); // 🧱 Creează un rând în tabela 'categories' cu numele respectiv
       }
    //    Post::factory(100)->create(); 
       // 🏭 Apelează PostFactory de 100 de ori pentru a genera 100 de postări false
       // 📎 Fiecare post primește o categorie random din cele 6 create mai sus (prin category_id în factory)
       // ⚠️ user_id e hardcodat (1) — se poate schimba ulterior cu user random
    }
}

//Expliatii!!!
// 🧪 Acest seeder pregătește baza de date cu date false de test pentru dezvoltare:
// 1. Creează 6 categorii fixe în tabela 'categories' (ex: 'Technology', 'Health' etc.)
// 2. Generează 100 de postări false cu ajutorul unui factory (PostFactory):
//    – Factory-ul definește *cum arată* o postare (titlu, conținut, imagine, etc.)
//    – Seeder-ul decide *câte postări* să creeze și le salvează efectiv în baza de date
//    – Fiecare postare primește:
//       • un category_id ales aleator dintre cele 6 categorii create mai sus
//       • un user_id fix (1) — poate fi înlocuit ulterior cu un user random generat prin UserFactory
// 🧠 Relația: Factory = rețeta pentru un model fals | Seeder = execută și salvează datele în DB
// ⚠️ Ordinea e importantă: întâi se creează categoriile, apoi postările (altfel factory-ul eșuează)
