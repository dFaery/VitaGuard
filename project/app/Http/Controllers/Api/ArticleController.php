<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleTopic;
use App\Models\User;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $articles = Article::all();
        return view('pages.articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $creators = User::where([
            'role' => 'doctor',
            'status' => 'active'
        ])->get();
        $article_topics = ArticleTopic::all();

        return response()->json([
            'success' => true,
            'creators' => $creators,
            'article_topics' => $article_topics
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'creator' => 'required|string|max:255',
            'article_topic_id' => 'required|integer|exists:article_topics,id',
            'content' => 'required|string',
            'image' => 'required',
        ]);

        $imagePath = $request->image;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('articles', 'public');
        }

        Article::create([
            'title' => $request->title,
            'creator' => $request->creator,
            'article_topic_id' => $request->article_topic_id,
            'content' => $request->content,
            'image' => $imagePath,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Artikel medis berhasil diterbitkan!'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $article = Article::find($id);
        return response()->json([
            'success' => true,
            'article' => $article
        ]);
        // return view('articles.read', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        //WHO CAN EDIT?
        //ADMIN -> Check by MIDDLEWARE & CREATOR -> Check by BUSSINESS LOGIC (Service)
        $article->load('topic');

        return response()->json([
            'success' => true,
            'article' => $article
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'creator' => 'required|string|max:255',
            'article_topic_id' => 'required|integer|exists:article_topics,id',
            'content' => 'required|string',
            'image' => 'required',
        ]);

        $imagePath = $article->image;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('articles', 'public');
        }

        $article->update([
            'title' => $request->title,
            'creator' => $request->creator,
            'article_topic_id' => $request->article_topic_id,
            'content' => $request->content,
            'image' => $imagePath,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Artikel medis berhasil diupdate!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $article->delete();

        return response()->json([
            'success' => true,
            'message' => 'Article has been deleted'
        ]);
    }

    public function fetchArticles()
    {
        $articles = Article::with(['topic', 'creator'])->get();

        return response()->json([
            'success' => true,
            'data' => $articles,
        ]);
    }

    public function getLatestArticles(Request $request)
    {
        $query = Article::query();

        if ($request->has('topic')) {
            $query->where('article_topic_id', $request->topic);
        }

        $articles = $query->latest()->take(10)->get();

        if (count($articles) > 0) {
            return response()->json([
                'success' => true,
                'data' => $articles
            ]);
        } else {
            return response()->json([
                'success' => false,
                'data' => 'Data not found'
            ]);
        }
    }

    public function getPopularArticleTopics()
    {
        $topics = ArticleTopic::withCount('articles')
            ->orderBy('articles_count', 'desc')
            ->take(5)
            ->get();

        if (count($topics) > 0) {
            return response()->json([
                'success' => true,
                'data' => $topics,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'data' => 'Data not found',
            ]);
        }
    }

    public function getArticleTopics()
    {
        $topics = ArticleTopic::get();

        if (count($topics) > 0) {
            return response()->json([
                'success' => true,
                'data' => $topics,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'data' => 'Data not found',
            ]);
        }
    }
}
