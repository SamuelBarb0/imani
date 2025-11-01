# 📝 Sistema de Edición de Contenido - Imani Magnets

## 🎯 Descripción

Este sistema permite editar **todo el contenido de la página web** (textos, imágenes, HTML) desde un panel de administración sin necesidad de tocar código.

## 🚀 Acceso al Editor

1. **URL del Editor**: `/pruebas/admin/contenido/{page}/editar`
   - Editor de Home: `/pruebas/admin/contenido/home/editar`
   - Editor de Personalizados: `/pruebas/admin/contenido/personalizados/editar`
   - Editor de Colecciones: `/pruebas/admin/contenido/colecciones/editar`

2. **Requisitos**: Debes estar autenticado como administrador (middleware `admin`)

## 📚 Estructura de Contenido

El contenido se organiza en tres niveles:

1. **Página** (`page`): Identifica la página (ej: `home`, `personalizados`, `colecciones`)
2. **Sección** (`section`): Agrupa contenidos relacionados (ej: `hero`, `about`, `quote`)
3. **Clave** (`key`): Identifica cada elemento específico (ej: `title`, `subtitle`, `image_1`)

### Tipos de contenido soportados:

- **text**: Texto simple de una línea
- **textarea**: Texto multilínea
- **html**: Código HTML (permite `<br>`, `<strong>`, `<em>`, etc.)
- **image**: Ruta de imagen (ej: `images/foto.jpg`)

## 💻 Cómo Usar en las Vistas (Blade)

### Método 1: Helper `content()`

```blade
{!! content('home', 'hero', 'title_line1', 'Texto por defecto') !!}
```

**Parámetros:**
- `$page`: Nombre de la página (`'home'`, `'personalizados'`, etc.)
- `$section`: Nombre de la sección (`'hero'`, `'about'`, etc.)
- `$key`: Clave del elemento (`'title'`, `'subtitle'`, etc.)
- `$default`: Texto por defecto si no existe (opcional)

**Importante:**
- Usa `{!! !!}` para renderizar HTML
- Usa `{{ }}` para texto plano (escapado)

### Método 2: Modelo directo

```blade
{!! \App\Models\PageContent::get('home', 'hero', 'subtitle', 'Default text') !!}
```

## 📝 Ejemplo Completo: Convertir una Vista

### ❌ ANTES (Contenido hardcodeado):

```blade
<h1 class="text-3xl font-bold">
    DE MOMENTOS<br>
    A <span>Imanes</span>
</h1>
<p class="text-lg">
    Tus recuerdos más especiales convertidos en piezas únicas
</p>
```

### ✅ DESPUÉS (Contenido editable):

```blade
<h1 class="text-3xl font-bold">
    {!! content('home', 'hero', 'title_line1', 'DE MOMENTOS') !!}<br>
    A <span>{!! content('home', 'hero', 'title_line2', 'Imanes') !!}</span>
</h1>
<p class="text-lg">
    {!! content('home', 'hero', 'subtitle', 'Tus recuerdos más especiales...') !!}
</p>
```

## 🖼️ Manejo de Imágenes

### En las vistas:

```blade
<img src="{{ asset(content('home', 'hero', 'slide_1', 'images/default.jpg')) }}" alt="Hero">
```

### En el editor:

1. Ingresa la ruta relativa: `images/mi-foto.jpg`
2. El archivo debe estar en `public/images/mi-foto.jpg`
3. Para cambiar: sube el archivo nuevo a `public/images/` y actualiza la ruta

## 🔧 Agregar Nuevo Contenido Editable

### Paso 1: Crear el registro en la base de datos

```php
// Opción A: Manualmente en el seeder
PageContent::create([
    'page' => 'home',
    'section' => 'nueva_seccion',
    'key' => 'nuevo_texto',
    'type' => 'text',
    'value' => 'Contenido inicial',
    'order' => 50,
]);
```

```php
// Opción B: Usar el método set()
\App\Models\PageContent::set('home', 'nueva_seccion', 'nuevo_texto', 'Contenido inicial', 'text');
```

### Paso 2: Usar en la vista

```blade
<p>{!! content('home', 'nueva_seccion', 'nuevo_texto', 'Default') !!}</p>
```

## 🎨 Buenas Prácticas

### 1. Nomenclatura Clara

```php
// ✅ BIEN - Descriptivo y claro
content('home', 'hero', 'cta_button_text')
content('about', 'team', 'member_1_name')

// ❌ MAL - Vago y confuso
content('home', 'section1', 'txt1')
```

### 2. Valores por Defecto

Siempre proporciona un valor por defecto para evitar pantallas vacías:

```blade
{!! content('home', 'hero', 'title', 'Bienvenido a Imani Magnets') !!}
```

### 3. Agrupación Lógica

Agrupa contenido relacionado en la misma sección:

```php
// Sección 'hero' para contenido principal
content('home', 'hero', 'title')
content('home', 'hero', 'subtitle')
content('home', 'hero', 'cta_text')

// Sección 'about' para contenido "acerca de"
content('home', 'about', 'greeting')
content('home', 'about', 'intro_text')
```

