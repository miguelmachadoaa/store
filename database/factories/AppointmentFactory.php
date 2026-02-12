<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppointmentFactory extends Factory
{
    protected $model = Appointment::class;

    public function definition(): array
    {
        $date = $this->faker->dateTimeBetween('now', '+30 days');
        $status = $this->faker->randomElement(['pending', 'confirmed', 'completed', 'cancelled']);

        $data = [
            'user_id' => $this->faker->optional(0.6)->randomElement(User::where('role', 'customer')->pluck('id')->toArray()),
            'service_id' => $this->faker->optional(0.7)->randomElement(Service::pluck('id')->toArray()),
            'customer_name' => $this->faker->name(),
            'customer_email' => $this->faker->safeEmail(),
            'customer_phone' => $this->faker->numerify('04##-#######'),
            'appointment_date' => $date->format('Y-m-d'),
            'appointment_time' => $this->faker->time('H:i'),
            'status' => $status,
            'customer_notes' => $this->faker->optional(0.5)->sentence(10),
            'admin_notes' => $this->faker->optional(0.3)->sentence(8),
        ];

        // Set status timestamps based on status
        if ($status === 'confirmed') {
            $data['confirmed_at'] = $this->faker->dateTimeBetween('-7 days', 'now');
        } elseif ($status === 'completed') {
            $data['confirmed_at'] = $this->faker->dateTimeBetween('-14 days', '-7 days');
            $data['completed_at'] = $this->faker->dateTimeBetween('-7 days', 'now');
        } elseif ($status === 'cancelled') {
            $data['cancelled_at'] = $this->faker->dateTimeBetween('-7 days', 'now');
        }

        return $data;
    }

    public function pending()
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
            'confirmed_at' => null,
            'completed_at' => null,
            'cancelled_at' => null,
        ]);
    }

    public function confirmed()
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'confirmed',
            'confirmed_at' => now(),
            'completed_at' => null,
            'cancelled_at' => null,
        ]);
    }

    public function completed()
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
            'confirmed_at' => now()->subDays(7),
            'completed_at' => now(),
            'cancelled_at' => null,
        ]);
    }

    public function cancelled()
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'cancelled',
            'confirmed_at' => null,
            'completed_at' => null,
            'cancelled_at' => now(),
        ]);
    }
}
