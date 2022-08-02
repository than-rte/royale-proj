<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c:wght@100;300;400;500;700;800;900&display=swap" rel="stylesheet">
        {{-- <script src="https://unpkg.com/vue-cal@legacy"></script>
        <link href="https://unpkg.com/vue-cal@legacy/dist/vuecal.css" rel="stylesheet"> --}}
        @routes
        @vite(['resources/scss/app.scss', 'resources/js/app.js'])
        @inertiaHead
        <style>
          .vuecal__event {
            background-color: #ccc;
            color: black;
          }
          .vuecal__time-column {
            width: 4rem !important; 
          }
          .vuecal--view-with-time .vuecal__weekdays-headings, .vuecal--week-numbers .vuecal__weekdays-headings {
            padding-left: 4rem !important;
          }
        </style>
    </head>
    <body>
      @inertia
    </body>
</html>
