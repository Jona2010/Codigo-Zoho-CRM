<?php

function insert_lead($access_token, $data) {
    // URL del API de Zoho CRM
    $url = "https://www.zohoapis.com/crm/v2/Leads";

    // Cabeceras de la solicitud
    $headers = array(
        'Authorization: Zoho-oauthtoken ' . $access_token,
        'Content-type: application/json',
    );

    // Datos del lead en formato JSON
    $lead_data = json_encode(array("data" => array($data)));

    // Inicializar CURL
    $ch = curl_init();

    // Establecer la URL
    curl_setopt($ch, CURLOPT_URL, $url);
    
    // Establecer el método POST
    curl_setopt($ch, CURLOPT_POST, true);

    // Establecer los datos de la solicitud
    curl_setopt($ch, CURLOPT_POSTFIELDS, $lead_data);

    // Establecer las cabeceras de la solicitud
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    // Solicitar que se devuelva la respuesta
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Ignorar la verificación SSL (ajustar en función de los requisitos de seguridad)
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    // Ejecutar la solicitud
    $response = curl_exec($ch);

    // Verificar si hay errores
    if ($response === false) {
        // Manejar el error de CURL
        return "Error al insertar el lead: " . curl_error($ch);
    }

    // Decodificar la respuesta (probablemente sigue siendo JSON)
    $response = json_decode($response, true);

    // Verificar si hay un error en la respuesta
    if (isset($response["data"][0]["details"]["id"])) {
        // Si la solicitud fue exitosa, devolver el ID del lead
        return $response["data"][0]["details"]["id"];
    } elseif (isset($response["code"])) {
        // Devolver un mensaje de error
        return "Error al insertar el lead: " . $response["message"];
    } else {
        // Si no hay error ni ID, devuelve un mensaje de error desconocido
        return "Error desconocido al insertar el lead";
    }

    // Cerrar CURL
    curl_close($ch);
}

// Ejemplo de uso
$access_token = "1000.37b54c54eb2b251393a4f35f7327d376.5068baf4634853526e4b877af436dc6b";
$data = array(
    "Company" => "Empresa",
    "Last_Name" => "Apellido",
    "First_Name" => "Nombre",
    "Email" => "prueba@correo.com",
    "State" => "Estado",
    "Phone" => "987654321",
    "Description" => "PRUEBA",
);

$lead_id = insert_lead($access_token, $data);

echo "ID del lead insertado: " . $lead_id;

?>