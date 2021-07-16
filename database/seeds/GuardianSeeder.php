<?php

use Illuminate\Database\Seeder;
use App\Guardian;

class GuardianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Guardian::insert([
            [
                'name' => 'Juan Dela Cruz', 
                'contact_number' => '0967 241 0001',
                'email' => 'heyimi6730@ovooovo.com'
            ],
            [
                'name' => 'Michael S. McDonald', 
                'contact_number' => '207-885-6388',
                'email' => 'MichaelSMcDonald@rhyta.com'
            ],
            [
                'name' => 'Daniel L. Schiavo', 
                'contact_number' => '740-315-1875',
                'email' => 'DanielLSchiavo@armyspy.com'
            ],
            [
                'name' => 'Janet R. Gilbert', 
                'contact_number' => '503-579-5066',
                'email' => 'JanetRGilbert@dayrep.com'
            ],
            [
                'name' => 'Erin A. Miller', 
                'contact_number' => '530-661-5575',
                'email' => 'ErinAMiller@armyspy.com'
            ],
        ]);
    }
}
