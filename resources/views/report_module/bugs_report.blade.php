<!DOCTYPE html>
    <html lang="en-US">
    	<head>
    		<meta charset="utf-8">
    	</head>
    	<body>
    		<h2>Rapport de bug</h2>
    		<p> M.<b>{{$nom}}</b>  
    			<br> 

			<h3>Sujet</h3>
			<p>{{ $sujet }}</p>
			<br>
			<h3>description</h3>
			<p>{{ $description }}</p>
			<br>
			<h3>photo</h3>
			<img src="{{ $photo }}" width='100%' height='100%'>
    	</body>
    </html>