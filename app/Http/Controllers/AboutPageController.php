<?php

namespace App\Http\Controllers;

use App\Models\AboutPage;
use App\Http\Requests\Update\UpdateAboutPageRequest;
use App\Services\AboutPageService;

class AboutPageController extends Controller
{
    protected AboutPageService $aboutPageService;

    public function __construct(AboutPageService $aboutPageService)
    {
        $this->aboutPageService = $aboutPageService;
    }

    public function show()
    {
        return $this->aboutPageService->show(); // Всегда одна запись
    }

    public function update(UpdateAboutPageRequest $request)
    {
        $validated = $request->validated();
        $aboutPage = $this->aboutPageService->updateAboutPage($validated);
        return response()->json($aboutPage, 200, options: JSON_UNESCAPED_UNICODE);
    }
}
