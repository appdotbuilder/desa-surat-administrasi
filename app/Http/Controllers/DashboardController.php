<?php

namespace App\Http\Controllers;

use App\Models\Disposition;
use App\Models\IncomingLetter;
use App\Models\LetterArchive;
use App\Models\OutgoingLetter;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display the dashboard with statistics.
     */
    public function index()
    {
        $stats = [
            'incoming_letters' => [
                'total' => IncomingLetter::count(),
                'new' => IncomingLetter::where('status', 'new')->count(),
                'processed' => IncomingLetter::where('status', 'processed')->count(),
                'disposed' => IncomingLetter::where('status', 'disposed')->count(),
            ],
            'outgoing_letters' => [
                'total' => OutgoingLetter::count(),
                'draft' => OutgoingLetter::where('status', 'draft')->count(),
                'sent' => OutgoingLetter::where('status', 'sent')->count(),
            ],
            'dispositions' => [
                'total' => Disposition::count(),
                'pending' => Disposition::where('status', 'pending')->count(),
                'in_progress' => Disposition::where('status', 'in_progress')->count(),
                'completed' => Disposition::where('status', 'completed')->count(),
                'overdue' => Disposition::where('status', '!=', 'completed')
                    ->where('due_date', '<', now())->count(),
            ],
            'archives' => [
                'total' => LetterArchive::count(),
                'incoming' => LetterArchive::where('letter_type', 'incoming')->count(),
                'outgoing' => LetterArchive::where('letter_type', 'outgoing')->count(),
            ],
            'users' => [
                'total' => User::count(),
                'active' => User::where('status', 'active')->count(),
            ],
        ];

        // Recent activities
        $recentIncomingLetters = IncomingLetter::with('creator')
            ->latest()
            ->take(5)
            ->get();

        $recentOutgoingLetters = OutgoingLetter::with('creator')
            ->latest()
            ->take(5)
            ->get();

        $recentDispositions = Disposition::with(['incomingLetter', 'assignedTo', 'assignedBy'])
            ->latest()
            ->take(5)
            ->get();

        return Inertia::render('dashboard', [
            'stats' => $stats,
            'recent_activities' => [
                'incoming_letters' => $recentIncomingLetters,
                'outgoing_letters' => $recentOutgoingLetters,
                'dispositions' => $recentDispositions,
            ],
        ]);
    }
}