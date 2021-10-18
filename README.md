# News parser
Application allows to parse news block by given URL and XPath selector.
Application has availability to extend functionality by adding custom content parsers (CURL by default), e.g. Guzzle, and custom DOM parsers (XPath by default).

## Installation and running
1. Clone repository
2. Run `composer install` to install dependencies.
3. Run `./vendor/bin/sail up -d` to start docker container.
- If you get an error on creating "backend_mysql" container - run `service mysql stop`.
- If you get an error on creating "backend_laravel" container - run `service apache2 stop`, if you have Apache as your local web server.

4. When `sail` is up, run `./vendor/bin/sail artisan migrate` to run migrations.
5. Application will be available at `localhost:80`.

There are two routes for testing news parser:
- `/index` - will parse `https://www.rbc.ru` and put news to the database to the "news" table
- `/show` - will output (using `dump()`) all existing data from "news" table

## Developer

Mikhail Denisov
