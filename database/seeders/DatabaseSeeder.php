<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
      $countries_path = public_path('sql/countries.sql');
      $countries_sql = file_get_contents($countries_path);
      DB::unprepared($countries_sql);

      $this->call([
        PermissionSeeder::class,
        RoleSeeder::class,
        MenuSeeder::class,
        ProfileCompanySeeder::class,
        MasterDataSeeder::class,
      ]);

		\App\Models\User::factory()->count(1)->create();
    }
}
