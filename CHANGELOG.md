# Changelog

All notable changes to this module will be documented in this file.

The format is based on Keep a Changelog.

## [0.2.4] - 2026-08-12

### Fixed
- frontend 번역 JSON을 G7 중첩 namespace 구조로 정규화하여 관리자 및 사용자 레이아웃에 translation key가 그대로 노출되는 문제를 수정했습니다.

### Added
- 모든 모듈 레이아웃의 `$t:` key가 KO/EN frontend dictionary에서 실제로 resolve되는지 검증하는 회귀 테스트를 추가했습니다.

## [0.2.3] - 2026-08-12

### Changed
- 관리자 사이드 메뉴의 한국어 표시명을 `반짝이 예약 관리`, 영어 표시명을 `Glitter Reservation Management`로 변경했습니다.

## [0.2.2] - 2026-08-12

### Fixed
- 관리자 route, layout, menu, API가 모듈 lifecycle에서 생성되는 canonical `glitter-reservation.reservations.*` 권한을 사용하도록 통일했습니다.
- `admin` 및 `manager` 역할에 정상 동기화된 예약 권한이 있어도 관리자 예약 레이아웃과 API가 403을 반환하던 문제를 수정했습니다.

### Added
- 모듈이 참조하는 모든 관리자 권한이 `getPermissions()` catalog에서 생성되는 식별자인지 검증하는 회귀 테스트를 추가했습니다.

## [0.2.1] - 2026-08-12

### Added
- G7 7.0.6 typed frontend route manifests for the reservation admin, application, and lookup pages
- regression coverage for frontend route-to-layout resolution

### Changed
- raised the minimum Gnuboard version to 7.0.6 to match the typed module route contract

### Fixed
- fixed `/admin/reservations` returning HTTP 404 before the admin SPA could render the reservation layout
- replaced visible hardcoded text in the reservation admin layout with module translation keys

## [0.2.0] - 2026-04-14

### Added
- bundled packaging scaffold for distribution
- build scaffold with vite.config.ts, resources/js, and resources/css
- dist placeholder files for packaged module shape
- no-op install seeder scaffold
- no-op upgrade scaffold
- ecosystem-level distribution readiness via `_bundled` module placement

### Changed
- finalized glitter-reservation as a bundled Gnuboard7 module
- aligned module structure with bundled module conventions
- completed packaging layer without altering runtime behavior
- confirmed compatibility with copy-based installation into `modules/_bundled`

### Notes
- this release marks transition from portable module to bundled distribution unit
- module is now ready for GitHub-based folder-level distribution
- asset pipeline and upgrade scaffolds are intentionally minimal and non-intrusive

## [0.1.0] - 2026-04-14

### Added
- portable install contract documentation for host projects
- release metadata scaffolding for GitHub distribution
- release version tracking files for the portable bundle

### Changed
- finalized the module scope as a portable Gnuboard 7 reservation bundle
- decoupled public and admin page exposure from hardcoded host paths
- normalized the portable migration set to `database/migrations/`
- aligned bundle metadata and release documentation for distribution

### Removed
- removed `student_grade` from the portable bundle target
- removed dead listener, dead request, and dead enum files from the portable target

### Notes
- excluded historical migrations from portable installs via `database/migrations_excluded/`
- completed the host integration and install contract for template route mapping, initial data, and optional notification binding
