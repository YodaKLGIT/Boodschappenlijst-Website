<x-app-layout>
    <div class="max-w-4xl mx-auto mt-8">
        <h1 class="text-2xl font-bold mb-4">Your Invitations</h1>
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
