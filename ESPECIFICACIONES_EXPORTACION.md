# Especificaciones de Exportación - Template de 9 Imanes

Este documento describe las especificaciones exactas para la generación del template PNG final con 9 imágenes personalizadas, basado en el script Python del cliente (`pegar_fotos_interactivo_pro9.py`).

## 📐 Dimensiones

### Imágenes Individuales
- **Tamaño de recorte exterior**: `644x644 px`
- **Área de impresión (interior)**: `600x600 px`
- **Margen de seguridad**: `22 px` por cada lado
  - Cálculo: `(644 - 600) / 2 = 22 px`

### Canvas Final de Composición
- **Ancho total**: `2339 px`
- **Alto total**: `3589 px`
- **Formato de salida**: PNG con calidad máxima

## 📍 Posiciones de las 9 Imágenes

Cada imagen de 644x644px se coloca en las siguientes coordenadas (x, y) del canvas final:

```javascript
const POSITIONS = [
    { x: 90, y: 638 },    // Imagen 1 - Superior izquierda
    { x: 892, y: 638 },   // Imagen 2 - Superior centro
    { x: 1695, y: 638 },  // Imagen 3 - Superior derecha
    { x: 90, y: 1791 },   // Imagen 4 - Media izquierda
    { x: 892, y: 1791 },  // Imagen 5 - Media centro
    { x: 1695, y: 1791 }, // Imagen 6 - Media derecha
    { x: 90, y: 2945 },   // Imagen 7 - Inferior izquierda
    { x: 892, y: 2945 },  // Imagen 8 - Inferior centro
    { x: 1695, y: 2945 }  // Imagen 9 - Inferior derecha
];
```

## 🎯 Distribución Visual

```
┌────────────────────────────────────────────────────────┐
│                    Canvas: 2339 x 3589 px              │
│                                                         │
│              [NÚMERO DE ORDEN: IM-XXXXXXXX]            │
│                                                         │
│   (90,638)         (892,638)        (1695,638)         │
│   ┌ ─ ─ ─ ─ ┐     ┌ ─ ─ ─ ─ ┐     ┌ ─ ─ ─ ─ ┐  644x644│
│   │ ┌─────┐ │     │ ┌─────┐ │     │ ┌─────┐ │  (gris) │
│   │ │ ┊ ┊ │ │     │ │ ┊ ┊ │ │     │ │ ┊ ┊ │ │  600x600│
│   │ │─┼─┼─│ │     │ │─┼─┼─│ │     │ │─┼─┼─│ │  (turq) │
│   │ │ ┊ ┊ │ │     │ │ ┊ ┊ │ │     │ │ ┊ ┊ │ │  +grid  │
│   │ └─────┘ │     │ └─────┘ │     │ └─────┘ │         │
│   └ ─ ─ ─ ─ ┘     └ ─ ─ ─ ─ ┘     └ ─ ─ ─ ─ ┘         │
│    Imagen 1        Imagen 2        Imagen 3            │
│                                                         │
│   (90,1791)        (892,1791)       (1695,1791)        │
│   ┌ ─ ─ ─ ─ ┐     ┌ ─ ─ ─ ─ ┐     ┌ ─ ─ ─ ─ ┐         │
│   │ ┌─────┐ │     │ ┌─────┐ │     │ ┌─────┐ │         │
│   │ │ ┊ ┊ │ │     │ │ ┊ ┊ │ │     │ │ ┊ ┊ │ │         │
│   │ │─┼─┼─│ │     │ │─┼─┼─│ │     │ │─┼─┼─│ │         │
│   │ │ ┊ ┊ │ │     │ │ ┊ ┊ │ │     │ │ ┊ ┊ │ │         │
│   │ └─────┘ │     │ └─────┘ │     │ └─────┘ │         │
│   └ ─ ─ ─ ─ ┘     └ ─ ─ ─ ─ ┘     └ ─ ─ ─ ─ ┘         │
│    Imagen 4        Imagen 5        Imagen 6            │
│                                                         │
│   (90,2945)        (892,2945)       (1695,2945)        │
│   ┌ ─ ─ ─ ─ ┐     ┌ ─ ─ ─ ─ ┐     ┌ ─ ─ ─ ─ ┐         │
│   │ ┌─────┐ │     │ ┌─────┐ │     │ ┌─────┐ │         │
│   │ │ ┊ ┊ │ │     │ │ ┊ ┊ │ │     │ │ ┊ ┊ │ │         │
│   │ │─┼─┼─│ │     │ │─┼─┼─│ │     │ │─┼─┼─│ │         │
│   │ │ ┊ ┊ │ │     │ │ ┊ ┊ │ │     │ │ ┊ ┊ │ │         │
│   │ └─────┘ │     │ └─────┘ │     │ └─────┘ │         │
│   └ ─ ─ ─ ─ ┘     └ ─ ─ ─ ─ ┘     └ ─ ─ ─ ─ ┘         │
│    Imagen 7        Imagen 8        Imagen 9            │
│                                                         │
└────────────────────────────────────────────────────────┘

Leyenda:
  ─ ─ ─ ─  = Borde exterior 644x644px (gris claro)
  ─────────  = Borde interior 600x600px (turquesa)
  ┊ y ─     = Grid de tercios (gris, 50% opacidad)
```

## 📏 Cálculos de Espaciado

