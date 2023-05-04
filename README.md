# Aarhus mosaic

## Development

Getting started:

```shell
docker compose run --rm node yarn install
docker compose up -d
docker compose exec phpfpm composer install
```

Install database

```shell
docker compose exec phpfpm bin/console doctrine:migrations:migrate
```

Load fixtures:

```shell
docker compose exec phpfpm bin/console doctrine:fixtures:load
```

Create an admin user:

```shell
docker compose exec phpfpm bin/console app:user:add xxxx@aarhus.dk <password>
```

## Production

```shell
idc up -d
idc exec phpfpm composer install
docker run --rm -v .:/app --workdir /app node:18 yarn install
docker run --rm -v .:/app --workdir /app node:18 yarn build
rm -rf node_modules
```

## Frontend config

### How to configure

Following parameters is possible to configure from the `screen` -> `variant` field in the administration.

### Parameters

| Name                | Accepts       | Example |
|---------------------|-------------|---------|
| Tiles |
| showIcons             | true,false    | `"showIcons":false` |
| showBorders           | true,false    | `"showBorders":false` |
| Expose |
| gridExpose            | 1-9           | `"gridExpose":2` |
| exposeShowBorder      | true,false    | `"exposeShowBorder":false` |
| exposeShowIcon        | true,false    | `"exposeShowIcon":false` |
| exposeTimeout         | 1-9           | `"exposeTimeout":7` |
| exposeFontSize        | xs,s,m,l,xl   | `"exposeFontSize":"m"` |
| Logo |
| mosaicLogo            | true,false    | `"exposeShowIcon":false` |
| Footer |
| footerHeight          | 1-9           | `"footerHeight":"1"` |
| footerImageSrc        | Url           | `"https://pathtoimagesource.io/footerimage.svg"` |
| footerBackgroundColor | Hex format    | `"footerBackgroundColor":"#F4DCEA"` |
| Cta box |
| ctaBoxTitle           | Text          | `"ctaBoxTitle":"Del dit billede"` |
| ctaBoxDescription     | Text          | `"ctaBoxDescription":"Skan koden og indsend dit bidrag"` |
| ctaBoxImage           | Url           | `"https://pathtoimagesource.io/ctaimage.svg"` |
| ctaBoxBackgroundColor | Hex format    | `"ctaBoxBackgroundColor":"#fff"` |

### Example

```json
{"showIcons":false,"showBorders":false,"gridExpose":2,"exposeShowBorder":false,"exposeShowIcon":false,"mosaicLogo":false,"exposeTimeout":14,"ctaBoxTitle":false,"ctaBoxDescription":"Skan koden og indsend dit bidrag","ctaBoxImage":"./qr.svg","ctaBoxBackgroundColor":"#fff","exposeFontSize":"m","footerHeight":"1","footerImageSrc":"./footer.png","footerBackgroundColor":"#F4DCEA"}
```
