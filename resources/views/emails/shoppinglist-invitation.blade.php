<!DOCTYPE html>
<html>
<head>
    <title>Shopping List Invitation</title>
</head>
<body>
    <h1>You have been invited to join a shopping list!</h1>
    <p>Click the link below to accept the invitation:</p>
    <a href="{{ $acceptUrl }}">Accept Invitation</a>
    <p>If you do not wish to join, click the link below to decline:</p>
    <a href="{{ $declineUrl }}">Decline Invitation</a>
</body>
</html>
