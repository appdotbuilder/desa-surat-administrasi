<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDispositionRequest;
use App\Http\Requests\UpdateDispositionRequest;
use App\Models\Disposition;
use App\Models\IncomingLetter;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DispositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Disposition::with(['incomingLetter', 'assignedTo', 'assignedBy']);

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Filter by assigned user
        if ($request->has('assigned_to') && $request->assigned_to !== '') {
            $query->where('assigned_to', $request->assigned_to);
        }

        // Filter by priority
        if ($request->has('priority') && $request->priority !== '') {
            $query->where('priority', $request->priority);
        }

        // Search by instructions or letter subject
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('instructions', 'like', "%{$search}%")
                  ->orWhereHas('incomingLetter', function ($letterQuery) use ($search) {
                      $letterQuery->where('subject', 'like', "%{$search}%");
                  });
            });
        }

        $dispositions = $query->latest()
            ->paginate(10)
            ->withQueryString();

        $users = User::active()->get();

        return Inertia::render('dispositions/index', [
            'dispositions' => $dispositions,
            'users' => $users,
            'filters' => $request->only(['status', 'assigned_to', 'priority', 'search']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $incomingLetter = null;
        if ($request->has('incoming_letter_id')) {
            $incomingLetter = IncomingLetter::findOrFail($request->incoming_letter_id);
        }

        $incomingLetters = IncomingLetter::where('status', '!=', 'archived')
            ->orderBy('received_date', 'desc')
            ->get();

        $users = User::active()->get();

        return Inertia::render('dispositions/create', [
            'incoming_letter' => $incomingLetter,
            'incoming_letters' => $incomingLetters,
            'users' => $users,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDispositionRequest $request)
    {
        $data = $request->validated();
        $data['assigned_by'] = auth()->id();

        $disposition = Disposition::create($data);

        // Update incoming letter status to disposed
        $incomingLetter = IncomingLetter::find($data['incoming_letter_id']);
        if ($incomingLetter) {
            $incomingLetter->update(['status' => 'disposed']);
        }

        return redirect()->route('dispositions.show', $disposition)
            ->with('success', 'Disposisi berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Disposition $disposition)
    {
        $disposition->load(['incomingLetter', 'assignedTo', 'assignedBy']);

        return Inertia::render('dispositions/show', [
            'disposition' => $disposition,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Disposition $disposition)
    {
        $users = User::active()->get();

        return Inertia::render('dispositions/edit', [
            'disposition' => $disposition,
            'users' => $users,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDispositionRequest $request, Disposition $disposition)
    {
        $data = $request->validated();

        // If status is being changed to completed, set completion timestamp
        if ($data['status'] === 'completed' && $disposition->status !== 'completed') {
            $data['completed_at'] = now();
        }

        $disposition->update($data);

        return redirect()->route('dispositions.show', $disposition)
            ->with('success', 'Disposisi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Disposition $disposition)
    {
        // Update incoming letter status back to processed
        $disposition->incomingLetter()->update(['status' => 'processed']);

        $disposition->delete();

        return redirect()->route('dispositions.index')
            ->with('success', 'Disposisi berhasil dihapus.');
    }
}