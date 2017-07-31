# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## 1.1.2 - 2017-07-31

### Changed
- Minor tweak to further changes in v1.1.1.

## 1.1.1 - 2017-07-31

### Changed
- Fixed bug where tests not properly namespaced.

## 1.1.0 - 2017-07-27

### Added
- Support for "default filters" that can run unless told not to by another filter.
- Passing test cases.
- This [CHANGELOG.md](CHANGELOG.md) file.

### Changes
- Registering methods in ```$filter``` array no longer required.
- Defines a "filter" prefix on methods that lets the parent class know which methods can be used on query string elements.

## 1.0.0 - 2017-07-11

### Added
- Initial release.