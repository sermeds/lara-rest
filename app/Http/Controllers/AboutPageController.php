<?php

namespace App\Http\Controllers;

use App\Models\AboutPage;
use App\Http\Requests\Update\UpdateAboutPageRequest;

class AboutPageController extends Controller
{
    public function show()
    {
        return AboutPage::first(); // Всегда одна запись
    }

    public function update(UpdateAboutPageRequest $request)
    {
        $aboutPage = AboutPage::firstOrFail();
        $validated = $request->validated();
        $aboutPage->update($validated);
        return response()->json($aboutPage, 200, options:JSON_UNESCAPED_UNICODE);
    }
}
