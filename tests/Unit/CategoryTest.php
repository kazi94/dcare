<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $categories = factory(\App\Models\Category::class, 10)
            ->create()
            ->each(function ($cat) {
                $cat->acts()->createMany(factory(\App\Models\Acte::class, 20)->make()->toArray());
            });
    }
}
