<!DOCTYPE html>
<html>
<head>
    <title>Tipster 17</title>
</head>
<body>
    
    
    Hello Admin ({{ $email}}),<br>

    @if(!empty($all_warning_message))
        @foreach($all_warning_message as $message)
            {{$message}}<br>
        @endforeach

    @endif
   
    <p>Thank you</p>
</body>
</html>