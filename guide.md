This guide documents the actual updates made to fix PHPUnit autoloading and validation behavior in the project.

## Updated Composer Autoload
The `composer.json` file was updated to map namespaces to the correct source directories:
- `Core\\` -> `src/Core/`, `core/`
- `Addresses\\` -> `src/Addresses/`
- `Transport\\` -> `src/Transport/`
- `Invoices\\` -> `src/Invoices/`
- `Products\\` -> `src/Products/`
- `WarehouseSettings\\` -> `src/WarehouseSettings/`, `warehouse_settings/`
- `Warehouse\\` -> `warehouse/`
- `Logs\\` -> `logs/`

After editing `composer.json`, run:

```bash
composer dump-autoload
```

## PHPUnit Configuration
Added `phpunit.xml` to the project root with `bootstrap="vendor/autoload.php"`.
This ensures PHPUnit loads Composer autoloading and resolves all application namespaces during tests.

## Validation Exception Update
In `src/Core/ValidationException.php`:
- changed the base class from `\\Exception` to `\\InvalidArgumentException`
- updated the constructor to use `?\\Throwable $previous = null`

This matches the PHPUnit tests, which expect validation failures to behave like invalid argument exceptions.

## Logger Path Fixes
Updated logging classes to write into the correct project `logs/` directory:
- `src/Core/DeletionLogger.php`
- `src/Core/PrintLogger.php`

The file paths now use `__DIR__ . '/../../logs/...'` instead of pointing into `src/logs/`.

## Test Result
The current test suite passes successfully:

```bash
phpunit tests
```

Output:
- `12 tests, 27 assertions, OK`

## Notes
- No `demo.md` file remains in the project.
- The guide now reflects the real state of the code after fixing autoload, bootstrap, validation exception handling, and logger output paths.
