<?php

namespace Altenic\MaybeCms\Tests;

use Altenic\MaybeCms\Database\Factories\BlockFactory;
use Altenic\MaybeCms\Database\Factories\PageFactory;
use Altenic\MaybeCms\Database\Factories\PresetFactory;
use Altenic\MaybeCms\Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\CreatesApplication;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $userFactory;
    protected $pageFactory;
    protected $blockFactory;
    protected $presetFactory;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userFactory = new UserFactory;
        $this->pageFactory = new PageFactory;
        $this->blockFactory = new BlockFactory;
        $this->presetFactory = new PresetFactory;
    }

    protected function actingAsUser()
    {
        $this->actingAs($this->userFactory->create(), 'sanctum');
    }

    protected function actingAsAdmin()
    {
        $this->actingAs($this->userFactory->admin()->create(), 'sanctum');
    }
}
