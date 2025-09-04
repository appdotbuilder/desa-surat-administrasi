<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLetterArchiveRequest;
use App\Http\Requests\UpdateLetterArchiveRequest;
use App\Models\IncomingLetter;
use App\Models\LetterArchive;
use App\Models\OutgoingLetter;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LetterArchiveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = LetterArchive::with('archivedBy');

        // Filter by letter type
        if ($request->has('letter_type') && $request->letter_type !== '') {
            $query->where('letter_type', $request->letter_type);
        }

        // Filter by category
        if ($request->has('category') && $request->category !== '') {
            $query->where('category', $request->category);
        }

        // Search by archive number or category
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('archive_number', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        $archives = $query->latest('archived_at')
            ->paginate(10)
            ->withQueryString();

        // Load related letter data for each archive
        $archives->getCollection()->transform(function ($archive) {
            if ($archive->letter_type === 'incoming') {
                $archive->setAttribute('letter_data', IncomingLetter::find($archive->letter_id));
            } else {
                $archive->setAttribute('letter_data', OutgoingLetter::find($archive->letter_id));
            }
            return $archive;
        });

        return Inertia::render('archives/index', [
            'archives' => $archives,
            'filters' => $request->only(['letter_type', 'category', 'search']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $letterType = $request->get('letter_type', 'incoming');
        $letterId = $request->get('letter_id');

        $letter = null;
        if ($letterId) {
            if ($letterType === 'incoming') {
                $letter = IncomingLetter::findOrFail($letterId);
            } else {
                $letter = OutgoingLetter::findOrFail($letterId);
            }
        }

        return Inertia::render('archives/create', [
            'letter_type' => $letterType,
            'letter' => $letter,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLetterArchiveRequest $request)
    {
        $data = $request->validated();
        $data['archived_by'] = auth()->id();
        $data['archived_at'] = now();

        $archive = LetterArchive::create($data);

        // Update letter status to archived
        if ($data['letter_type'] === 'incoming') {
            IncomingLetter::find($data['letter_id'])->update(['status' => 'archived']);
        } else {
            OutgoingLetter::find($data['letter_id'])->update(['status' => 'archived']);
        }

        return redirect()->route('archives.show', $archive)
            ->with('success', 'Surat berhasil diarsipkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(LetterArchive $archive)
    {
        $archive->load('archivedBy');

        // Load related letter
        if ($archive->letter_type === 'incoming') {
            $archive->setAttribute('letter_data', IncomingLetter::with('creator')->find($archive->letter_id));
        } else {
            $archive->setAttribute('letter_data', OutgoingLetter::with('creator')->find($archive->letter_id));
        }

        return Inertia::render('archives/show', [
            'archive' => $archive,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LetterArchive $archive)
    {
        return Inertia::render('archives/edit', [
            'archive' => $archive,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLetterArchiveRequest $request, LetterArchive $archive)
    {
        $archive->update($request->validated());

        return redirect()->route('archives.show', $archive)
            ->with('success', 'Data arsip berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LetterArchive $archive)
    {
        // Update letter status back to previous state
        if ($archive->letter_type === 'incoming') {
            IncomingLetter::find($archive->letter_id)->update(['status' => 'processed']);
        } else {
            OutgoingLetter::find($archive->letter_id)->update(['status' => 'sent']);
        }

        $archive->delete();

        return redirect()->route('archives.index')
            ->with('success', 'Arsip berhasil dihapus.');
    }
}