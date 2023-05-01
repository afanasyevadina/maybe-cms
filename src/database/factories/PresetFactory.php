<?php

namespace Altenic\MaybeCms\Database\Factories;

use Altenic\MaybeCms\Models\Preset;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class PresetFactory extends Factory
{
    protected $model = Preset::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => fake()->sentence(2),
        ];
    }
}
