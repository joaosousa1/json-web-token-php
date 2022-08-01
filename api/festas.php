<?php
# end-point /api/festas
# apenas implementei o método GET

require_once("../jwt.php");

$auth = $_SERVER['HTTP_AUTHORIZATION'];
# importante! para o apache passar a header "Authorization" para o php é necessário colocar:
# "CGIPassAuth On" no .htaccess

function autoriza(){

  if ( is_jwt_valid( $_SERVER['HTTP_AUTHORIZATION'] ) == FALSE ) {
  
    $erro = new stdClass();
    $erro->erromsg = "erro! acesso não autorizado.";
    
  
    header('Content-Type: application/json; charset=UTF-8');
    header('HTTP/1.0 401 Unauthorized');
    echo json_encode($erro);
    exit();
  }

}

autoriza();

require_once("../dbconnect.php");

$sql = "SELECT nomeFesta,
descricao,
distrito,
concelho,
freguesia,
nomeSanto,
religiosa,
dataInicio,
dataFim,
posGps,
link FROM festas";
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
  // output data of each row

  $data = array();
  while($row = $result->fetch_assoc()) {
    #echo "id: " . $row["id"]. " - Name: " . $row["nome"]. "<br>";
    array_push($data, $row);
  }
} else {
  echo "0 results";
}
header('Content-Type: application/json; charset=UTF-8');
header('HTTP/1.0 200 Ok');
echo json_encode($data);

$mysqli->close();
?>