### Espaciado Horizontal
- **Distancia entre columnas**:
  - Columna 1 a Columna 2: `892 - 90 = 802 px`
  - Columna 2 a Columna 3: `1695 - 892 = 803 px`
  - Promedio: ~`802 px` entre bordes izquierdos

- **Espacio entre imágenes**:
  - `802 - 644 = 158 px` de separación

### Espaciado Vertical
- **Distancia entre filas**:
  - Fila 1 a Fila 2: `1791 - 638 = 1153 px`
  - Fila 2 a Fila 3: `2945 - 1791 = 1154 px`
  - Promedio: ~`1153 px` entre bordes superiores

- **Espacio entre imágenes**:
  - `1153 - 644 = 509 px` de separación vertical

### Márgenes del Canvas
- **Margen superior**: `638 px` (espacio para el número de orden)
- **Margen izquierdo**: `90 px`
- **Margen derecho**: `2339 - (1695 + 644) = 0 px`
- **Margen inferior**: `3589 - (2945 + 644) = 0 px`

## 🔢 Número de Orden

El número de orden se agrega automáticamente en el canvas final:

- **Posición**: Centrado horizontalmente, `50px` desde la parte superior
- **Formato**: `IM-XXXXXXXX` (8 caracteres aleatorios)
- **Fuente**: Arial Bold, 48px
- **Color**: `#12463c` (turquesa de la marca Imani)

## 📏 Guías Visuales en el PNG Final

Cada imagen incluye guías visuales para facilitar el corte y la impresión:

### Borde Exterior (644x644px)
- **Color**: Gris claro `#CCCCCC`
- **Estilo**: Línea punteada (dash: 5, 5)
- **Grosor**: 2px
- **Propósito**: Marca el área total de corte de cada imagen

### Borde Interior (600x600px)
- **Color**: Turquesa `#12463c` (color de marca)
- **Estilo**: Línea punteada (dash: 5, 5)
- **Grosor**: 2px
- **Margen**: 22px desde cada borde exterior
- **Propósito**: Marca el área de impresión segura (safe zone)

### Grid de Tercios (Regla de Tercios)
- **Color**: Gris medio `#888888`
- **Estilo**: Línea punteada (dash: 3, 3)
- **Grosor**: 1px
- **Opacidad**: 50%
- **Ubicación**: Dentro del área de 600x600px
- **Propósito**: Guía de composición visual (2 líneas verticales + 2 horizontales)

## 🔧 Implementación Técnica

### Frontend (Fabric.js)
```javascript
// Crear canvas de composición
const fabricCanvas = new fabric.Canvas(null, {
    width: 2362,
    height: 3217,
    backgroundColor: '#ffffff'
});

// Cargar y posicionar cada imagen 644x644px
POSITIONS.forEach((pos, index) => {
    fabric.Image.fromURL(editedImages[index], (img) => {
        img.set({
            left: pos.x,
            top: pos.y,
            scaleX: 1,  // Ya son 644x644px
            scaleY: 1,
            selectable: false,
            evented: false
        });
        fabricCanvas.add(img);
    });
});

// Exportar como PNG
const finalPNG = fabricCanvas.toDataURL({
    format: 'png',
    quality: 1,
    multiplier: 1
});
```

### Backend (Laravel - Procesamiento)
El PNG final se envía al backend para:
1. Guardar en `storage/app/orders/ORDER_NUMBER.png`
2. Crear registro en base de datos (`orders` table)
3. Generar número de orden único
4. Enviar confirmación por email (opcional)

## 📝 Notas Importantes

1. **Formato de Imágenes Individuales**:
   - Las imágenes editadas se guardan en formato JPEG (95% calidad) a 644x644px
   - El área de impresión real (600x600px) tiene un margen de 22px para sangrado

2. **Calidad de Exportación**:
   - El PNG final se genera con calidad máxima (`quality: 1`)
   - Tamaño aproximado del archivo: 15-25 MB dependiendo del contenido

3. **Recorte del Usuario**:
   - El usuario ve un recuadro exterior (644x644px - borde blanco)
   - El recuadro interior (600x600px - borde turquesa) marca el área de impresión segura
   - Grid de tercios ayuda a la composición

4. **Compatibilidad**:
   - Las especificaciones son exactamente las mismas que el script Python
   - El PNG generado puede usarse directamente para impresión
   - Compatible con servicios de impresión estándar

## 🎨 Flujo de Trabajo del Usuario

1. **Subir 9 fotos** (JPG/PNG)
2. **Editar cada foto**:
   - Ajustar recorte (644x644px con área segura de 600x600px)
   - Aplicar filtros (brillo, contraste, saturación, etc.)
   - Previsualizar resultado
3. **Generar Template**:
   - Fabric.js compone las 9 imágenes en posiciones exactas
   - Se genera PNG de 2362x3217px
   - Se guarda en el servidor
4. **Descargar o Enviar a Producción**

## 🔗 Archivos Relacionados

- **Vista principal**: `resources/views/personalizados/index.blade.php`
- **Controlador**: `app/Http/Controllers/PersonalizadosController.php`
- **Servicio de procesamiento**: `app/Services/OrderImageProcessor.php`
- **Migración**: `database/migrations/2025_10_20_195052_create_orders_table.php`
- **Modelo**: `app/Models/Order.php`

---

**Última actualización**: 2025-10-21
**Basado en**: `pegar_fotos_interactivo_pro9.py` (versión pro 9, step 0.05)
