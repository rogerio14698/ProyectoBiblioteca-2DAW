# Errores detectados por PHPStan (nivel 5)

## app/Exceptions/Handler.php
- El método render() debe devolver Illuminate\Http\Response, pero devolvía Symfony\Component\HttpFoundation\Response. Corregido el tipo de retorno y el uso de getStatusCode().
- Se usaba $exception->getStatusCode() sobre Throwable, ahora se verifica con instanceof HttpExceptionInterface.

## app/Models/Admin.php y app/Models/Usuario.php
- PHPStan no reconocía métodos mágicos Eloquent como where(), create(). Se agregaron anotaciones PHPDoc para ayudar al análisis estático.

## app/Http/Controllers/Admin/Auth/LoginControllerAdmin.php y Auth/LoginControllerUsuario.php
- PHPStan no reconocía métodos como attempt(), login(), logout() en Auth::guard(). Se agregaron anotaciones PHPDoc para indicar el tipo correcto.

## app/Http/Controllers/Auth/UsuarioController.php
- PHPStan no reconocía el método estático create() en Usuario. Se agregó anotación PHPDoc.

---

Si vuelves a ejecutar PHPStan, estos errores deberían desaparecer o reducirse notablemente. Si aparecen nuevos, repite el proceso de anotación o corrige el tipado según corresponda.
