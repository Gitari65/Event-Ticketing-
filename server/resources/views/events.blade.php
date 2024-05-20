
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>events</h1>
   
       
    
        @foreach($events as $event)
        <h3>{{$event['name']}}</h3>
        <h4>{{$event['venue']}}</h4>
        <h5>{{$event['location']}}</h5>
        @endforeach
        
    

</body>
</html>