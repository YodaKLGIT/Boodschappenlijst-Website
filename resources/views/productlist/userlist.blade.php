<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users for {{ $shoppingList->name }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container mt-5">
        <h1>Users for {{ $shoppingList->name }}</h1>

        @if($users->isEmpty())
            <p>No users are currently assigned to this shopping list.</p>
        @else
            <ul>
                @foreach($users as $user)
                    <li>
                        {{ $user->name }}
                        <form action="{{ route('lists.users.detach', ['listId' => $shoppingList->id]) }}" method="POST" style="display:inline;">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                            <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @endif

        <a href="{{ route('user.shopping.lists.manage') }}" class="btn btn-primary mt-3">Back to Manage User Lists</a>
    </div>
</body>
</html>
