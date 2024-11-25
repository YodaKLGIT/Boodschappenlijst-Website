<x-app-layout>
    <div class="max-w-4xl mx-auto mt-8">
        <h1 class="text-2xl font-bold mb-4">Your Invitations</h1>
        
        @if ($pendingCount > 0)
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">You have {{ $pendingCount }} pending invitation(s)!</strong>
            </div>
        @endif

        @foreach ($invitations as $invitation)
            @if ($invitation->status === 'pending')
                <div class="bg-white shadow-md rounded-lg p-4 mb-4">
                    <p>You have been invited to join the list: {{ $invitation->list->name }}</p>
                    <form action="{{ route('invitations.accept', $invitation->id) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Accept</button>
                    </form>
                    <form action="{{ route('invitations.decline', $invitation->id) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Decline</button>
                    </form>
                </div>
            @endif
        @endforeach
    </div>
</x-app-layout>
