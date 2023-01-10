<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\Division::factory()->create([
            'name' => 'Examiner',
        ]);

        \App\Models\Employee::factory()->create([
            'email' => 'alice@email.com',
            'first_name' => 'Alice',
            'last_name' => 'Margatroid',
            'position' => 'Division Head',
            'is_division_head' => true,
            'division_id' => 1,
            'password' => Hash::make('aaa'),
        ]);

        \App\Models\Employee::factory()->create([
            'email' => 'reisen@email.com',
            'first_name' => 'Reisen',
            'last_name' => 'Inaba',
            'position' => 'Admin',
            'is_admin' => true,
            'division_id' => 1,
            'password' => Hash::make('aaa'),
        ]);

        \App\Models\Employee::factory()->create([
            'email' => 'marisa@email.com',
            'first_name' => 'Marisa',
            'last_name' => 'Kirisame',
            'position' => 'Examiner Agent',
            'division_id' => 1,
            'password' => Hash::make('aaa'),
        ]);

        \App\Models\TimeIn::factory()->create([
            "employee_id" => 3,
            "shift_date" => "2023-01-01",
            "time_in" => "00:00:00",
            "isLate" => true,
        ]);

        \App\Models\TimeIn::factory()->create([
            "employee_id" => 3,
            "shift_date" => "2023-01-04",
            "time_in" => "00:00:00",
            "isLate" => true,
        ]);

        \App\Models\TimeIn::factory()->create([
            "employee_id" => 3,
            "shift_date" => "2023-01-09",
            "time_in" => "00:00:00",
            "isLate" => true,
        ]);

        \App\Models\TimeOut::factory()->create([
            "employee_id" => 3,
            "time_in_id" => 1,
            "shift_date" => "2023-01-01",
            "time_out" => "00:00:00",
        
        ]);

        \App\Models\TimeOut::factory()->create([
            "employee_id" => 3,
            "time_in_id" => 2,
            "shift_date" => "2023-01-04",
            "time_out" => "04:00:00",
            
        ]);

        \App\Models\TimeOut::factory()->create([
            "employee_id" => 3,
            "time_in_id" => 3,
            "shift_date" => "2023-01-09",
            "time_out" => "09:00:00",
        ]);
    }
}
