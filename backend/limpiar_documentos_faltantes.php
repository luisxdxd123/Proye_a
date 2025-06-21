<?php
require_once 'config/db_config.php';

// Script para limpiar referencias a documentos faltantes
echo "<h2>🧹 Limpieza de Referencias a Documentos Faltantes</h2>";
echo "<style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    .error { color: red; background: #ffe6e6; padding: 10px; margin: 5px 0; border-radius: 5px; }
    .warning { color: orange; background: #fff3cd; padding: 10px; margin: 5px 0; border-radius: 5px; }
    .success { color: green; background: #d4edda; padding: 10px; margin: 5px 0; border-radius: 5px; }
    .info { color: blue; background: #d1ecf1; padding: 10px; margin: 5px 0; border-radius: 5px; }
</style>";

// Verificar si se debe ejecutar la limpieza
$ejecutar = isset($_GET['ejecutar']) && $_GET['ejecutar'] === 'si';

if (!$ejecutar) {
    echo "<div class='warning'>
        ⚠️ <strong>ADVERTENCIA:</strong> Este script limpiará las referencias a documentos faltantes en la base de datos.
        <br><br>
        <strong>¿Qué hará?</strong>
        <ul>
            <li>Identificará documentos referenciados en la BD que no existen en el sistema de archivos</li>
            <li>Establecerá esos campos como NULL en la base de datos</li>
            <li>Esto evitará errores al intentar abrir documentos inexistentes</li>
        </ul>
        <br>
        <a href='?ejecutar=si' style='background:#dc3545;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;'>
            🧹 Ejecutar Limpieza
        </a>
        <br><br>
        <em>Nota: Es recomendable hacer un backup de la base de datos antes de ejecutar esta operación.</em>
    </div>";
    exit;
}

try {
    echo "<div class='info'>🔄 Iniciando proceso de limpieza...</div>";
    
    // Obtener todas las solicitudes
    $query = "SELECT 
                id,
                ine,
                curp,
                comprobante_domicilio,
                documento_adicional,
                imagen_adicional
              FROM solicitudes";
    
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $solicitudes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $directorio_documentos = __DIR__ . '/../uploads/documentos/';
    $campos_limpiados = 0;
    $solicitudes_afectadas = [];
    
    foreach ($solicitudes as $solicitud) {
        $id = $solicitud['id'];
        $campos_a_limpiar = [];
        
        $documentos = [
            'ine' => $solicitud['ine'],
            'curp' => $solicitud['curp'],
            'comprobante_domicilio' => $solicitud['comprobante_domicilio'],
            'documento_adicional' => $solicitud['documento_adicional'],
            'imagen_adicional' => $solicitud['imagen_adicional']
        ];
        
        foreach ($documentos as $campo => $archivo) {
            if (!empty($archivo) && trim($archivo) !== '') {
                $ruta_completa = $directorio_documentos . trim($archivo);
                if (!file_exists($ruta_completa)) {
                    $campos_a_limpiar[] = $campo;
                    echo "<div class='warning'>❌ Solicitud $id: Campo '$campo' -> '$archivo' (no existe)</div>";
                }
            }
        }
        
        // Limpiar campos faltantes
        if (!empty($campos_a_limpiar)) {
            $solicitudes_afectadas[] = $id;
            
            foreach ($campos_a_limpiar as $campo) {
                $update_query = "UPDATE solicitudes SET $campo = NULL WHERE id = ?";
                $update_stmt = $conn->prepare($update_query);
                $update_stmt->execute([$id]);
                $campos_limpiados++;
                
                echo "<div class='success'>✅ Solicitud $id: Campo '$campo' limpiado</div>";
            }
        }
    }
    
    // Resumen
    echo "<h3>📊 Resumen de Limpieza</h3>";
    echo "<div class='success'>✅ Campos limpiados: $campos_limpiados</div>";
    echo "<div class='info'>📋 Solicitudes afectadas: " . count($solicitudes_afectadas) . "</div>";
    
    if (!empty($solicitudes_afectadas)) {
        echo "<div class='info'>🔢 IDs de solicitudes modificadas: " . implode(', ', $solicitudes_afectadas) . "</div>";
    }
    
    echo "<div class='success'>
        🎉 <strong>Limpieza completada exitosamente!</strong>
        <br><br>
        <strong>Resultado:</strong> Ahora todos los botones de documentos en el dashboard de presidencia solo mostrarán documentos que realmente existen.
        <br><br>
        <a href='diagnostico_documentos.php' style='background:#28a745;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;'>
            🔍 Ejecutar Nuevo Diagnóstico
        </a>
    </div>";
    
} catch (PDOException $e) {
    echo "<div class='error'>❌ Error de base de datos: " . $e->getMessage() . "</div>";
} catch (Exception $e) {
    echo "<div class='error'>❌ Error general: " . $e->getMessage() . "</div>";
}

echo "<hr>";
echo "<p><em>Limpieza ejecutada el: " . date('Y-m-d H:i:s') . "</em></p>";
?> 