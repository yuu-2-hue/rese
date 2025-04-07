<!DOCTYPE html>
<html>

<head>
    <title>リマインドメール</title>
    <link rel="stylesheet" href="{{ asset('css/email/reminder.css') }}" />
</head>

<body>
    <p>{{ $details['name'] }} 様</p>
    <br>
    <p>このたびは、ご予約いただきありがとうございます。</p>
    <p>本日ご予約を承っております。</p>
    <p>下記にご予約内容を改めて記載しましたので、ご確認をよろしくお願い致します。</p>
    <br>
    <p>※本メールと行き違いでキャンセル頂いております場合は、何卒ご容赦ください。</p>
    <br>
    <p>-----------------------------------------------------------------------------------</p>
    <ul>
        <li>予約店舗</li>
        <p>{{ $details['shop'] }}</p>
        <li>予約日時</li>
        <p>{{ $details['date'] }}</p>
        <li>予約人数</li>
        <p>{{ $details['number'] }}人</p>
    </ul>
    <br>
    <p>ご来店お待ちしております。</p>
</body>

</html>