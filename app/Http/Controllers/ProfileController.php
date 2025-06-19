<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    // Afișează formularul de editare al profilului
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(), // transmite utilizatorul autentificat în view
        ]);
    }

    // Actualizează datele profilului utilizatorului după validare
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // Validează datele și le stochează în $data
        $data = $request->validated();

        // Preia imaginea dacă a fost trimisă
        $image = $data['image'] ?? null;

        // Dacă există imagine, o salvează în folderul public/avatars și actualizează path-ul
        if ($image) {
            $data['image'] = $image->store('avatars', 'public');
        }

        // Completează user-ul logat cu noile date (fără să le salveze încă)
        $request->user()->fill($data);

        // Dacă email-ul s-a schimbat, îl setează ca neverificat
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        // Salvează modificările în DB
        $request->user()->save();

        // Redirecționează înapoi la profil cu mesaj de succes
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    // Șterge contul utilizatorului logat
    public function destroy(Request $request): RedirectResponse
    {
        // Verifică parola curentă pentru confirmarea ștergerii
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        // Ia utilizatorul curent
        $user = $request->user();

        // Deconectează-l
        Auth::logout();

        // Șterge-l din DB
        $user->delete();

        // Resetează sesiunea
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Trimite-l pe homepage
        return Redirect::to('/');
    }
}

// ----------------------------------------------------------------------------------
// Concluzie:
// Acest controller gestionează toate acțiunile legate de profilul unui utilizator:
// - edit()   → afișează formularul de profil cu datele curente
// - update() → validează și actualizează datele, inclusiv imaginea și email-ul
// - destroy() → verifică parola, șterge contul și închide sesiunea
//
// Este parte din fluxul autenticat și folosește validare custom (ProfileUpdateRequest),
// metode Eloquent (fill, save, delete) și protecție CSRF/session pentru acțiuni critice.
//
// Structură RESTful curată, ușor de extins cu extra setări (ex: schimbare parolă).
// ----------------------------------------------------------------------------------
