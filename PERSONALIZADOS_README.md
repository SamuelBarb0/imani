# Sistema de Imanes Personalizados - Imani Magnets

## Resumen

Sistema completo para que los clientes suban 9 fotos, las editen, y generen un template listo para impresión con las posiciones exactas especificadas por el cliente.

## Especificaciones del Cliente

### Posiciones de las 9 Imágenes (en píxeles)
```python
POSITIONS = [
    (113, 263),    # Imagen 1 - Fila 1, Columna 1
    (915, 263),    # Imagen 2 - Fila 1, Columna 2
    (1718, 263),   # Imagen 3 - Fila 1, Columna 3
    (113, 1418),   # Imagen 4 - Fila 2, Columna 1
    (915, 1418),   # Imagen 5 - Fila 2, Columna 2
    (1718, 1418),  # Imagen 6 - Fila 2, Columna 3
    (113, 2573),   # Imagen 7 - Fila 3, Columna 1
    (915, 2573),   # Imagen 8 - Fila 3, Columna 2
    (1718, 2573)   # Imagen 9 - Fila 3, Columna 3
]
```

### Posiciones de los Números de Orden (en píxeles)
```python
TEXT_POSITIONS = [
    (90, 638),     # Texto para Imagen 1
    (892, 638),    # Texto para Imagen 2
    (1695, 638),   # Texto para Imagen 3
    (90, 1791),    # Texto para Imagen 4
    (892, 1791),   # Texto para Imagen 5
    (1695, 1791),  # Texto para Imagen 6
    (90, 2945),    # Texto para Imagen 7
    (892, 2945),   # Texto para Imagen 8
    (1695, 2945)   # Texto para Imagen 9
]
```

### Dimensiones
- **Cada imagen**: 644x644 píxeles
- **Template final**: 2400x3250 píxeles
- **Formato de salida**: PNG de alta calidad

## Arquitectura del Sistema

### Frontend ([resources/views/personalizados/index.blade.php](resources/views/personalizados/index.blade.php))

1. **Paso 1: Upload**
   - Drag & drop o selección de archivos
   - Soporta PNG, JPG, JPEG
   - Barra de progreso
   - Validación de 9 imágenes máximo

2. **Paso 2: Editor**
   - Grid 3x3 interactivo
   - Editor modal con Fabric.js
   - Herramientas:
     - Rotar 90°
     - Duplicar imagen
     - Eliminar
     - Zoom/Pan (arrastrando la imagen)
   - Guías visuales: borde exterior (644x644px) y área visible (600x600px)
   - Contador de imágenes listas (0/9)

3. **Paso 3: Generación**
   - Botón "GENERAR TEMPLATE" (se activa cuando hay 9 imágenes editadas)
   - Modal de procesamiento con spinner
   - Modal de éxito con número de orden y enlace de descarga

### Backend

#### Rutas ([routes/web.php](routes/web.php:13-14))
```php
Route::get('/personalizados', [PersonalizadosController::class, 'index']);
Route::post('/personalizados/process', [PersonalizadosController::class, 'processImages']);
Route::get('/personalizados/download/{orderNumber}', [PersonalizadosController::class, 'download']);
```

#### Controlador ([app/Http/Controllers/PersonalizadosController.php](app/Http/Controllers/PersonalizadosController.php))

**Método `processImages()`**:
1. Valida las 9 imágenes en base64
2. Genera número de orden único (formato: IM-XXXXXXXX)
3. Crea directorio `storage/app/public/orders/{orderNumber}/`
4. Guarda cada imagen individual como `image_0.png` a `image_8.png`
5. Llama al servicio `TemplateGeneratorService` para generar el template final
6. Crea registro en base de datos con toda la información
7. Retorna JSON con número de orden y URL de descarga

**Método `download()`**:
- Busca el pedido por número de orden
- Descarga el archivo `template_final.png`

#### Servicio ([app/Services/TemplateGeneratorService.php](app/Services/TemplateGeneratorService.php))

