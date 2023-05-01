<?php

namespace Altenic\MaybeCms\Database\Factories;

use Altenic\MaybeCms\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory
 */
class PageFactory extends Factory
{
    protected $model = Page::class;

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

    public function configure()
    {
        return $this->afterMaking(function (Page $page) {
            $page->slug = Str::slug($page->title);
        });
    }
}
