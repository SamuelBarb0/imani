<?php

/**
 * Test para descubrir el idPais correspondiente a Ecuador
 * en el endpoint de Servientrega: /api/Cotizador/CiudadesDepartamento/{idPais}/{language}
 */

// Configuración base
$baseUrl = "https://mobile.servientrega.com/ApiIngresoCLientes/api/Cotizador/CiudadesDepartamento";
$language = "es";

// Probamos varios idPais (puedes ampliar el rango si es necesario)
for ($idPais = 1; $idPais <= 20; $idPais++) {

    $url = "{$baseUrl}/{$idPais}/{$language}";

    echo "🔍 Probando idPais={$idPais}...\n";

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_SSL_VERIFYPEER => false,
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode !== 200 || !$response) {
        echo "❌ Sin respuesta o error HTTP {$httpCode}\n\n";
        continue;
    }

    $data = json_decode($response, true);

    if (is_array($data) && count($data) > 0) {
        $first = $data[0];

        echo "✅ Respuesta válida para idPais={$idPais}\n";
        echo "   Ejemplo: " . ($first['Nombre'] ?? json_encode($first)) . "\n";

        // Detección heurística: buscamos palabras clave ecuatorianas
        $ciudades = json_encode($data);
        if (stripos($ciudades, 'Quito') !== false || stripos($ciudades, 'Guayaquil') !== false || stripos($ciudades, 'Cuenca') !== false) {
            echo "🎯 Este idPais probablemente corresponde a **ECUADOR** 🇪🇨\n\n";
            break;
        }

        echo "\n";
    } else {
        echo "⚠️ Respuesta vacía o inesperada.\n\n";
    }

    // Evita saturar el servidor
    sleep(1);
}

echo "🏁 Test finalizado.\n";