**Método `generateTemplate()`**:
1. Crea imagen en blanco de 2400x3250px con fondo blanco
2. Itera sobre las 9 imágenes:
   - Carga la imagen desde storage
   - Redimensiona a exactamente 644x644px
   - La posiciona en las coordenadas especificadas
   - Agrega el número de orden en la posición del texto
3. Guarda como `template_final.png` con máxima calidad
4. Retorna la ruta del archivo

**Funciones auxiliares**:
- `loadImage()`: Soporta JPEG, PNG, GIF, WebP
- `addImageToTemplate()`: Procesa y posiciona cada imagen
- `addOrderNumberText()`: Agrega el número de orden (usa TTF si está disponible, o fuente built-in)

#### Modelo ([app/Models/Order.php](app/Models/Order.php))

```php
$order = [
    'order_number' => 'IM-XXXXXXXX',  // Único
    'customer_email' => nullable,
    'customer_name' => nullable,
    'status' => 'pending|processing|completed|cancelled',
    'images_data' => json,  // Array de rutas a las imágenes individuales
    'final_template_path' => string,  // Ruta al template generado
    'total_price' => decimal
];
```

## Flujo Completo

```
1. Usuario sube 9 fotos
   ↓
2. Usuario edita cada foto (rotar, ajustar, zoom)
   ↓
3. Click en "GENERAR TEMPLATE"
   ↓
4. Frontend envía las 9 imágenes editadas (base64) vía AJAX
   ↓
5. Backend valida y genera número de orden
   ↓
6. Se guardan las imágenes individuales en storage
   ↓
7. TemplateGeneratorService crea el template final:
   - Canvas 2400x3250px
   - Coloca cada imagen en su posición exacta
   - Agrega número de orden 9 veces
   ↓
8. Se guarda en DB y retorna URL de descarga
   ↓
9. Usuario ve modal de éxito y puede descargar
```

## Archivos Creados/Modificados

### Nuevos Archivos
- `app/Models/Order.php`
- `app/Http/Controllers/PersonalizadosController.php`
- `app/Services/TemplateGeneratorService.php`
- `database/migrations/2025_10_20_195052_create_orders_table.php`

### Archivos Modificados
- `routes/web.php` - Agregadas rutas de personalizados
- `resources/views/personalizados/index.blade.php` - Vista completa con editor

## Comandos Útiles

```bash
# Ver rutas
php artisan route:list --name=personalizados

# Ver pedidos en DB
php artisan tinker
>>> Order::all()

# Limpiar storage (cuidado!)
rm -rf storage/app/public/orders/*

# Re-crear enlace simbólico
php artisan storage:link
```

## Testing

### Manual
1. Ir a `http://localhost:8000/personalizados`
2. Subir 9 fotos
3. Editar cada una (al menos rotar o hacer zoom)
4. Click "GENERAR TEMPLATE"
5. Descargar el PNG generado
6. Verificar:
   - Las 9 imágenes están en las posiciones correctas
   - El número de orden aparece 9 veces
   - Dimensiones: 2400x3250px

### Automated (por hacer)
```bash
php artisan test --filter PersonalizadosTest
```

## Mejoras Futuras

1. **Editor avanzado**:
   - Filtros (blanco y negro, sepia)
   - Crop manual
   - Brillo/contraste

2. **Funcionalidades**:
   - Guardar borrador (no generar aún)
   - Compartir via email
   - Historial de pedidos del usuario

3. **Backend**:
   - Queue job para procesar imágenes grandes
   - Notificación por email cuando esté listo
   - Webhook para integración con imprenta

4. **Validaciones**:
   - Resolución mínima de imágenes
   - Compresión automática si son muy grandes
   - Detección de rostros para sugerir zoom

## Soporte Técnico

### Requisitos del Servidor
- PHP 8.2+ con extensión GD habilitada
- SQLite o MySQL
- Storage writable en `storage/app/public/`

### Verificar GD
```bash
php -m | grep -i gd
# Debe mostrar: gd
```

### Si GD no está instalado (XAMPP)
Ya debería venir incluido, pero verificar en `php.ini`:
```ini
extension=gd
```

## Créditos

Desarrollado para **Imani Magnets**
Fecha: Octubre 2025