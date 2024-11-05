<?php

namespace App\Http\Controllers;

use App\Mail\ShoppingListInvitation;
use App\Models\Invitation;
use App\Models\Shoppinglist;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Mail;

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

    public function accept($id)
    {
        $invitation = Invitation::findOrFail($id);
        $invitation->status = 'accepted'; // Update the status
        $invitation->save();

        // Attach the user to the shopping list
        $shoppinglist = $invitation->shoppinglist;
        $shoppinglist->sharedUsers()->attach(Auth::id());

        return redirect()->route('shoppinglist.show', $shoppinglist)
            ->with('success', 'You have accepted the invitation.');
    }

    public function decline($id)
    {
        $invitation = Invitation::findOrFail($id);
        $invitation->status = 'declined'; // Update the status
        $invitation->save();

        return redirect()->back()->with('success', 'You have declined the invitation.');
    }


    public function mail()
    {

        $shoppinglist = new Shoppinglist();
        Mail::to('test@test.com')->send(new ShoppingListInvitation($shoppinglist));

        return view('emails.shoppinglist-invitation');

 
    }
}
