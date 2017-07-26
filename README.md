Evohome
=======

## Install

```
clone git repository
composer install
bin/console doctrine:database:create
bin/console doctrine:schema:update --force
bin/console assets:install --symlink
bin/console avanzu:admin:fetch-vendor
```

## Pull data from evohome to database

bin/console evohome:pull_data

## Inspirations

- https://github.com/watchforstock/evohome-client
- http://dirkgroenen.nl/projects/2016-01-15/honeywell-API-endpoints-documentation

## Output example

![Chart](https://github.com/radoslavius/evohome/blob/master/doc/images/chart.jpg)
