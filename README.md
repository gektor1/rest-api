rest-api - Symfony3 (FOSRESTBundle)

========

Installation:

```bash
git clone https://github.com/gektor1/rest-api.git
cd rest-api
composer install
php bin/console doctrine:database:create
php bin/console doctrine:schema:update --force
```

Start server
```bash
php bin/console server:run
```

REST API spec:
http://localhost:8000/api/doc
