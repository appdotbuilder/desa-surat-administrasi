<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOutgoingLetterRequest;
use App\Http\Requests\UpdateOutgoingLetterRequest;
use App\Models\OutgoingLetter;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OutgoingLetterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = OutgoingLetter::with('creator');

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Filter by priority
        if ($request->has('priority') && $request->priority !== '') {
            $query->where('priority', $request->priority);
        }

        // Search by letter number, recipient, or subject
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('letter_number', 'like', "%{$search}%")
                  ->orWhere('recipient', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%");
            });
        }

        $outgoingLetters = $query->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('outgoing-letters/index', [
            'outgoing_letters' => $outgoingLetters,
            'filters' => $request->only(['status', 'priority', 'search']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('outgoing-letters/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOutgoingLetterRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = auth()->id();

        $outgoingLetter = OutgoingLetter::create($data);

        return redirect()->route('outgoing-letters.show', $outgoingLetter)
            ->with('success', 'Surat keluar berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(OutgoingLetter $outgoingLetter)
    {
        $outgoingLetter->load('creator');

        return Inertia::render('outgoing-letters/show', [
            'outgoing_letter' => $outgoingLetter,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OutgoingLetter $outgoingLetter)
    {
        return Inertia::render('outgoing-letters/edit', [
            'outgoing_letter' => $outgoingLetter,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOutgoingLetterRequest $request, OutgoingLetter $outgoingLetter)
    {
        $outgoingLetter->update($request->validated());

        return redirect()->route('outgoing-letters.show', $outgoingLetter)
            ->with('success', 'Surat keluar berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OutgoingLetter $outgoingLetter)
    {
        $outgoingLetter->delete();

        return redirect()->route('outgoing-letters.index')
            ->with('success', 'Surat keluar berhasil dihapus.');
    }
}