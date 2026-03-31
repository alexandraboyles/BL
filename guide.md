## PHPUnit Configuration
Added `phpunit.xml` to the project root with `bootstrap="vendor/autoload.php"`.
This ensures PHPUnit loads Composer autoloading and resolves all application namespaces during tests.

## Test Result
The current test suite passes successfully:

```bash
phpunit tests
```

Output:
- `12 tests, 27 assertions, OK`

