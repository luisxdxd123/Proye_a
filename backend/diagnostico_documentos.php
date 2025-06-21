<?php
require_once 'config/db_config.php';

// Script de diagnóstico para verificar la integridad de documentos
echo "<h2>🔍 Diagnóstico de Documentos - Sistema de Solicitudes</h2>";
echo "<style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    .error { color: red; background: #ffe6e6; padding: 10px; margin: 5px 0; border-radius: 5px; }
    .warning { color: orange; background: #fff3cd; padding: 10px; margin: 5px 0; border-radius: 5px; }
    .success { color: green; background: #d4edda; padding: 10px; margin: 5px 0; border-radius: 5px; }
    .info { color: blue; background: #d1ecf1; padding: 10px; margin: 5px 0; border-radius: 5px; }
    table { border-collapse: collapse; width: 100%; margin: 20px 0; }
    th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
    th { background-color: #f2f2f2; }
</style>";

try {
    // 1. Verificar conexión a base de datos
    echo "<div class='success'>✅ Conexión a base de datos exitosa</div>";
    
    // 2. Obtener todas las solicitudes con documentos
    $query = "SELECT 
                s.id,
                s.descripcion,
                s.ine,
                s.curp,
                s.comprobante_domicilio,
                s.documento_adicional,
                s.imagen_adicional,
                u.nombre,
                u.apellido
              FROM solicitudes s
              INNER JOIN usuarios u ON s.usuario_id = u.id
              ORDER BY s.id DESC";
    
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $solicitudes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<div class='info'>📊 Total de solicitudes encontradas: " . count($solicitudes) . "</div>";
    
    // 3. Verificar archivos en el directorio
    $directorio_documentos = __DIR__ . '/../uploads/documentos/';
    $archivos_sistema = [];
    
    if (is_dir($directorio_documentos)) {
        $archivos = scandir($directorio_documentos);
        foreach ($archivos as $archivo) {
            if ($archivo != '.' && $archivo != '..') {
                $archivos_sistema[] = $archivo;
            }
        }
        echo "<div class='success'>📁 Archivos encontrados en el sistema: " . count($archivos_sistema) . "</div>";
    } else {
        echo "<div class='error'>❌ El directorio de documentos no existe: $directorio_documentos</div>";
    }
    
    // 4. Análisis detallado
    $problemas = [];
    $documentos_ok = 0;
    $documentos_faltantes = 0;
    $documentos_vacios = 0;
    
    echo "<h3>📋 Análisis Detallado por Solicitud</h3>";
    echo "<table>";
    echo "<tr><th>ID</th><th>Ciudadano</th><th>INE</th><th>CURP</th><th>Domicilio</th><th>Doc+</th><th>Img+</th><th>Estado</th></tr>";
    
    foreach ($solicitudes as $solicitud) {
        $id = $solicitud['id'];
        $ciudadano = $solicitud['nombre'] . ' ' . $solicitud['apellido'];
        
        $documentos = [
            'ine' => $solicitud['ine'],
            'curp' => $solicitud['curp'],
            'comprobante_domicilio' => $solicitud['comprobante_domicilio'],
            'documento_adicional' => $solicitud['documento_adicional'],
            'imagen_adicional' => $solicitud['imagen_adicional']
        ];
        
        $estado_solicitud = "✅ OK";
        $celdas = [];
        
        foreach ($documentos as $tipo => $archivo) {
            if (empty($archivo) || trim($archivo) === '') {
                $celdas[] = "<td style='background:#f8f9fa;'>-</td>";
                $documentos_vacios++;
            } else {
                $ruta_completa = $directorio_documentos . $archivo;
                if (file_exists($ruta_completa)) {
                    $celdas[] = "<td style='background:#d4edda;'>✅</td>";
                    $documentos_ok++;
                } else {
                    $celdas[] = "<td style='background:#f8d7da;'>❌</td>";
                    $documentos_faltantes++;
                    $estado_solicitud = "⚠️ Problemas";
                    $problemas[] = [
                        'solicitud_id' => $id,
                        'ciudadano' => $ciudadano,
                        'tipo' => $tipo,
                        'archivo' => $archivo,
                        'problema' => 'Archivo no encontrado'
                    ];
                }
            }
        }
        
        echo "<tr>";
        echo "<td>$id</td>";
        echo "<td>$ciudadano</td>";
        echo implode('', $celdas);
        echo "<td>$estado_solicitud</td>";
        echo "</tr>";
    }
    
    echo "</table>";
    
    // 5. Resumen de estadísticas
    echo "<h3>📈 Resumen de Estadísticas</h3>";
    echo "<div class='success'>✅ Documentos correctos: $documentos_ok</div>";
    echo "<div class='warning'>⚠️ Documentos faltantes: $documentos_faltantes</div>";
    echo "<div class='info'>📄 Campos vacíos (normal): $documentos_vacios</div>";
    
    // 6. Listado de problemas específicos
    if (!empty($problemas)) {
        echo "<h3>🚨 Problemas Detectados</h3>";
        echo "<table>";
        echo "<tr><th>Solicitud</th><th>Ciudadano</th><th>Tipo Doc</th><th>Archivo</th><th>Problema</th></tr>";
        
        foreach ($problemas as $problema) {
            echo "<tr>";
            echo "<td>{$problema['solicitud_id']}</td>";
            echo "<td>{$problema['ciudadano']}</td>";
            echo "<td>{$problema['tipo']}</td>";
            echo "<td>{$problema['archivo']}</td>";
            echo "<td>{$problema['problema']}</td>";
            echo "</tr>";
        }
        
        echo "</table>";
    } else {
        echo "<div class='success'>🎉 ¡No se encontraron problemas! Todos los documentos están correctos.</div>";
    }
    
    // 7. Archivos huérfanos (en sistema pero no en BD)
    echo "<h3>🔍 Verificación de Archivos Huérfanos</h3>";
    $archivos_bd = [];
    
    foreach ($solicitudes as $solicitud) {
        $documentos = [$solicitud['ine'], $solicitud['curp'], $solicitud['comprobante_domicilio'], 
                      $solicitud['documento_adicional'], $solicitud['imagen_adicional']];
        foreach ($documentos as $archivo) {
            if (!empty($archivo) && trim($archivo) !== '') {
                $archivos_bd[] = trim($archivo);
            }
        }
    }
    
    $archivos_huerfanos = array_diff($archivos_sistema, $archivos_bd);
    
    if (!empty($archivos_huerfanos)) {
        echo "<div class='warning'>⚠️ Archivos en el sistema sin referencia en BD (" . count($archivos_huerfanos) . "):</div>";
        echo "<ul>";
        foreach ($archivos_huerfanos as $huerfano) {
            echo "<li>$huerfano</li>";
        }
        echo "</ul>";
    } else {
        echo "<div class='success'>✅ No hay archivos huérfanos</div>";
    }
    
    // 8. Recomendaciones
    echo "<h3>💡 Recomendaciones</h3>";
    
    if ($documentos_faltantes > 0) {
        echo "<div class='warning'>
            🔧 <strong>Acción requerida:</strong> Hay $documentos_faltantes documentos faltantes. 
            Esto puede causar errores al intentar visualizar documentos. 
            <br><strong>Solución:</strong> Contactar a los ciudadanos para que vuelvan a subir los documentos faltantes.
        </div>";
    }
    
    if (!empty($archivos_huerfanos)) {
        echo "<div class='info'>
            🧹 <strong>Limpieza opcional:</strong> Hay " . count($archivos_huerfanos) . " archivos que no están referenciados en la base de datos. 
            Pueden ser eliminados para liberar espacio, pero verificar antes que no sean necesarios.
        </div>";
    }
    
    echo "<div class='info'>
        📝 <strong>Mantenimiento:</strong> Se recomienda ejecutar este diagnóstico periódicamente para mantener la integridad del sistema.
    </div>";
    
} catch (PDOException $e) {
    echo "<div class='error'>❌ Error de base de datos: " . $e->getMessage() . "</div>";
} catch (Exception $e) {
    echo "<div class='error'>❌ Error general: " . $e->getMessage() . "</div>";
}

echo "<hr>";
echo "<p><em>Diagnóstico ejecutado el: " . date('Y-m-d H:i:s') . "</em></p>";
?> 