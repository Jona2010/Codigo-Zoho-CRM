<?php

function generate_refresh_token($code, $client_id, $client_secret, $redirect_uri) {

    // URL del API de Zoho CRM
    $url = "https://accounts.zoho.com/oauth/v2/token";

    // Datos de la solicitud
    $data = array(
        "code" => $code,
        "client_id" => $client_id,
        "client_secret" => $client_secret,
        "grant_type" => "authorization_code",
        "redirect_uri" => $redirect_uri,
    );

    // Opciones de CURL
    $options = array(
        CURLOPT_URL => $url,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query($data),
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

    // Si la solicitud fue exitosa, devolver el token de refresco
    if (isset($response["refresh_token"])) {
        return $response["refresh_token"];
    } else {
        // Devolver un mensaje de error
        return "Error al generar el token de refresco: " . $response["error"];
    }
}

// Ejemplo de uso
$code = "1000.b94e81f767c14ad4b16fd9d0ce705c9a.99d074f9c24791a89278071cff1ba3c2";
$client_id = "1000.4VN9H0JSJZQTSFF9C50KC29RDCPC7X";
$client_secret = "a1205da3b0da7c67a18edb2009e3b4d3e6c5f29f09";
$redirect_uri = "https://formacionwp.com";

$refresh_token = generate_refresh_token($code, $client_id, $client_secret, $redirect_uri);

echo "**Token de refresco:** " . $refresh_token;

?>
