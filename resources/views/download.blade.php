<!DOCTYPE html>
<html lang="en">

<head>
    <script>
        location.href =
            /Android/i.test(navigator.userAgent) ?
                "/download/android" :
                /iPhone|iPad|iPod/i.test(navigator.userAgent) ?
                    "/download/ios" :
                    "/";
    </script>
</head>

<body></body>

</html>