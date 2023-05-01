<?php

namespace Altenic\MaybeCms\Database\Factories;

use Altenic\MaybeCms\Models\Block;
use Altenic\MaybeCms\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class BlockFactory extends Factory
{

    protected $model = Block::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => fake()->sentence(2),
            'type' => fake()->randomElement(collect(maybe_primitives())->keys()->toArray()),
            'attachable_type' => Page::class,
            'attachable_id' => app(PageFactory::class)->create()->id,
        ];
    }
}
