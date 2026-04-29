# Run php commands inside the container

docker exec blog-api-service php artisan list

docker exec blog-api-service php artisan make:model Post -m

docker exec blog-api-service php artisan migrate

docker exec -it blogdb psql -U postgres

docker exec blog-api-service php artisan migrate:rollback
