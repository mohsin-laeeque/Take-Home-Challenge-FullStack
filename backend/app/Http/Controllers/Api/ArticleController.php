<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::query();

        // Add keyword filter
        if ($request->filled('keyword')) {
            $query->where('title', 'like', '%' . $request->get('keyword') . '%');
        }

        // Add date filter
        if ($request->filled('date')) {
            $query->whereDate('published_at', $request->get('date'));
        }

        // Add source filter
        if ($request->filled('source')) {
            $query->where('source', $request->get('source'));
        }

        // Execute query and paginate
        $articles = $query->paginate(10);


        return response()->json($articles);
    }

    // get unique sources
    public function sources()
    {
        $sources = Article::distinct()->pluck('source');
        return response()->json($sources);
    }
}
