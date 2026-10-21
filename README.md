## Archivos subidos

Las imágenes de portada, eventos y diapositivas se guardan en `storage/app/public`.
Para que Laravel las sirva desde `public/storage`, ejecuta desde la raíz del proyecto:

```bash
php artisan storage:link
```

El comando `composer setup` también crea este enlace durante la instalación local.