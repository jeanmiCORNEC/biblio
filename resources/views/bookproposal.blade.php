<!DOCTYPE html>
<html>

<head>
    <title>Proposition de livre</title>
</head>

<body>
    <h2>Proposition de livre</h2>
    <p>Titre: <br> {{ $data['title'] }}</p>
    <p>Auteur: <br>{{ $data['author'] }}</p>
    <p>Description: <br>{{ $data['description'] }}</p>
    <p>Couverture:<br> {{ $data['cover_image'] }}</p>
    <p>ISBN: <br>{{ $data['isbn'] }}</p>
    <p>Liens papier: @foreach ($data['paperLinks'] as $link)
            <br> {{ $link['link'] }}
        @endforeach
    </p>
    <p>Liens ebook: @foreach ($data['ebookLinks'] as $link)
            <br>{{ $link['link'] }}
        @endforeach
    </p>
</body>

</html>