## 🗄️ Base de Datos

### Tabla: `page_contents`

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `id` | bigint | ID único |
| `page` | string | Nombre de la página |
| `section` | string | Sección dentro de la página |
| `key` | string | Identificador del contenido |
| `type` | string | Tipo: text, textarea, image, html |
| `value` | text | El contenido actual |
| `order` | int | Orden de visualización |
| `created_at` | timestamp | Fecha de creación |
| `updated_at` | timestamp | Última actualización |

### Índices:
- Único: `[page, section, key]` - Evita duplicados
- Índices individuales en `page`, `section`, `key` para consultas rápidas

## ⚡ Caché

El sistema usa caché para optimizar el rendimiento:

- **Duración**: 1 hora (3600 segundos)
- **Limpieza automática**: Al guardar cambios en el editor
- **Limpiar manualmente**:

```php
\App\Models\PageContent::clearCache();
```

## 🔒 Seguridad

- ✅ Solo administradores pueden editar (middleware `admin`)
- ✅ Validación de datos en el controlador
- ✅ Protección CSRF en formularios
- ✅ Sanitización de HTML en inputs tipo `html`

## 📋 Comandos Útiles

```bash
# Limpiar caché de contenido
php artisan cache:clear

# Resetear contenido a valores iniciales
php artisan db:seed --class=PageContentSeeder

# Ver todos los contenidos de una página
php artisan tinker
>>> \App\Models\PageContent::where('page', 'home')->get();
```

## 🆘 Troubleshooting

### Problema: "Los cambios no se ven"
**Solución:** Limpia el caché:
```bash
php artisan cache:clear
```

### Problema: "No aparece en el editor"
**Verificación:**
1. ¿Existe el registro en la base de datos?
2. ¿El `page` coincide exactamente con la URL?
3. ¿Ejecutaste el seeder?

```bash
php artisan db:seed --class=PageContentSeeder
```

### Problema: "Error 500 al guardar"
**Posibles causas:**
1. Validación fallida (revisa los nombres de campos)
2. Constraint de unicidad duplicada
3. Permisos de escritura en storage

## 🎓 Ejemplo de Integración Completa

### Vista: `resources/views/home/index.blade.php`

```blade
<!-- Hero Section -->
<section class="hero">
    <h1>{!! content('home', 'hero', 'title_line1') !!}</h1>
    <h2>{!! content('home', 'hero', 'title_line2') !!}</h2>
    <p>{!! content('home', 'hero', 'subtitle') !!}</p>

    <a href="{{ content('home', 'hero', 'cta_link', '/personalizados') }}">
        {!! content('home', 'hero', 'cta_text', 'DISEÑA TUS IMANES') !!}
    </a>

    <img src="{{ asset(content('home', 'hero', 'slide_1')) }}" alt="Slide 1">
</section>

<!-- Quote Section -->
<section class="quote">
    <p class="quote-text">{!! content('home', 'quote', 'quote_text') !!}</p>
    <p class="quote-desc">{!! content('home', 'quote', 'quote_description') !!}</p>
</section>
```

### Seeder: `database/seeders/PageContentSeeder.php`

```php
PageContent::create([
    'page' => 'home',
    'section' => 'hero',
    'key' => 'title_line1',
    'type' => 'text',
    'value' => 'DE MOMENTOS',
    'order' => 1,
]);

PageContent::create([
    'page' => 'home',
    'section' => 'hero',
    'key' => 'title_line2',
    'type' => 'text',
    'value' => 'Imanes',
    'order' => 2,
]);

PageContent::create([
    'page' => 'home',
    'section' => 'hero',
    'key' => 'subtitle',
    'type' => 'textarea',
    'value' => 'Tus recuerdos más especiales...',
    'order' => 3,
]);

PageContent::create([
    'page' => 'home',
    'section' => 'hero',
    'key' => 'cta_text',
    'type' => 'text',
    'value' => 'DISEÑA TUS IMANES',
    'order' => 4,
]);

PageContent::create([
    'page' => 'home',
    'section' => 'hero',
    'key' => 'cta_link',
    'type' => 'text',
    'value' => '/personalizados',
    'order' => 5,
]);

PageContent::create([
    'page' => 'home',
    'section' => 'hero',
    'key' => 'slide_1',
    'type' => 'image',
    'value' => 'images/IMG-20251016-WA0034.jpg',
    'order' => 6,
]);
```

## 🎉 ¡Listo!

Con este sistema ahora puedes:

- ✅ Editar cualquier texto de la página desde el panel admin
- ✅ Cambiar imágenes sin tocar código
- ✅ Actualizar contenido HTML
- ✅ Crear nuevas páginas editables fácilmente
- ✅ Todo con caché automático para rendimiento óptimo

**URL del editor**: http://127.0.0.1:8000/pruebas/admin/contenido/home/editar

---

💡 **Tip**: Marca esta página en favoritos para referencia rápida!
