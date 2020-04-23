### Prerequisites

1. Check PHP 7.4 is installed
2. Check Composer is installed
3. Check npm & node are installed

### Install

1. Clone this project
2. Run `composer install`
3. Run `npm install`

### Working in dev environment

1. Create *.env.local* from *.env* file and put your Postgres database url
2. Run `php bin/console doctrine:database:create` in your terminal at project's root
3. Go to `src/DataFixtures/OperateurFixtures.php` and apply the passwords of your choice to `user` and `admin` profiles
4. Run `php bin/console doctrine:fixtures:load` to save this two profiles in database
5. Run `npm run watch` to launch your local server for assets
6. Run `symfony server:start` to launch your local php web server
