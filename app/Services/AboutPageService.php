<?php

namespace App\Services;

use App\Models\AboutPage;
use App\Models\BonusPoints;
use App\Models\Dish;
use App\Models\Hall;
use App\Models\Table;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class AboutPageService
{
    public function show()
    {
        $this->default();
        return AboutPage::first();
    }

    public function updateAboutPage(array $data)
    {
        $aboutPage = AboutPage::firstOrFail();
        $aboutPage->update($data);
        return $aboutPage;
    }

    private function default(): void
    {
        if (AboutPage::count() === 0) {
            AboutPage::create([
                'title' => 'Default title',
                'description' => 'Artur Russkiy!',
                'image_url' => 'Artur.jpg'
            ]);
        }
    }
}
