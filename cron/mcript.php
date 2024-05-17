<?php
//ConfiguraciÃ³n del algoritmo de encriptaciÃ³n
//Debes cambiar esta cadena, debe ser larga y unica
//nadie mas debe conocerla
$clave  = 'jo2dulP2t2jauAvUZtbDfEidFXY';
//Metodo de encriptaciÃ³n
$method = 'AES-256-CBC';
// Puedes generar una diferente usando la funcion $getIV()
//$iv = base64_decode("C9fBXl1EWtYTL1ZM8jfstw==");

$secret_iv = '3w8XD|r@n:nxp|oml]nw$-KEc|rT$H).(~ &`gnV!vD0vs|?r]#Zdr-qRlOV@&#6';
$iv = substr(hash('sha256', $secret_iv), 0, 16);
 /*
 Encripta el contenido de la variable, enviada como parametro.
  */
 $encriptar = function ($valor) use ($method, $clave, $iv) {
    //return openssl_encrypt ($valor, $method, $clave, false, $iv);
    $output = openssl_encrypt($valor, $method, $clave, 0, $iv);
    return base64_encode($output);
 };
 /*
 Desencripta el texto recibido
 */
 $desencriptar = function ($valor) use ($method, $clave, $iv) {
     //$encrypted_data = base64_decode($valor);
     //return openssl_decrypt($valor, $method, $clave, false, $iv);
     return openssl_decrypt(base64_decode($valor), $method, $clave, 0, $iv);
 };
 
 $getIV = function () use ($method) {
     return base64_encode(openssl_random_pseudo_bytes(openssl_cipher_iv_length($method)));
 };