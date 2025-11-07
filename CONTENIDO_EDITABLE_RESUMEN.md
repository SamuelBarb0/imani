# Sistema de Contenido Editable - Resumen

## ✅ Páginas Configuradas

### 1. **Home** (`/pruebas`)
- **Vista**: `resources/views/home/index.blade.php` ✅ INTEGRADA
- **Seeder**: `database/seeders/HomeContentSeeder.php`
- **Contenido editable**: 22 items (hero, quote, about, cta_final)
- **Editor**: `/pruebas/admin/contenido/home/editar`

### 2. **Personalizados** (`/pruebas/personalizados`)
- **Vista**: `resources/views/personalizados/index2.blade.php` ✅ INTEGRADA
- **Seeder**: `database/seeders/PersonalizadosContentSeeder.php`
- **Contenido editable**: 32 items
  - **Hero**: title, subtitle
  - **Landing**: description_1, description_2, price, shipping_note, button_text, step1-3 (titles & descriptions)
  - **Info**: title, step1-3 (titles & descriptions)
  - **Step1-3**: Textos para el generador de imanes
  - **Editor**: Textos del modal de edición
- **Editor**: `/pruebas/admin/contenido/personalizados/editar`

### 3. **Colecciones** (`/pruebas/colecciones`)
- **Vista**: `resources/views/colecciones/index.blade.php` ✅ INTEGRADA
- **Seeder**: `database/seeders/ColeccionesContentSeeder.php`
- **Contenido editable**: 41 items
  - **Header**: title, subtitle, intro_1, intro_2, size_info, main_image
  - **Collections**: section_title
  - **Ecuador I**: name, description, place_1-6, price, shipping_note, image, button_text
  - **Ecuador II**: name, description, place_1-6, price, shipping_note, image, button_text
  - **Galápagos**: name, description, price, shipping_note, image, button_text
  - **UI**: quantity_label
- **Editor**: `/pruebas/admin/contenido/colecciones/editar`

### 4. **Contacto** (`/pruebas/contacto`)
- **Vista**: `resources/views/contacto/index.blade.php` ✅ INTEGRADA
- **Seeder**: `database/seeders/ContactoContentSeeder.php`
- **Contenido editable**: 11 items
  - **Header**: title, subtitle
  - **Form**: labels y placeholders para nombre, apellido, correo, comentarios, botón
- **Editor**: `/pruebas/admin/contenido/contacto/editar`

### 5. **Mayoristas** (`/pruebas/mayoristas`)
- **Vista**: `resources/views/mayoristas/index.blade.php` ✅ INTEGRADA
- **Seeder**: `database/seeders/MayoristasContentSeeder.php`
- **Contenido editable**: 23 items
  - **Header**: title, intro, perfect_for_title, use_1, use_2, use_3, help_text, contact_info, image_1, image_2
  - **Form**: labels y placeholders para todos los campos del formulario
- **Editor**: `/pruebas/admin/contenido/mayoristas/editar`

---

## 🎨 Características del Editor

### Tipos de Contenido Soportados

1. **text** - Campo de texto simple
2. **textarea** - Área de texto multilínea
3. **html** - Editor HTML con formato básico (`<br>`, `<strong>`, `<em>`)
4. **image** - Subida de imágenes con preview visual

### Sistema de Subida de Imágenes

- **Formatos aceptados**: JPG, PNG, WEBP
- **Tamaño máximo**: 25MB
- **Ubicación**: `public/images/`
- **Características**:
  - Preview en tiempo real (48x48)
  - Drag & drop visual
  - Validación de archivos
  - Loading spinner
  - Notificaciones de éxito/error
  - Opción de escribir ruta manual

---

## 📊 Estructura de Datos

### Ejemplo de uso en las vistas:

```blade
<!-- Home -->
{{ $content->get('hero.title_line1') }}
{{ $content->get('hero.title_line2') }}
{!! $content->get('quote.quote_description') !!}  <!-- HTML con formato -->
<img src="{{ asset($content->get('about.photo')) }}">

<!-- Personalizados -->
{!! $content->get('hero.title') !!}  <!-- HTML con <br> -->
{{ $content->get('landing.price') }}
{{ $content->get('info.title') }}

<!-- Colecciones -->
{{ $content->get('header.title') }}
{!! $content->get('header.size_info') !!}  <!-- HTML con <strong> -->
{{ $content->get('ecuador_i.name') }}
{{ $content->get('ecuador_i.place_1') }}
<img src="{{ asset($content->get('ecuador_i.image')) }}">

<!-- Contacto -->
{{ $content->get('header.title') }}
{{ $content->get('form.label_nombre') }}

<!-- Mayoristas -->
{!! $content->get('header.intro') !!}  <!-- HTML con formato -->
{{ $content->get('header.use_1') }}
<img src="{{ asset($content->get('header.image_1')) }}">
```

### Todas las páginas usan `$content->get('section.key')`
- **Texto simple**: `{{ $content->get('section.key') }}`
- **HTML con formato**: `{!! $content->get('section.key') !!}`
- **Imágenes**: `{{ asset($content->get('section.key')) }}`

---

## 🚀 Acceso al Editor

1. Ir a `/pruebas/admin` (requiere login como admin)
2. Click en "Gestión de Contenido"
3. Seleccionar la página a editar:
   - Home
   - Personalizados
   - Colecciones
   - **Contacto** ✨
   - **Mayoristas** ✨

O acceso directo:
- `/pruebas/admin/contenido/contacto/editar`
- `/pruebas/admin/contenido/mayoristas/editar`

---

## 🗃️ Base de Datos

**Tabla**: `page_contents`

**Columnas**:
- `page` - Nombre de la página (home, contacto, mayoristas, etc.)
- `section` - Sección dentro de la página (header, form, etc.)
- `key` - Identificador del contenido (title, subtitle, etc.)
- `value` - Valor del contenido
- `type` - Tipo (text, textarea, html, image)
- `order` - Orden de visualización

**Datos actuales**:
- Home: 22 items
- Personalizados: 32 items
- Colecciones: 41 items
- Contacto: 11 items
- Mayoristas: 23 items
- **Total**: 129 items editables

---

## 📝 Seeders

Todos los seeders están organizados y se llaman desde `PageContentSeeder`:

```php
$this->call([
    HomeContentSeeder::class,
    PersonalizadosContentSeeder::class,
    ColeccionesContentSeeder::class,
    ContactoContentSeeder::class,
    MayoristasContentSeeder::class,
]);
```

**IMPORTANTE**: Todos los seeders usan `updateOrCreate()` para evitar duplicados y permitir actualizaciones.

Para repoblar contenido:
```bash
# Todas las páginas
php artisan db:seed --class=PageContentSeeder

# Una página específica
php artisan db:seed --class=HomeContentSeeder
php artisan db:seed --class=PersonalizadosContentSeeder
php artisan db:seed --class=ColeccionesContentSeeder
```

---

## 🎯 Características Adicionales

- **Auto-save**: Borrador guardado en localStorage
- **Confirmación**: Aviso al salir sin guardar
- **Caché**: Limpieza automática después de actualizar
- **Responsive**: Editor adaptado a móviles
- **Quick Links**: Navegación rápida entre páginas
