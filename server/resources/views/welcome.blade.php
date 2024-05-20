<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Other meta tags -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Include your other head elements here -->
</head>
<body>
    <div id="app"></div>
    
    <script>
        window.Laravel = { csrfToken: '{{ csrf_token() }}' };
    </script>
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
