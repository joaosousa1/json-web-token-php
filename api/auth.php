<?php

require_once("../jwt.php");

# get body
$jsonReqUrl  = "php://input";
$reqjson = file_get_contents($jsonReqUrl);
$reqjsonDecode = json_decode($reqjson, true);

$email =  $reqjsonDecode['email'];
$password = md5($reqjsonDecode['password']);

require_once("../dbconnect.php");

$sql= "SELECT * FROM utilizadores WHERE email = '$email' AND password = '$password' ";
$result = mysqli_query($mysqli,$sql);
$check = mysqli_fetch_array($result);

if(isset($check)){
    error_log("login ok creat jwt");

    # cria o token
    $headers = array('alg'=>'HS256','typ'=>'JWT');
    $payload = array('nome'=>'teste', 'exp'=>(time() +  (60 * 10))); # 10 minutos
    $jwt = generate_jwt($headers, $payload);

    $ob = new stdClass();
    $ob->jwt = $jwt;
    $ob->useremail = $email;
    
    header('Content-Type: application/json; charset=UTF-8');
    header('HTTP/1.0 200 OK');
    echo json_encode($ob);

}else{

    error_log("erro login");
    $erro = new stdClass();
    $erro->erromsg = "Erro no email ou password! Acesso não autorizado.";
     
    header('Content-Type: application/json; charset=UTF-8');
    header('HTTP/1.0 403 Forbidden');
    echo json_encode($erro);

}
$mysqli->close();
?>
