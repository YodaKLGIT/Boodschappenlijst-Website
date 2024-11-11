<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage User Shopping Lists</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

    <div class="container mt-5">
        <h1 class="mb-4">Manage User Shopping Lists</h1>

        <form action="{{ route('user.shopping.lists.update') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="user_id">Select User:</label>
                <select id="user_id" name="user_id" class="form-control" required>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="shopping_lists">Select Shopping Lists:</label>
                <select id="shopping_lists" name="shopping_lists[]" class="form-control" multiple required>
                    @foreach($shoppingLists as $list)
                        <option value="{{ $list->id }}">{{ $list->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Update Lists</button>
        </form>

        @if(session('success'))
            <div class="alert alert-success mt-3">{{ session('success') }}</div>
        @endif
    </div>

</body>
</html>
