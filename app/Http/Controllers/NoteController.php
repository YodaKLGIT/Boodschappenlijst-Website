<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\ListItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    public function store(Request $request, $list)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        Note::create([
            'title' => $request->title,
            'description' => $request->description,
            'list_id' => $list,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('productlist.show', $list)->with('success', 'Note added successfully.');
    }
    public function destroy(Note $note)
    {
        // Ensure the user is authorized to delete the note
        if (Auth::id() !== $note->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $note->delete();

        return redirect()->back()->with('success', 'Note removed successfully.');
    }
    
}