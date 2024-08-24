<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // number of users
        $totalUsers = User::count();

        // number of posts
        $totalPosts = Post::count();

        // number of users with no posts
        $usersWithNoPosts = User::doesntHave('posts')->count();

        return response()->json([
            'total_users' => $totalUsers,
            'total_posts' => $totalPosts,
            'users_with_no_posts' => $usersWithNoPosts,
        ]);
    }
}
