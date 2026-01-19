<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    @php
        $body = $mailFormat?->body ?? $mailFormat ?? null;

        foreach ($data as $key => $value) {
            $body = str_replace('{{'.$key.'}}', $value, $body);
        }
    @endphp

    {!! $body !!}

</body>

</html>
