# Configuración de WhatsApp y Contacto

## 🎨 Edición Visual desde el Panel de Administración (Recomendado)

La forma más fácil de editar la configuración de WhatsApp y contacto es desde el panel administrativo:

1. Ingresa al panel de administración en `/pruebas/admin`
2. Ve a la sección **"Gestión de Contenido"**
3. Haz clic en la tarjeta **"Configuración"** (icono de engranaje rojo)
4. Edita los campos:
   - **Número de WhatsApp**: Incluye el código de país con `+` (ejemplo: `+593985959303`)
   - **Mensaje Predeterminado**: El texto que aparecerá automáticamente
   - **Email de Contacto**: Email principal del sitio
   - **Instagram URL**: Link al perfil de Instagram
5. Haz clic en **"Guardar Cambios"**

Los cambios se aplicarán inmediatamente en todo el sitio. ✨

---

## 📝 Edición Manual (Avanzado)

Si prefieres editar directamente el archivo de configuración, toda la información de contacto del sitio se gestiona desde:

```
config/site.php
```

### Cómo editar el número de WhatsApp y el mensaje

Abre el archivo `config/site.php` y encontrarás:

```php
'whatsapp' => [
    'number' => '+593985959303',
    'message' => 'Hola Julia, te escribo desde la página web de Imani Magnets. Quisiera más información sobre sus productos.',
],
```

### Cambiar el número de WhatsApp

Reemplaza el valor de `'number'` con el nuevo número de teléfono (debe incluir el código de país con `+`):

```php
'number' => '+593XXXXXXXXX',
```

### Cambiar el mensaje predeterminado

Reemplaza el valor de `'message'` con el nuevo texto que quieres que aparezca cuando alguien haga clic en el botón de WhatsApp:

```php
'message' => 'Tu mensaje aquí...',
```

## Otros datos de contacto editables

En el mismo archivo también puedes editar:

### Email de contacto
```php
'email' => 'info@imanimagnets.com',
```

### Redes sociales
```php
'social' => [
    'instagram' => 'https://instagram.com/imanimagnets',
],
```

## Dónde se usa esta configuración

Esta configuración se utiliza automáticamente en:

- ✅ Botón flotante de WhatsApp (todas las páginas)
- ✅ Footer del sitio (todas las páginas)
- ✅ Página de mayoristas
- ✅ Emails transaccionales
- ✅ Página de pago pendiente
- ✅ Cualquier otro lugar donde aparezca WhatsApp

## Aplicar los cambios

Después de editar el archivo `config/site.php`, ejecuta en la terminal:

```bash
php artisan config:clear
```

Esto limpiará la caché de configuración y aplicará los cambios inmediatamente.

## Nota Importante

⚠️ **No edites directamente los archivos `.blade.php`**. Todos los cambios deben hacerse únicamente en `config/site.php` para mantener consistencia en todo el sitio.
