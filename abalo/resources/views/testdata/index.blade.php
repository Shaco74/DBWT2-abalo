<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Data</title>
</head>
<body>
<h1>Test Data</h1>

@if($testData->isEmpty())
    <p>Keine Daten gefunden</p>
@else
    <ul style="background-color: #FF2D20">
        @foreach($testData as $data)
            <li>{{ $data->ab_testname }}</li>
            <!-- Ersetze 'attribute' durch den tatsächlichen Namen deiner Datenbankspalte -->
        @endforeach
    </ul>
@endif
</body>
</html>
