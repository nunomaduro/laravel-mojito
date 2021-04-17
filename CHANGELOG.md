# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).

## Unreleased
- Added `not` modifier

## 0.2.8
### Added
- Added `empty` assertion ([#22](https://github.com/nunomaduro/laravel-mojito/pull/22))

## 0.2.7
### Added
- Added `hasMeta` assertion ([#21](https://github.com/nunomaduro/laravel-mojito/pull/21))

## 0.2.6
### Added
- Added support for Laravel 8 ([#19](https://github.com/nunomaduro/laravel-mojito/pull/19))
- Added support for PHP 8 ([#20](https://github.com/nunomaduro/laravel-mojito/pull/20))

## 0.2.5
### Fixed
- Fixed bug when assertions were using string containing the percentage symbol ([#16](https://github.com/nunomaduro/laravel-mojito/pull/16))

### Deprecated
- ViewAssertion::assert()

## 0.2.4
### Fixed
- `in()` returns all matching items rather than just the first match ([#11](https://github.com/nunomaduro/laravel-mojito/pull/11))

## 0.2.3
### Fixed
- Assertions with views in multiple nodes ([#8](https://github.com/nunomaduro/laravel-mojito/pull/8))

## 0.2.2
### Added
- Macroable trait to `ViewAssertion`

## 0.2.1
### Fixed
- `assertView` macro on Laravel 6

## 0.2.0
### Added
- View testing from http tests

## 0.1.1
### Added
- First version
