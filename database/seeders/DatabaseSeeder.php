<?php

namespace Database\Seeders;

use App\Models\Disposition;
use App\Models\IncomingLetter;
use App\Models\LetterArchive;
use App\Models\OutgoingLetter;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@siadesa.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'position' => 'Kepala Bagian Administrasi',
            'status' => 'active',
        ]);

        // Create village head user
        $villageHead = User::factory()->create([
            'name' => 'Kepala Desa',
            'email' => 'kepaladesa@siadesa.com',
            'password' => Hash::make('password'),
            'role' => 'village_head',
            'position' => 'Kepala Desa',
            'status' => 'active',
        ]);

        // Create staff users
        $staff1 = User::factory()->create([
            'name' => 'Siti Aminah',
            'email' => 'siti@siadesa.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
            'position' => 'Staf Administrasi',
            'status' => 'active',
        ]);

        $staff2 = User::factory()->create([
            'name' => 'Ahmad Rizki',
            'email' => 'ahmad@siadesa.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
            'position' => 'Staf Pelayanan',
            'status' => 'active',
        ]);

        // Create additional users
        User::factory(6)->create();

        // Create incoming letters
        $incomingLetters = IncomingLetter::factory(30)->create([
            'created_by' => fn() => User::inRandomOrder()->first()->id,
        ]);

        // Create outgoing letters
        OutgoingLetter::factory(25)->create([
            'created_by' => fn() => User::inRandomOrder()->first()->id,
        ]);

        // Create dispositions for some incoming letters
        $disposableLetters = $incomingLetters->random(15);
        foreach ($disposableLetters as $letter) {
            Disposition::factory()->create([
                'incoming_letter_id' => $letter->id,
                'assigned_to' => User::inRandomOrder()->first()->id,
                'assigned_by' => User::whereIn('role', ['admin', 'village_head'])->inRandomOrder()->first()->id,
            ]);
            
            // Update letter status to disposed
            $letter->update(['status' => 'disposed']);
        }

        // Create some overdue dispositions
        Disposition::factory(5)->overdue()->create([
            'assigned_to' => fn() => User::inRandomOrder()->first()->id,
            'assigned_by' => fn() => User::whereIn('role', ['admin', 'village_head'])->inRandomOrder()->first()->id,
        ]);

        // Create some completed dispositions
        Disposition::factory(8)->completed()->create([
            'assigned_to' => fn() => User::inRandomOrder()->first()->id,
            'assigned_by' => fn() => User::whereIn('role', ['admin', 'village_head'])->inRandomOrder()->first()->id,
        ]);

        // Create letter archives
        $archivableIncoming = IncomingLetter::where('status', 'processed')->take(10)->get();
        foreach ($archivableIncoming as $letter) {
            LetterArchive::factory()->create([
                'letter_type' => 'incoming',
                'letter_id' => $letter->id,
                'archived_by' => $admin->id,
            ]);
            
            // Update letter status to archived
            $letter->update(['status' => 'archived']);
        }

        $archivableOutgoing = OutgoingLetter::where('status', 'sent')->take(8)->get();
        foreach ($archivableOutgoing as $letter) {
            LetterArchive::factory()->create([
                'letter_type' => 'outgoing',
                'letter_id' => $letter->id,
                'archived_by' => $admin->id,
            ]);
            
            // Update letter status to archived
            $letter->update(['status' => 'archived']);
        }
    }
}