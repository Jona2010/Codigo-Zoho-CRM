<?php

function generate_access_token($refresh_token, $client_id, $client_secret, $grant_type) {

    // URL del API de Zoho CRM
    $url = "https://accounts.zoho.com/oauth/v2/token";

    // Cabeceras de la solicitud
    $headers = array(
        "Content-type: application/x-www-form-urlencoded",
        "Authorization: Basic " . base64_encode($client_id . ":" . $client_secret),
    );

    // Opciones de CURL
    $options = array(
        CURLOPT_URL => $url,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_POSTFIELDS => http_build_query(array(
            "grant_type" => $grant_type,
            "refresh_token" => $refresh_token,
        )),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
    );

    // Inicializar CURL
    $ch = curl_init();

    // Establecer opciones de CURL
    curl_setopt_array($ch, $options);

    // Ejecutar la solicitud
    $response = curl_exec($ch);

    // Cerrar CURL
    curl_close($ch);

    // Decodificar la respuesta JSON
    $response = json_decode($response, true);

    // Si la solicitud fue exitosa, devolver el token de acceso
    if (isset($response["access_token"])) {
        return $response["access_token"];
    } else {
        // Devolver un mensaje de error
        return "Error al generar el token de acceso: " . $response["error"];
    }
}

// Ejemplo de uso
$refresh_token = "1000.e16a65786f08d1cb862dc90fa9a8400a.e171644792fa0011d497d6c3589958c3";
$client_id = "1000.4VN9H0JSJZQTSFF9C50KC29RDCPC7X";
$client_secret = "a1205da3b0da7c67a18edb2009e3b4d3e6c5f29f09";
$grant_type = "refresh_token";

$access_token = generate_access_token($refresh_token, $client_id, $client_secret, $grant_type);

echo "**Token de acceso:** " . $access_token;

?>
