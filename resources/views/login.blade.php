
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Bootstrap CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1"
        crossorigin="anonymous" />

    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />

    <style>
        body,
        html,
        .body {
            width: 100%;
            height: 100%;
        }
        .kotak-login {
            width: 400px;
        }
    </style>

    <title>Hello, world!</title>
</head>
<body>
    <div class="body d-flex">
        <div class="kotak-login mx-auto my-auto p-5 shadow">
            <h3 class="text-center">Admin GIS Wisata</h3>
            <form action="/auth" method="get"  accept-charset="UTF-8">
                @csrf
            <div class="mt-5">
                <input
                    type="email"
                    class="form-control"
                    name="email"
                    placeholder="email@example.com" />
            </div>
            <div class="mt-3">
                <input
                    type="password"
                    class="form-control"
                    name="password"
                    placeholder="******" />
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary m-0 mt-3">LOGIN</button>
            </div>
            <hr />
            <div class="d-grid">
                <a href="daftar.aspx" class="text-center">DAFTAR</a>
            </div>
            </form>
        </div>
    </div>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
</body>
</html>