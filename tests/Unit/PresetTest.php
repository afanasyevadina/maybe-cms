<?php

namespace Altenic\MaybeCms\Tests\Unit;

use Altenic\MaybeCms\Models\Block;
use Altenic\MaybeCms\Models\Preset;
use Altenic\MaybeCms\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PresetTest extends TestCase
{
    use DatabaseTransactions;

    public function test_list_presets_unauthorized()
    {
        $this->getJson('/api/presets')
            ->assertUnauthorized();
    }

    public function test_list_presets_forbidden()
    {
        $this->actingAsUser();
        $this->getJson('/api/presets')
            ->assertForbidden();
    }

    public function test_list_presets_success()
    {
        $this->actingAsAdmin();
        $this->getJson('/api/presets')
            ->assertSuccessful()
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'title',
                    'blocks' => [],
                    'created_at',
                    'updated_at',
                ],
            ]);
    }

    public function test_show_preset_unauthorized()
    {
        $this->getJson('/api/presets/' . $this->presetFactory->create()->id)
            ->assertUnauthorized();
    }

    public function test_show_preset_forbidden()
    {
        $this->actingAsUser();
        $this->getJson('/api/presets/' . $this->presetFactory->create()->id)
            ->assertForbidden();
    }

    public function test_show_preset_not_found()
    {
        $this->actingAsAdmin();
        $this->getJson('/api/presets/' . Preset::query()->max('id') + 1)
            ->assertNotFound();
    }

    public function test_show_preset_success()
    {
        $this->actingAsAdmin();
        $this->getJson('/api/presets/' . $this->presetFactory->create()->id)
            ->assertSuccessful()
            ->assertJsonStructure([
                'id',
                'title',
                'blocks' => [],
                'created_at',
                'updated_at',
            ]);
    }

    public function test_create_preset_unauthorized()
    {
        $this->postJson('/api/presets')
            ->assertUnauthorized();
    }

    public function test_create_preset_forbidden()
    {
        $this->actingAsUser();
        $this->postJson('/api/presets')
            ->assertForbidden();
    }

    public function test_create_preset_validation_failed()
    {
        $this->actingAsAdmin();
        $this->postJson('/api/presets')
            ->assertUnprocessable()
            ->assertJson([
                'errors' => [
                    'title' => 'The title field is required.',
                ],
            ]);
    }

    public function test_create_preset_success()
    {
        $this->actingAsAdmin();
        $data = [
            'title' => fake()->sentence(2),
        ];
        $this->postJson('/api/presets', $data)
            ->assertCreated()
            ->assertJsonStructure([
                'id',
            ]);
        $this->assertDatabaseHas((new Preset)->getTable(), [
            'title' => $data['title'],
            'user_id' => auth()->id(),
        ]);
    }

    public function test_update_preset_unauthorized()
    {
        $this->postJson('/api/presets/' . $this->presetFactory->create()->id)
            ->assertUnauthorized();
    }

    public function test_update_preset_forbidden()
    {
        $this->actingAsUser();
        $this->postJson('/api/presets/' . $this->presetFactory->create()->id)
            ->assertForbidden();
    }

    public function test_update_preset_not_found()
    {
        $this->actingAsAdmin();
        $this->postJson('/api/presets/' . Preset::query()->max('id') + 1)
            ->assertNotFound();
    }

    public function test_update_preset_validation_failed()
    {
        $this->actingAsAdmin();
        $this->postJson('/api/presets/' . $this->presetFactory->create()->id, [
            'title' => '',
            'blocks' => 123,
        ])
            ->assertUnprocessable()
            ->assertJson([
                'errors' => [
                    'title' => 'The title field is required.',
                    'blocks' => 'The blocks must be an array.',
                ],
            ]);
    }

    public function test_update_preset_success()
    {
        $preset = $this->presetFactory->create();
        $this->actingAsAdmin();
        $data = [
            'title' => fake()->sentence(2),
        ];
        $this->postJson('/api/presets/' . $preset->id, $data)
            ->assertSuccessful();
        $this->assertDatabaseHas((new Preset)->getTable(), [
            'id' => $preset->id,
            'title' => $data['title'],
        ]);
    }

    public function test_delete_preset_unauthorized()
    {
        $this->deleteJson('/api/presets/' . $this->presetFactory->create()->id)
            ->assertUnauthorized();
    }

    public function test_delete_preset_forbidden()
    {
        $this->actingAsUser();
        $this->deleteJson('/api/presets/' . $this->presetFactory->create()->id)
            ->assertForbidden();
    }

    public function test_delete_preset_not_found()
    {
        $this->actingAsAdmin();
        $this->deleteJson('/api/presets/' . Preset::query()->max('id') + 1)
            ->assertNotFound();
    }

    public function test_delete_preset_success()
    {
        $preset = $this->presetFactory->create();
        $this->actingAsAdmin();
        $this->deleteJson('/api/presets/' . $preset->id)
            ->assertNoContent();
        $this->assertDatabaseMissing((new Preset)->getTable(), [
            'id' => $preset->id,
        ]);
    }

    public function test_apply_preset_unauthorized()
    {
        $this->postJson('/api/presets/' . $this->presetFactory->create()->id . '/apply')
            ->assertUnauthorized();
    }

    public function test_apply_preset_forbidden()
    {
        $this->actingAsUser();
        $this->postJson('/api/presets/' . $this->presetFactory->create()->id . '/apply')
            ->assertForbidden();
    }

    public function test_apply_preset_not_found()
    {
        $this->actingAsAdmin();
        $this->postJson('/api/presets/' . Preset::query()->max('id') + 1 . '/apply')
            ->assertNotFound();
    }

    public function test_apply_preset_validation_failed_empty_body()
    {
        $this->actingAsAdmin();
        $this->postJson('/api/presets/' . $this->presetFactory->create()->id . '/apply')
            ->assertUnprocessable()
            ->assertJson([
                'errors' => [
                    'attachable_id' => 'The attachable id field is required.',
                    'attachable_type' => 'The attachable type field is required.',
                ],
            ]);
    }

    public function test_apply_preset_validation_failed_incorrect_attachable_id()
    {
        $this->actingAsAdmin();
        $this->postJson('/api/presets/' . $this->presetFactory->create()->id . '/apply', [
            'attachable_type' => 'block',
            'attachable_id' => Block::query()->max('id') + 1,
        ])
            ->assertUnprocessable()
            ->assertJson([
                'errors' => [
                    'attachable_id' => 'The selected attachable id is invalid.',
                ],
            ]);
    }

    //TODO: apply preset tests
}
