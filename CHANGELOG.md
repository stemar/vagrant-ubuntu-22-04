# Changelog

## 1.1.0 - 2026-02-07

### Added

- Added `config/php.ini` that will be located in `/var/www` to override Apache's `php.ini`
- Added `PHPINIDir` and `SetEnv PHP_INI_SCAN_DIR` in `config/virtualhost.conf`
- New `PHP_VERSION` is handled in `provision.sh`

### Changed

- Modified alias `ll` in `config/bash_aliases`
- Updated `README.md`

### Removed

- Deleted `config/php.ini.htaccess`
    - `.htaccess` is no longer used to override Apache's `php.ini`
- Removed `:php_error_reporting` from `settings.yaml`
- Removed `PHP_ERROR_REPORTING` from `Vagrantfile`
- Removed `PHP_ERROR_REPORTING_INT` and its handling from `provision.sh`

## 1.0.3 - 2026-01-19

### Added

- Added Ruby.

### Changed

- Changed Adminer theme.

## 1.0.2 - 2026-01-17

### Changed

- Updated YAML array format in `settings.yaml`.
    - Updated `:php_error_reporting` value.
- Updated `Vagrantfile` by adding local variables.
    - Modernized path in the `YAML.load_file()` call.
- Replaced `FORWARDED_PORT_80` variable with `HOST_HTTP_PORT` in 3 files.
    - Updated `provision.sh`, `adminer.conf`, `virtualhost.conf` with new variable name.
- Modified the version section of `provision.sh` for the section title and the Apache version output.
- Updated the last section of `README.md`.

## 1.0.1 - 2025-10-05

### Added

- Added `CHANGELOG.md`

### Changed

- Updated `README.md`

### Fixed

- Updated Adminer to version 5+ plugin code and files

## 1.0.0 - 2023-01-15

_First release_
