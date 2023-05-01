<?php

namespace Altenic\MaybeCms\Database\Seeders;

use Altenic\MaybeCms\Models\Page;
use Altenic\MaybeCms\Models\Setting;
use Altenic\MaybeCms\Models\User;
use Illuminate\Database\Seeder;

class MaybeCmsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $user = User::query()->first();
        $page = Page::query()->firstOrCreate([
            'title' => env('APP_NAME', 'Главная'),
        ]);
        $page->update(['user_id' => $user?->id]);
        Setting::query()->insert([
            [
                'title' => 'Название сайта',
                'slug' => 'site_name',
                'type' => 'text',
                'value' => env('APP_NAME'),
            ],
            [
                'title' => 'Главная страница',
                'slug' => 'home_page',
                'type' => 'select',
                'value' => $page->id,
            ],
            [
                'title' => 'Активная тема',
                'slug' => 'active_theme',
                'type' => 'select',
                'value' => 'maybe_theme',
            ],
        ]);
        Setting::query()->update(['user_id' => $user?->id]);
    }
}
