# happy-plants-app

```
# To install the project:
git clone https://github.com/blackbird38/happy-plants-app.git

cd happy-plants-app
npm install
composer install
npm run dev
replace in .env, DATABASE_URL: DATABASE_URL=mysql://root:@127.0.0.1:3306/happy-plant-db
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
php bin/console server:run
```
