<!-- markdownlint-configure-file { "blanks-around-headers": { "lines_below": 0 } } -->
<!-- markdownlint-configure-file { "blanks-around-lists": false } -->

# Changelog

![keep a changelog](https://img.shields.io/badge/Keep%20a%20Changelog-v1.0.0-brightgreen.svg?logo=data%3Aimage%2Fsvg%2Bxml%3Bbase64%2CPHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIGZpbGw9IiNmMTVkMzAiIHZpZXdCb3g9IjAgMCAxODcgMTg1Ij48cGF0aCBkPSJNNjIgN2MtMTUgMy0yOCAxMC0zNyAyMmExMjIgMTIyIDAgMDAtMTggOTEgNzQgNzQgMCAwMDE2IDM4YzYgOSAxNCAxNSAyNCAxOGE4OSA4OSAwIDAwMjQgNCA0NSA0NSAwIDAwNiAwbDMtMSAxMy0xYTE1OCAxNTggMCAwMDU1LTE3IDYzIDYzIDAgMDAzNS01MiAzNCAzNCAwIDAwLTEtNWMtMy0xOC05LTMzLTE5LTQ3LTEyLTE3LTI0LTI4LTM4LTM3QTg1IDg1IDAgMDA2MiA3em0zMCA4YzIwIDQgMzggMTQgNTMgMzEgMTcgMTggMjYgMzcgMjkgNTh2MTJjLTMgMTctMTMgMzAtMjggMzhhMTU1IDE1NSAwIDAxLTUzIDE2bC0xMyAyaC0xYTUxIDUxIDAgMDEtMTItMWwtMTctMmMtMTMtNC0yMy0xMi0yOS0yNy01LTEyLTgtMjQtOC0zOWExMzMgMTMzIDAgMDE4LTUwYzUtMTMgMTEtMjYgMjYtMzMgMTQtNyAyOS05IDQ1LTV6TTQwIDQ1YTk0IDk0IDAgMDAtMTcgNTQgNzUgNzUgMCAwMDYgMzJjOCAxOSAyMiAzMSA0MiAzMiAyMSAyIDQxLTIgNjAtMTRhNjAgNjAgMCAwMDIxLTE5IDUzIDUzIDAgMDA5LTI5YzAtMTYtOC0zMy0yMy01MWE0NyA0NyAwIDAwLTUtNWMtMjMtMjAtNDUtMjYtNjctMTgtMTIgNC0yMCA5LTI2IDE4em0xMDggNzZhNTAgNTAgMCAwMS0yMSAyMmMtMTcgOS0zMiAxMy00OCAxMy0xMSAwLTIxLTMtMzAtOS01LTMtOS05LTEzLTE2YTgxIDgxIDAgMDEtNi0zMiA5NCA5NCAwIDAxOC0zNSA5MCA5MCAwIDAxNi0xMmwxLTJjNS05IDEzLTEzIDIzLTE2IDE2LTUgMzItMyA1MCA5IDEzIDggMjMgMjAgMzAgMzYgNyAxNSA3IDI5IDAgNDJ6bS00My03M2MtMTctOC0zMy02LTQ2IDUtMTAgOC0xNiAyMC0xOSAzN2E1NCA1NCAwIDAwNSAzNGM3IDE1IDIwIDIzIDM3IDIyIDIyLTEgMzgtOSA0OC0yNGE0MSA0MSAwIDAwOC0yNCA0MyA0MyAwIDAwLTEtMTJjLTYtMTgtMTYtMzEtMzItMzh6bS0yMyA5MWgtMWMtNyAwLTE0LTItMjEtN2EyNyAyNyAwIDAxLTEwLTEzIDU3IDU3IDAgMDEtNC0yMCA2MyA2MyAwIDAxNi0yNWM1LTEyIDEyLTE5IDI0LTIxIDktMyAxOC0yIDI3IDIgMTQgNiAyMyAxOCAyNyAzM3MtMiAzMS0xNiA0MGMtMTEgOC0yMSAxMS0zMiAxMXptMS0zNHYxNGgtOFY2OGg4djI4bDEwLTEwaDExbC0xNCAxNSAxNyAxOEg5NnoiLz48L3N2Zz4K)

All notable changes to this project will be documented in this file.

See [keep a changelog](https://keepachangelog.com/en/1.0.0/) for information about writing changes to this log.

## [Unreleased]

- Removed rabbit (remember to update .env when releasing)
- Updated docker compose setup
- Fix spelling of number 3

## [1.1.0] - 2023-07-19

- Added linting and skeleton component
- Display none on image until fully loaded, added default skeleton component colors
- Add "passive" node container to `docker-compose.server.override.yml` to ease install and build

## [1.0.0] - 2023-06-29

- Added new image service to scale down images
- Added command to loop over images and scale them down
- Added image scaling to new webhook download
- Added command to remove unused images from filesystem

## [1.0.0-beta4] - 2023-05-17

- Add more padding to expose text

## [1.0.0-beta3] - 2023-05-12

- Fix image in footer

## [1.0.0-beta2] - 2023-05-11

- Add tileTags filter.
- Add configurable footer

## [1.0.0-beta1] - 2023-05-10

- Sort tiles last changed first.
- Add possibility of switching between random and sorted data
- Fixed that /random should not show not accepted tiles
- Fix colored overlay
- Added monolog and mime packages
- Fixed tiles image path
- Fixed defaults when tile.extra or screen.variant are not parsable.
- Changed tags input format "tag1,tag2,tag3" in webhook callback.
- Ensure uniq id for upload filenames (to safeguard file override).
- Added tags filtering to tile's API end-point.
- Added api user to screen and generated frontend URL in screen admin.
- Added admin UI help texts and auto-generated tokens for new api-users

### Added

- Ctabox in frontend
- Frontend config for font size
- Frontend config for icons and logo
- Symfony 6.2
- API Platform 3.1
- Basic ITK development setup
- Added AMQP and Doctrine message packages
- Added metrics bundle and http client
- Added timestampable to entities
- Added react app
- Added fixtures
- Download content from OS2Forms in webhook
- Filter Tile by accepted in API
- Randomize Tile in API
- Fixed route with limit and random tiles (to get limit to work with random custom controller with pagination from doctrine)
- Changed tags to ManyToMany relation from json
- Update fixtures and admin to match new tags
- Added order by updatedAt for tiles Get operation
- Added connection between frontend and API
