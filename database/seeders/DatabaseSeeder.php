<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Roles
        $roles = ['a', 'e', 'b', 'm'];

        // Users
        $userIds = [];
        foreach (range(1, 25) as $i) {
            $role = $roles[array_rand($roles)];
            $id = DB::table('users')->insertGetId([
                'fio' => fake()->name(),
                'year_birth' => rand(1970, 2005),
                'phone' => fake()->phoneNumber(),
                'email' => fake()->unique()->safeEmail(),
                'password' => Hash::make('password'),
                'role' => $role,
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $userIds[] = $id;
        }

        print_r("Users ok\n");

        // Restaurants
        $restaurantIds = [];
        foreach (range(1, 10) as $i) {
            $name = Str::limit(fake()->unique()->company(), 30, '');
            $slug = Str::slug($name);
            $id = DB::table('restaurants')->insertGetId([
                'name' => $name,
                'slug' => Str::limit($slug, 30, ''),
                'description' => fake()->text(100),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $restaurantIds[] = $id;
        }
        print_r("Restaurants ok\n");

        // Positions
        $positionIds = [];
        foreach (range(1, 300) as $i) {
            $name = fake()->jobTitle();
            $slug = Str::slug($name . '-' . $i);
            $id = DB::table('positions')->insertGetId([
                'name' => $name,
                'price_shifts' => rand(5000, 10000),
                'price_hour' => rand(300, 800),
                'description' => fake()->text(100),
                'slug' => $slug,
                'users_id' => $userIds[array_rand($userIds)],
                'order' => rand(0, 10),
                'restaurants_id' => $restaurantIds[array_rand($restaurantIds)],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $positionIds[] = $id;
        }
        print_r("Positions ok\n");

        // Events
        foreach (range(1, 3000) as $i) {
            $start = Carbon::now()->addDays(rand(-10, 10))->setTime(rand(8, 16), 0);
            $end = (clone $start)->addHours(rand(1, 4));
            DB::table('events')->insert([
                'positions_id' => $positionIds[array_rand($positionIds)],
                'title' => fake()->catchPhrase(),
                'color' => fake()->hexColor(),
                'start_date' => $start,
                'end_date' => $end,
                'status' => rand(0, 1),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        print_r("Events ok\n");

        // Logs
        foreach (range(1, 2000) as $i) {
            DB::table('logs')->insert([
                'positions_id' => $positionIds[array_rand($positionIds)],
                'date_add' => now()->subDays(rand(1, 30)),
                'title' => fake()->sentence(3),
                'admin_id' => $userIds[array_rand($userIds)],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        print_r("Logs ok\n");


    }
}
