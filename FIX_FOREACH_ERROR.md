# Fix: foreach() Error en Editor de Contenido

## Problema
Error: `foreach() argument must be of type array|object, string given` en todas las páginas de editar contenido.

## Causa
El método `PageContent::getPageContent()` fue modificado para devolver una estructura plana (con dot notation como `header.title`) para facilitar el uso en las vistas frontend. Sin embargo, el editor de contenido esperaba la estructura original agrupada por secciones.

## Solución
Se crearon dos métodos separados en el modelo `PageContent`:

### 1. `getPageContent()` - Para el Editor
```php
public static function getPageContent(string $page)
{
    return self::where('page', $page)
        ->orderBy('order')
        ->get()
        ->groupBy('section');
}
```
**Retorna**: Colección agrupada por secciones
```
[
    'header' => Collection [items...],
    'form' => Collection [items...]
]
```
**Usado en**: `ContentController@edit` para mostrar el formulario de edición

---

### 2. `getPageContentFlat()` - Para Vistas Frontend
```php
public static function getPageContentFlat(string $page)
{
    $contents = self::where('page', $page)
        ->orderBy('order')
        ->get()
        ->groupBy('section');

    return collect($contents)->flatMap(function ($items, $section) {
        return collect($items)->mapWithKeys(function ($item) use ($section) {
            return [$section . '.' . $item->key => $item->value];
        });
    });
}
```
**Retorna**: Colección plana con claves en formato dot notation
```
[
    'header.title' => 'ESTAMOS AQUÍ PARA AYUDARTE',
    'header.subtitle' => '¿Tienes una idea...',
    'form.label_nombre' => 'Nombre *',
    ...
]
```
**Usado en**: Vistas frontend a través de `ContentHelper::getPageContent()`

---

## ContentHelper Actualizado

```php
class ContentHelper
{
    public static function getPageContent(string $page): Collection
    {
        return PageContent::getPageContentFlat($page);
    }
}
```

El `ContentHelper` usa internamente `getPageContentFlat()` para que las vistas puedan acceder fácilmente con:
```blade
{{ $content->get('header.title') }}
{{ $content->get('form.label_nombre') }}
```

---

## Archivos Modificados

1. ✅ `app/Models/PageContent.php` - Agregado método `getPageContentFlat()`
2. ✅ `app/Helpers/ContentHelper.php` - Actualizado para usar `getPageContentFlat()`

---

## Verificación

### Editor (ContentController)
```bash
php artisan tinker --execute="
\$contents = App\Models\PageContent::getPageContent('contacto');
echo 'Sections: ' . \$contents->count();
"
# Output: Sections: 2
```

### Vistas Frontend
```bash
php artisan tinker --execute="
\$content = App\Helpers\ContentHelper::getPageContent('contacto');
echo \$content->get('header.title');
"
# Output: ESTAMOS AQUÍ PARA AYUDARTE
```

---

## Estado Actual

✅ **Editor**: Funciona correctamente con estructura agrupada
✅ **Vistas Contacto**: Funcionan con dot notation
✅ **Vistas Mayoristas**: Funcionan con dot notation
✅ **Cache limpiado**: `php artisan route:cache` ejecutado

## Páginas Usando Contenido Editable

1. **Contacto** - `/pruebas/contacto` ✅
2. **Mayoristas** - `/pruebas/mayoristas` ✅

Las demás páginas (Home, Personalizados, Colecciones) aún no están integradas al sistema de rutas con ContentHelper.
