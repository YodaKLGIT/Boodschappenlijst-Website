<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvitationController extends Controller
{
    public function accept(Invitation $invitation)
    {
        if (Auth::id() !== $invitation->recipient_id) {
            abort(403, 'Unauthorized action.');
        }

        $invitation->update(['status' => 'accepted']);
        $invitation->list->users()->attach(Auth::id());

        return redirect()->route('lists.index')->with('success', 'Invitation accepted.');
    }

    public function decline(Invitation $invitation)
    {
        if (Auth::id() !== $invitation->recipient_id) {
            abort(403, 'Unauthorized action.');
        }

        $invitation->update(['status' => 'declined']);

        return redirect()->route('lists.index')->with('success', 'Invitation declined.');
    }

    public function index()
    {
        $invitations = Invitation::where('recipient_id', Auth::id())->get();
        $pendingCount = $invitations->where('status', 'pending')->count();

        return view('productlist.invitation', compact('invitations', 'pendingCount'));
    }
}
