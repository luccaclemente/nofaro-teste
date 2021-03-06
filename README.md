## Installation

### Composer
Run [Composer](https://getcomposer.org/ "Composer") from the command line to install all vendor packages:
```bash
composer install
```
### Configuration file
Rename the file `.env.exampe` to `.env`. Afterwards, run the command below to set the _application key_:
```bash
php artisan key:gen
```
Don&apos;t forget to setup `DB_USERNAME` and `DB_PASSWORD` in the newly created `.env` file.

### Database Setup
Now, you will have to own a local MySQL Database named `nofaro`. Besides that, run the following commands:
```bash
php artisan migrate
```
And:
```bash
php artisan db:seed --class=SpeciesTableSeeder
```

## Running the application
In order to run this application you may run the following commands:
```bash
php artisan scribe:generate
```
And:
```bash
php artisan serve
```
## Testing

### Documentation
In order to check all endpoints available on the API, click <a href="http:localhost:8000/docs/">here</a>

## Doubts

If are there any doubts, contact me by e-mail on <a href="mailto:luccacdasilva@gmail.com">luccacdasilva@gmail.com</a>