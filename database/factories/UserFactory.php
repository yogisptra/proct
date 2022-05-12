<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\DigiBase\Utilities\AutoNumber;

class UserFactory extends Factory
{
	use AutoNumber;
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
			//'id'				=> $this->GenerateAutoNumber('users'),
            //'name' 			=> $this->faker->name,
            //'email' 			=> $this->faker->unique()->safeEmail,
			'id'				=> '2020151101001',
			'name' 				=> 'Super Admin',
            'email' 			=> 'superadmin@admin.com',
            'email_verified_at' => now(),
            'password' 			=> '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
			'phone_number'     	=> $this->faker->phoneNumber,
			'address'			=> $this->faker->address,
			'enabled'			=> 1,
            'remember_token' 	=> Str::random(10),
        ];
    }
}
