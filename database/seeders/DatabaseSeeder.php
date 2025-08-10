<?php

namespace Database\Seeders;

use App\Enum\PaymentMethod;
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


        $id_user = DB::table('users')->insertGetId([
            'fio' => fake()->name(),
            'year_birth' => rand(1970, 2005),
            'phone' => fake()->numberBetween(10000000000,99999999999),
            'email' => 'user@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'a',
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $id_admin = DB::table('users')->insertGetId([
            'fio' => fake()->name(),
            'year_birth' => rand(1970, 2005),
            'phone' => fake()->numberBetween(10000000000,99999999999),
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'm',
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Users
        $userIds = [$id_user, $id_admin];
        foreach (range(1, 300) as $i) {
            $role = $roles[array_rand($roles)];
            $id = DB::table('users')->insertGetId([
                'fio' => fake()->name(),
                'year_birth' => rand(1970, 2005),
                'phone' => fake()->numberBetween(10000000000,99999999999),
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
        $managers = User::query()->where('role', 'e')->get();
        foreach (range(1, 10) as $i) {
            $name = Str::limit(fake()->unique()->company(), 30, '');
            $slug = Str::slug($name)."-".Str::random(6);
            $id = DB::table('restaurants')->insertGetId([
                'name' => $name,
                'user_id' => $managers->random()->id,
                'slug' => Str::limit($slug, 30, ''),
                'description' => fake()->text(100),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $restaurantIds[] = $id;
        }
        print_r("Restaurants ok\n");

        $positions = [
            'Официант',
            'Бармен',
            'Повар',
            'Су-шеф',
            'Хостес',
            'Администратор зала',
            'Кассир',
        ];

        // Positions
        $positionIds = [];
        foreach ($restaurantIds as $restaurantId) {
            foreach (range(1, rand(1,10)) as $i) {
                $userIds = $this->userIdsWithoutPosition();
                $name = fake()->randomElement($positions);
                $slug = Str::slug($name)."-".Str::random(6);
                $id = DB::table('positions')->insertGetId([
                    'name' => $name,
                    'payment_amount' => rand(5000, 10000),
                    'payment_method' => fake()->randomElement(PaymentMethod::values()),
                    'description' => fake()->text(100),
                    'slug' => $slug,
                    'user_id' => fake()->boolean() ? $userIds[array_rand($userIds)] : null,
                    'order' => rand(0, 10),
                    'restaurants_id' => $restaurantId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $positionIds[] = $id;
            }
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
                'user_id' => $userIds[array_rand($userIds)],
            ]);
        }
        print_r("Events ok\n");

//        // Log
//        foreach (range(1, 2000) as $i) {
//            DB::table('logs')->insert([
//                'positions_id' => $positionIds[array_rand($positionIds)],
//                'date_add' => now()->subDays(rand(1, 30)),
//                'title' => fake()->sentence(3),
//                'admin_id' => $userIds[array_rand($userIds)],
//                'created_at' => now(),
//                'updated_at' => now(),
//            ]);
//        }
//        print_r("Log ok\n");


    }

    function userIdsWithoutPosition()
    {
        return User::query()
            ->leftJoin('positions', 'users.id', '=', 'positions.user_id')
            ->whereNull('positions.id')
            ->pluck('users.id')->toArray();
    }
}
