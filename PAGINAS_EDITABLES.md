# 📄 Guía Rápida: Páginas Editables - Imani Magnets

## ✅ Páginas Completamente Configuradas

Todas estas páginas tienen sus seeders listos y pueden ser editadas desde el panel de administración.

---

## 🏠 **HOME**
**URL Editor:** `/pruebas/admin/contenido/home/editar`

**Elementos editables: 24**

### Secciones:
- **hero** (8 elementos)
  - title_line1, title_line2
  - subtitle
  - cta_text, cta_link
  - slide_1, slide_2, slide_3 (imágenes)

- **quote** (2 elementos)
  - quote_text
  - quote_description

- **about** (8 elementos - Sección "Hola!")
  - greeting
  - intro_1, intro_2, intro_3, intro_4, intro_5
  - signature
  - photo (imagen)

- **cta_final** (4 elementos)
  - title
  - description
  - button_text, button_link

**Seeder:** `PageContentSeeder.php`

---

## 🎨 **PERSONALIZADOS**
**URL Editor:** `/pruebas/admin/contenido/personalizados/editar`

**Elementos editables: 26**

### Secciones:
- **hero** (2 elementos)
  - title
  - subtitle

- **step1** (4 elementos - Paso 1: Sube tus fotos)
  - title
  - dropzone_title, dropzone_subtitle
  - button_text

- **step2** (3 elementos - Paso 2: Edita tus fotos)
  - title
  - images_ready_label
  - back_link

- **step3** (6 elementos - Paso 3: Finaliza tu pedido)
  - title
  - product_name, product_description
  - price
  - button_add_cart, button_checkout

- **editor** (6 elementos - Modal de edición)
  - modal_title
  - zoom_label, rotate_label
  - button_save, button_cancel, button_delete

- **info** (7 elementos - ¿Cómo funciona?)
  - title
  - step1_title, step1_desc
  - step2_title, step2_desc
  - step3_title, step3_desc

**Seeder:** `PersonalizadosContentSeeder.php`

---

## 🖼️ **COLECCIONES**
**URL Editor:** `/pruebas/admin/contenido/colecciones/editar`

**Elementos editables: 36**

### Secciones:
- **header** (6 elementos)
  - title, subtitle
  - intro_1, intro_2
  - size_info
  - main_image (imagen)

- **collections** (1 elemento)
  - section_title

- **ecuador_i** (12 elementos - Colección Ecuador I)
  - name, description
  - place_1, place_2, place_3, place_4, place_5, place_6
  - price, shipping_note
  - image (imagen)
  - button_text

- **ecuador_ii** (12 elementos - Colección Ecuador II)
  - name, description
  - place_1, place_2, place_3, place_4, place_5, place_6
  - price, shipping_note
  - image (imagen)
  - button_text

- **galapagos** (6 elementos - Colección Galápagos)
  - name, description
  - price, shipping_note
  - image (imagen)
  - button_text

- **ui** (1 elemento)
  - quantity_label

**Seeder:** `ColeccionesContentSeeder.php`

**Vista actualizada:** Header ya usa `content()` ✅

---

## 🏢 **MAYORISTAS**
**URL Editor:** `/pruebas/admin/contenido/mayoristas/editar`

**Elementos editables: 23**

### Secciones:
- **header** (10 elementos)
  - title
  - intro
  - perfect_for_title
  - use_1, use_2, use_3
  - help_text
  - contact_info
  - image_1, image_2 (imágenes)

- **form** (13 elementos - Labels y placeholders)
  - label_nombre, label_apellido, label_correo, label_celular
  - label_cantidad, label_fecha, label_comentarios
  - placeholder_nombre, placeholder_apellido, placeholder_correo
  - placeholder_cantidad, placeholder_comentarios
  - button_submit

**Seeder:** `MayoristasContentSeeder.php`

---

## 📧 **CONTACTO**
**URL Editor:** `/pruebas/admin/contenido/contacto/editar`

**Elementos editables: 11**

### Secciones:
- **header** (2 elementos)
  - title
  - subtitle

- **form** (9 elementos - Labels y placeholders)
  - label_nombre, label_apellido, label_correo, label_comentarios
  - placeholder_nombre, placeholder_apellido, placeholder_correo
  - placeholder_comentarios
  - button_submit

**Seeder:** `ContactoContentSeeder.php`

---

## 📊 Resumen Total

