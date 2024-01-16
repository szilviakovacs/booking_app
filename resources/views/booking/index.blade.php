
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ügyfélnaptár</title>

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- custom JavaScript file -->
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script src="{{ asset('js/booking.js') }}"></script>
    
</head>
<body>
<div id="calendar" style="width:600px; height:500px;"></div>

</body>
</html>