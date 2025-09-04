<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIncomingLetterRequest;
use App\Http\Requests\UpdateIncomingLetterRequest;
use App\Models\IncomingLetter;
use Illuminate\Http\Request;
use Inertia\Inertia;

class IncomingLetterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = IncomingLetter::with('creator');

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Filter by priority
        if ($request->has('priority') && $request->priority !== '') {
            $query->where('priority', $request->priority);
        }

        // Search by letter number, sender, or subject
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('letter_number', 'like', "%{$search}%")
                  ->orWhere('sender', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%");
            });
        }

        $incomingLetters = $query->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('incoming-letters/index', [
            'incoming_letters' => $incomingLetters,
            'filters' => $request->only(['status', 'priority', 'search']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('incoming-letters/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreIncomingLetterRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = auth()->id();

        $incomingLetter = IncomingLetter::create($data);

        return redirect()->route('incoming-letters.show', $incomingLetter)
            ->with('success', 'Surat masuk berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(IncomingLetter $incomingLetter)
    {
        $incomingLetter->load(['creator', 'dispositions.assignedTo', 'dispositions.assignedBy']);

        return Inertia::render('incoming-letters/show', [
            'incoming_letter' => $incomingLetter,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(IncomingLetter $incomingLetter)
    {
        return Inertia::render('incoming-letters/edit', [
            'incoming_letter' => $incomingLetter,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIncomingLetterRequest $request, IncomingLetter $incomingLetter)
    {
        $incomingLetter->update($request->validated());

        return redirect()->route('incoming-letters.show', $incomingLetter)
            ->with('success', 'Surat masuk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IncomingLetter $incomingLetter)
    {
        $incomingLetter->delete();

        return redirect()->route('incoming-letters.index')
            ->with('success', 'Surat masuk berhasil dihapus.');
    }
}