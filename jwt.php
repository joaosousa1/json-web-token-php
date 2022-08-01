<?php

define("SECRET", "super_long_and_secure_string_1337"); // defina aqui uma string segura

function base64url_encode($str) {
	return rtrim(strtr(base64_encode($str), '+/', '-_'), '=');
}

function generate_jwt($headers, $payload) {
	$headers_encoded = base64url_encode(json_encode($headers));
	
	$payload_encoded = base64url_encode(json_encode($payload));
	
	$signature = hash_hmac('SHA256', "$headers_encoded.$payload_encoded", SECRET, true);
	$signature_encoded = base64url_encode($signature);
	
	$jwt = "$headers_encoded.$payload_encoded.$signature_encoded";
	
	return $jwt;
}

function is_jwt_valid($jwt) {
	$tokenParts = explode('.', $jwt);
	$header = base64_decode($tokenParts[0]);
	$payload = base64_decode($tokenParts[1]);
	$signature_provided = $tokenParts[2];

	$expiration = json_decode($payload)->exp;
	$is_token_expired = ($expiration - time()) < 0;
	
	$base64_url_header = base64url_encode($header);
	$base64_url_payload = base64url_encode($payload);
	// algoritimo utilizado HS256 no token
	$signature = hash_hmac('SHA256', $base64_url_header . "." . $base64_url_payload, SECRET, true);
	$base64_url_signature = base64url_encode($signature);

	$is_signature_valid = ($base64_url_signature === $signature_provided);
	
	if ($is_token_expired || !$is_signature_valid) {
		return FALSE;
	} else {
		return TRUE;
	}
}
# exemplo
# $headers = array('alg'=>'HS256','typ'=>'JWT');
# $payload = array('nome'=>'teste_payload', 'exp'=>(time() +  (60 * 10))); # 10 minutos
# $jwt = generate_jwt($headers, $payload);
?>