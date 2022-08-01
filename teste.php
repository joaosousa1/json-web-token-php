<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>testes</title>
    <link rel="stylesheet" href="/css/main.css">
</head>

<body>
    <div class="content">
        <p>Testes com o curl na consola do Linux</p>
        <br>
        <pre>
curl --header "Content-Type: application/json; charset=UTF-8" \
--request POST \
--data '{"email":"teste","password":"teste"}' \
http://localhost:5000/api/auth
        </pre>
        <br>
        <pre>
curl --header "Content-Type: application/json; charset=UTF-8" \
--header "Authorization: jwt" \
--request GET \
http://localhost:5000/api/festas
        </pre>
    </div>

</body>

</html>
