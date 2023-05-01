<?php

namespace Altenic\MaybeCms\Tests\Unit;

use Altenic\MaybeCms\Models\Page;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use Altenic\MaybeCms\Tests\TestCase;

class PageTest extends TestCase
{
    use DatabaseTransactions;

    public function test_get_pages_unauthorized()
    {
        $this->getJson('/api/pages')
            ->assertUnauthorized();
    }

    public function test_get_pages_forbidden()
    {
        $this->actingAsUser();
        $this->getJson('/api/pages')
            ->assertForbidden();
    }

    public function test_get_pages_success()
    {
        $this->actingAsAdmin();
        $this->pageFactory->count(30 - Page::query()->count())->create();
        $this->getJson('/api/pages')
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'slug',
                        'title',
                        'active',
                        'user' => [
                            'id',
                            'name',
                        ],
                        'created_at',
                        'updated_at',
                    ],
                ],
                'meta' => [
                    'current_page',
                    'from',
                    'last_page',
                    'per_page',
                    'to',
                    'total',
                ],
            ])
        ->assertJsonCount(20, 'data')
        ->assertJson([
            'meta' => [
                'current_page' => 1,
                'from' => 1,
                'last_page' => 2,
                'per_page' => 20,
                'to' => 20,
                'total' => 30,
            ],
        ]);
    }

    public function test_get_pages_second_page_success()
    {
        $this->actingAsAdmin();
        $this->pageFactory->count(30 - Page::query()->count())->create();
        $this->getJson('/api/pages?page=2')
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'slug',
                        'title',
                        'active',
                        'user' => [
                            'id',
                            'name',
                        ],
                        'created_at',
                        'updated_at',
                    ],
                ],
                'meta' => [
                    'current_page',
                    'from',
                    'last_page',
                    'per_page',
                    'to',
                    'total',
                ],
            ])
            ->assertJsonCount(10, 'data')
            ->assertJson([
                'meta' => [
                    'current_page' => 2,
                    'from' => 21,
                    'last_page' => 2,
                    'per_page' => 20,
                    'to' => 30,
                    'total' => 30,
                ],
            ]);
    }

    public function test_create_page_unauthorized()
    {
        $this->postJson('/api/pages')
            ->assertUnauthorized();
    }

    public function test_create_page_forbidden()
    {
        $this->actingAsUser();
        $this->postJson('/api/pages')
            ->assertForbidden();
    }

    public function test_create_page_validation_failed()
    {
        $this->actingAsAdmin();
        $this->postJson('/api/pages')
            ->assertUnprocessable()
            ->assertJson([
                'errors' => [
                    'title' => 'The title field is required.',
                ],
            ]);
    }

    public function test_create_page_success()
    {
        $this->actingAsAdmin();
        $data = [
            'title' => fake()->sentence(2),
        ];
        $this->postJson('/api/pages', $data)
            ->assertCreated()
            ->assertJsonStructure([
                'id',
            ]);
        $this->assertDatabaseHas((new Page)->getTable(), [
            'title' => $data['title'],
            'slug' => Str::slug($data['title']),
            'active' => 1,
            'user_id' => auth()->id(),
        ]);
    }

    public function test_update_page_unauthorized()
    {
        $this->postJson('/api/pages/' . $this->pageFactory->create()->id)
            ->assertUnauthorized();
    }

    public function test_update_page_forbidden()
    {
        $this->actingAs($this->userFactory->create(), 'sanctum');
        $this->postJson('/api/pages/' . $this->pageFactory->create()->id)
            ->assertForbidden();
    }

    public function test_update_page_not_found()
    {
        $this->actingAsAdmin();
        $this->postJson('/api/pages/' . Page::query()->max('id') + 1)
            ->assertNotFound();
    }

    public function test_update_page_validation_failed()
    {
        $this->actingAsAdmin();
        $this->postJson('/api/pages/' . $this->pageFactory->create()->id, [
            'title' => '',
            'slug' => '',
        ])
            ->assertUnprocessable()
            ->assertJson([
                'errors' => [
                    'title' => 'The title field is required.',
                    'slug' => 'The slug field is required.',
                ],
            ]);
    }

    public function test_update_page_success()
    {
        $page = $this->pageFactory->create();
        $this->actingAsAdmin();
        $slug = fake()->sentence(2);
        $data = [
            'title' => fake()->sentence(2),
            'slug' => $slug,
        ];
        $this->postJson('/api/pages/' . $page->id, $data)
            ->assertSuccessful();
        $this->assertDatabaseHas((new Page)->getTable(), [
            'id' => $page->id,
            'title' => $data['title'],
            'slug' => Str::slug($data['slug']),
        ]);
    }

    public function test_delete_page_unauthorized()
    {
        $this->deleteJson('/api/pages/' . $this->pageFactory->create()->id)
            ->assertUnauthorized();
    }

    public function test_delete_page_forbidden()
    {
        $this->actingAsUser();
        $this->deleteJson('/api/pages/' . $this->pageFactory->create()->id)
            ->assertForbidden();
    }

    public function test_delete_page_not_found()
    {
        $this->actingAsAdmin();
        $this->deleteJson('/api/pages/' . Page::query()->max('id') + 1)
            ->assertNotFound();
    }

    public function test_delete_page_success()
    {
        $page = $this->pageFactory->create();
        $this->actingAsAdmin();
        $this->deleteJson('/api/pages/' . $page->id)
            ->assertNoContent();
        $this->assertDatabaseMissing((new Page)->getTable(), [
            'id' => $page->id,
        ]);
    }
}
