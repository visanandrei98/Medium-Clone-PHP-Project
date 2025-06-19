<?php

namespace Database\Factories; 
// 📦 Namespace-ul pentru toate factory-urile din Laravel, organizare standard

use Illuminate\Database\Eloquent\Factories\Factory; 
// 📥 Clasa de bază pentru toate factory-urile, oferă metodele de generare

use Illuminate\Support\Facades\Hash; 
// 🔐 Pentru criptarea parolei utilizând bcrypt

use Illuminate\Support\Str; 
// 🧵 Folosit pentru generarea token-urilor aleatorii

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 * 📝 Indică că această clasă este factory pentru modelul User
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password; 
    // 🔒 Proprietate statică pentru a salva o singură dată parola criptată, evitând recalcularea

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed> 
     */
    public function definition(): array
    {
        
        $name = fake()->name();
        return [
            'name' => $name, 
            // 🧑 Nume generat aleator (ex: John Doe)

            'username' => Str::slug($name),
            

            'email' => fake()->unique()->safeEmail(), 
            // 📧 Email unic și valid generat aleator

            'email_verified_at' => now(), 
            // ✅ Data verificării email-ului setată la momentul curent

            'password' => static::$password ??= Hash::make('password'), 
            // 🔐 Parolă criptată (bcrypt) – folosește aceeași valoare statică pentru toate instanțele

            'remember_token' => Str::random(10), 
            // 🔑 Token aleatoriu de 10 caractere pentru "remember me"
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null, 
            // ❌ Modifică starea modelului pentru a seta emailul ne-verificat (null)
        ]);
    }
}

// 🏭 Acest factory generează date false pentru modelul User, utile pentru teste și popularea DB:
// – Generează nume și email-uri unice, valide, folosind Faker (fake())
// – Setează câmpul 'email_verified_at' cu timpul curent, simulând conturi verificate
// – Criptează o parolă standard ('password') o singură dată pentru eficiență și o atribuie tuturor utilizatorilor generați
// – Generează un token aleator pentru "remember me" autentificare
// – Oferă și o metodă auxiliară `unverified()` pentru a crea useri cu email ne-verificat
// 🔄 Este apelat în seedere pentru a popula tabela users cu date realiste de test

