<?php

namespace Database\Factories;

use App\Models\Firm;
use Illuminate\Database\Eloquent\Factories\Factory;

class FirmFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Firm::class;

    protected $bank_name = ['PrivatBank', 'UkrEximBank', 'MonoBank'];
    protected $carr_name = ['NovaPoshta', 'MeestExpress', 'DHL'];
    protected $taxes = [
        'платник  податку на прибуток на  загальних  підставах',
        'платник єдиного податку з ПДВ',
        'платник єдиного податку без ПДВ',
    ];

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'firm_name' => $this->faker->company,
            'firm_name_short' => $this->faker->company,
            'boss_position' => 'Director',
            'boss_pib' => $this->faker->name,
            'work_position' => 'Manager',
            'work_pib' => $this->faker->name,
            'addr_zip_ur' => $this->faker->numberBetween($min = 10000, $max = 99999),
            'addr_obl_ur' => $this->faker->state,
            'addr_city_ur' => $this->faker->city,
            'addr_street_ur' => $this->faker->streetName,
            'addr_house_ur' => $this->faker->buildingNumber,
            'addr_office_ur' => $this->faker->buildingNumber,
            'addr_zip_fact' => $this->faker->numberBetween($min = 10000, $max = 99999),
            'addr_obl_fact' => $this->faker->state,
            'addr_city_fact' => $this->faker->city,
            'addr_street_fact' => $this->faker->streetName,
            'addr_house_fact' => $this->faker->buildingNumber,
            'addr_office_fact' => $this->faker->buildingNumber,
            'edrpou' => $this->faker->numberBetween($min = 10000000, $max = 99999999),
            'ipn' => $this->faker->numberBetween($min = 1000000000, $max = 9999999999),
            'tax' => $this->taxes[array_rand($this->taxes)],
            'account_number' => $this->faker->iban('UA'),
            'bank_name' => $this->bank_name[array_rand($this->bank_name)],
            'bank_mfo' => $this->faker->numberBetween($min = 100000, $max = 999999),
            'phone_shared' => $this->faker->e164PhoneNumber,
            'email_shared' => $this->faker->unique()->safeEmail,
            'phone_acc' => $this->faker->e164PhoneNumber,
            'email_acc' => $this->faker->unique()->safeEmail,
            'phone_work' => $this->faker->e164PhoneNumber,
            'email_work' => $this->faker->unique()->safeEmail,
            'carr_name' => $this->carr_name[array_rand($this->carr_name)],
            'carr_city' => $this->faker->city,
            'carr_dep' => $this->faker->numberBetween($min = 1, $max = 100),
            'carr_pib' => $this->faker->name,
            'carr_phone' => $this->faker->e164PhoneNumber,
            'note' => $this->faker->realText(50, 1),
        ];
    }
}