| Página | Elementos Editables | Seeder | Editor URL |
|--------|---------------------|--------|------------|
| Home | 24 | PageContentSeeder | `/pruebas/admin/contenido/home/editar` |
| Personalizados | 26 | PersonalizadosContentSeeder | `/pruebas/admin/contenido/personalizados/editar` |
| Colecciones | 36 | ColeccionesContentSeeder | `/pruebas/admin/contenido/colecciones/editar` |
| Mayoristas | 23 | MayoristasContentSeeder | `/pruebas/admin/contenido/mayoristas/editar` |
| Contacto | 11 | ContactoContentSeeder | `/pruebas/admin/contenido/contacto/editar` |
| **TOTAL** | **120** | **5 seeders** | **5 páginas** |

---

## 🚀 Acceso Rápido

### Panel Principal
```
http://127.0.0.1:8000/pruebas/admin/contenido/{page}/editar
```

Donde `{page}` puede ser:
- `home`
- `personalizados`
- `colecciones`
- `mayoristas`
- `contacto`

---

## 💻 Cómo Usar en las Vistas

### Ejemplo Simple:
```blade
<!-- Texto -->
{!! content('mayoristas', 'header', 'title', 'PEDIDOS ESPECIALES Y AL POR MAYOR') !!}

<!-- Imagen -->
<img src="{{ asset(content('mayoristas', 'header', 'image_1', 'images/default.jpg')) }}" alt="Mayoristas">

<!-- Form Label -->
<label>{!! content('mayoristas', 'form', 'label_nombre', 'Nombre *') !!}</label>
```

### Sintaxis:
```php
content($page, $section, $key, $default)
```

- **$page**: Nombre de la página (`'home'`, `'mayoristas'`, etc.)
- **$section**: Sección dentro de la página (`'header'`, `'form'`, etc.)
- **$key**: Identificador único (`'title'`, `'subtitle'`, etc.)
- **$default**: Valor por defecto si no existe

---

## 🔄 Resetear Contenido

Si necesitas volver a los valores por defecto:

```bash
# Una página específica
php artisan db:seed --class=PageContentSeeder
php artisan db:seed --class=PersonalizadosContentSeeder
php artisan db:seed --class=ColeccionesContentSeeder
php artisan db:seed --class=MayoristasContentSeeder
php artisan db:seed --class=ContactoContentSeeder

# Todas a la vez (si las agregas al DatabaseSeeder)
php artisan db:seed
```

---

## ⚡ Estado de Implementación

### ✅ Completamente Listo:
- Base de datos y migraciones
- Todos los seeders creados y ejecutados
- Panel de administración funcional
- Helper global `content()` disponible

### ⚠️ Pendiente (Opcional):
- Actualizar vistas para usar `content()` en lugar de HTML hardcodeado
- Solo **Colecciones** tiene un ejemplo implementado (sección header)

### 📝 Para Actualizar una Vista:

1. **Lee el seeder** para ver qué keys existen
2. **Reemplaza el HTML hardcodeado** con llamadas a `content()`
3. **Prueba** que funcione correctamente
4. **Edita desde el panel** cuando quieras cambiar algo

**Ejemplo de Colecciones (ya hecho):**
```blade
<!-- ANTES -->
<h1>COLECCIONES DE IMANES</h1>

<!-- DESPUÉS -->
<h1>{!! content('colecciones', 'header', 'title', 'COLECCIONES DE IMANES') !!}</h1>
```

---

## 🎯 Próximos Pasos Recomendados

1. **Prueba el sistema:**
   - Accede a cualquier editor
   - Cambia algunos textos
   - Guarda y verifica que funcione

2. **Decide qué páginas quieres editable:**
   - Si cambias contenido frecuentemente: usa `content()`
   - Si el contenido es estático: déjalo como está

3. **Actualiza las vistas gradualmente:**
   - Empieza con Home (la más importante)
   - Sigue con las que más cambies
   - Las demás pueden esperar

---

## 📚 Documentación Completa

- **Guía de uso:** `CONTENT_EDITOR_README.md`
- **Resumen del sistema:** `SISTEMA_EDICION_RESUMEN.md`
- **Esta guía:** `PAGINAS_EDITABLES.md`

---

## ✨ ¡Todo Listo!

Tienes **5 páginas** con **120 elementos editables** listos para usar desde el panel de administración.

**URL base del editor:**
```
http://127.0.0.1:8000/pruebas/admin/contenido/{page}/editar
```

¡Solo edita y guarda! Los cambios son INMEDIATOS. 🎉
