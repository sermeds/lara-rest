<?php

namespace Tests\Feature;

use App\Models\AboutPage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AboutPageControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_about_page_can_be_retrieved()
    {
        $aboutPage = AboutPage::factory()->create();

        $response = $this->getJson('/api/about-page');

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'title' => $aboutPage->title,
            'description' => $aboutPage->description,
        ]);
    }

    public function test_about_page_can_be_updated()
    {
        $aboutPage = AboutPage::factory()->create();

        $data = [
            'title' => 'Updated Title',
        ];

        $response = $this->putJson('/api/about-page', $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('about_page', $data);
    }
}
