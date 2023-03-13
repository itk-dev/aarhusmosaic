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
