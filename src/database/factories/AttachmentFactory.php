<?php

namespace Altenic\MaybeCms\Database\Factories;

use Altenic\MaybeCms\Models\Attachment;
use Altenic\MaybeCms\Models\Block;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class AttachmentFactory extends Factory
{

    protected $model = Attachment::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'type' => fake()->randomElement(['image', 'video']),
            'attachable_type' => Block::class,
            'attachable_id' => app(BlockFactory::class)->create(['type' => 'image'])->id,
        ];
    }
}
