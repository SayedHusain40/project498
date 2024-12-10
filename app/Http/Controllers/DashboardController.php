<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Question;
use App\Models\Announcement;
use App\Models\User;
use App\Models\Reply;
use App\Models\Restaurant;
use App\Models\Marketplace;
use App\Models\StudySession;
use App\Models\Club;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Get the count of materials, questions, replies, users, events, restaurants, marketplaces, study sessions, and clubs
        $materialCount = Material::count();
        $questionCount = Question::count();
        $replyCount = Reply::count();
        $userCount = User::count();
        $eventCount = Announcement::count();
        $restaurantCount = Restaurant::count();
        $marketplaceCount = Marketplace::count();
        $studySessionCount = StudySession::count();
        $clubCount = Club::count(); // Get club count

        // Return view with the data
        return view('dashboard', compact('materialCount', 'questionCount', 'replyCount', 'userCount', 'eventCount', 'restaurantCount', 'marketplaceCount', 'studySessionCount', 'clubCount'));
    }
}
