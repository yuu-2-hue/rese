<!DOCTYPE html>
<html>

<head>
    <title>お知らせメール</title>
    <link rel="stylesheet" href="{{ asset('css/email/notice.css') }}" />
</head>

<body>
    <p>{!! nl2br(htmlspecialchars($mainText)) !!}</p>
</body>

</html>