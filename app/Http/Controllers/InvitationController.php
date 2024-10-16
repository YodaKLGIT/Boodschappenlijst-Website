<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\Shoppinglist;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class InvitationController extends Controller
{
    use AuthorizesRequests;

    public function store(Request $request, Shoppinglist $shoppinglist)
{
    $this->authorize('invite', $shoppinglist);

    $request->validate([
        'user_ids' => 'required|array',
        'user_ids.*' => 'exists:users,id'
    ]);

    foreach ($request->user_ids as $userId) {
        Invitation::create([
            'shoppinglist_id' => $shoppinglist->id,
            'sender_id' => Auth::id(),
            'recipient_id' => $userId,
        ]);
    }

    return redirect()->route('shoppinglist.show', $shoppinglist)
        ->with('success', 'Invitations sent successfully.');
}

    public function accept(Invitation $invitation)
    {
        $this->authorize('respond', $invitation);
        
        $invitation->update(['status' => 'accepted']);
        
        if ($invitation->shoppinglist) {
            $invitation->shoppinglist->users()->attach($invitation->recipient_id);
        } else {
            // Handle the case where the shopping list doesn't exist
            return redirect()->route('dashboard')->with('error', 'The associated shopping list no longer exists.');
        }

        return redirect()->route('shoppinglist.show', $invitation->shoppinglist)
            ->with('success', 'Invitation accepted.');
    }

    public function decline(Invitation $invitation)
    {
        $this->authorize('respond', $invitation);
        
        $invitation->update(['status' => 'declined']);

        return redirect()->route('dashboard')
            ->with('success', 'Invitation declined.');
    }
}
