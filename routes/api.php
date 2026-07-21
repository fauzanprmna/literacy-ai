<?php

use App\Http\Controllers\Api\ScrapedContentController;

Route::post('/scraping/import', [ScrapedContentController::class, 'store']);
?>