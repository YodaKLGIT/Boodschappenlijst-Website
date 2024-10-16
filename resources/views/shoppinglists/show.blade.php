<form action="{{ route('shoppinglist.invite', $shoppinglist) }}" method="POST">
    @csrf
    <select name="user_id">
        @foreach($users as $user)
            <option value="{{ $user->id }}">{{ $user->name }}</option>
        @endforeach
    </select>
    <button type="submit">Invite User</button>
</form>
