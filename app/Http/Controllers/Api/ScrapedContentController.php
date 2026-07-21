<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ML\ScrapedContent;
use App\Models\ML\ContentClassification;

class ScrapedContentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'contents' => 'required|array'
        ]);

        foreach ($request->contents as $item) {

            $content = ScrapedContent::firstOrCreate(
                [
                    'url' => $item['url']
                ],
                [
                    'title' => $item['title'],
                    'description' => $item['description'],
                    'source' => $item['source'],
                    'author' => $item['author'],
                    'date' => $item['date']
                ]
            );

            ContentClassification::updateOrCreate(
                [
                    'content_id' => $content->id
                ],
                [
                    'dimension' => $item['dimension'],
                    'confidence' => $item['confidence']
                ]
            );
        }

        ScrapedContent::where(
            'created_at',
            '<',
            now()->subDays(90)
        )->delete();

        

        return response()->json([
            'success' => true
        ]);
    }
}
