<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Images Show</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body style="text-align: center; background: #000;">
    @foreach ($images as $img)
    @php echo	$ext = pathinfo($img, PATHINFO_EXTENSION); 
    @endphp
    @if($ext=='pdf')
    		<embed src="{{ url('uploads/specials/' . $id . '/' . $img)}}" type="application/pdf" width="100%" height="600px" />
    @else
        <img src="{{ url('uploads/specials/' . $id . '/' . $img)}}" alt="" width="45%"><br>
    @endif    
    @endforeach
</body>
</html>