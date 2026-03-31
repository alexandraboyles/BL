# Alexandra BL PHP Project

## Step-by-step Guide

### 1. Install dependencies

1. Open a terminal in the project root folder.
2. Run:
   ```bash
   composer install
   ```

### 2. Review the project structure

- `composer.json` - project metadata and autoload configuration
- `index.php` - entry point for the application
- `src/` - namespaced PHP source code
- `core/` - core helpers and base classes
- `tests/` - PHPUnit test cases

### 3. Run the application

1. If the project uses a web server, point it at the project root.
2. If you want to run any PHP script directly, use:
   ```bash
   php index.php
   ```

### 4. Run tests

1. Make sure dependencies are installed.
2. Run PHPUnit from the project root:
   ```bash
   vendor\bin\phpunit
   ```

### 5. Add or update code

1. Open the relevant file under `src/`, `core/`, or another folder.
2. Follow existing class and namespace patterns.
3. Keep tests updated in the `tests/` folder.

### 6. Verify changes

1. Run the test suite again:
   ```bash
   vendor\bin\phpunit
   ```
2. Fix any failing tests.

## Notes

- This project uses PSR-4 autoloading as configured in `composer.json`.
- `phpunit.xml` is available to simplify running tests.
