<!-- resources/views/articles/index.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Article Overview</title>
</head>
@php
    use App\Helpers\ImageHelper;
@endphp
<body>
<h1>Article Overview</h1>

<form action="{{ url('/articles') }}" method="get">
    <label for="search">Search:</label>
    <input type="text" id="search" name="search" value="{{ request()->input('search') }}">
    <button type="submit">Search</button>
</form>

<table style="border-collapse: collapse">
    <thead>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Description</th>
        <th>Article Image</th>
    </tr>
    </thead>
    <tbody>
    @foreach($articles as $article)
        <tr style="border: 2px solid #9ca3af">
            <td>{{ $article->id }}</td>
            <td>{{ $article->ab_name }}</td>
            <td>{{ $article->description }}</td>
            <td>{!! ImageHelper::renderImageIfPresent($article->image) !!}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
