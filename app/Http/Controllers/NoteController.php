<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Shoppinglist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    public function store(Request $request, Shoppinglist $shoppinglist)
{
    $request->validate([
        'title' => 'required|max:255',
        'description' => 'required',
    ]);

    $note = new Note([
        'title' => $request->title,
        'description' => $request->description,
        'user_id' => Auth::id(),
        'list_id' => $shoppinglist->id,
    ]);

    $note->save();

    return redirect()->route('shoppinglist.show', $shoppinglist)
                     ->with('success', 'Note added successfully.');
}
}