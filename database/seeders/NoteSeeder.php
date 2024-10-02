<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Note; // Zorg ervoor dat het Note-model is aangemaakt

class NoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Maak drie notities aan
        $notes = [
            [
                'title' => 'Boodschappenlijst',
                'description' => 'Zorg ervoor dat ik voldoende groenten en fruit koop.', // Wijzig content naar description
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Vergadering',
                'description' => 'Vergeet niet de vergadering met het team te bevestigen voor vrijdag.', // Wijzig content naar description
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Projectdeadline',
                'description' => 'De deadline voor het project is 15 oktober. Zorg ervoor dat alles op tijd af is.', // Wijzig content naar description
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insert notes in de database
        foreach ($notes as $note) {
            Note::create($note);
        }
    }
}
