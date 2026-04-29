# Run php commands inside the container

docker exec blog-api-service php artisan list

docker exec blog-api-service php artisan make:model Post -m

docker exec blog-api-service php artisan migrate

docker exec -it blogdb psql -U postgres

docker exec blog-api-service php artisan migrate:rollback

# Seed database with fake posts

# Step 1:

docker exec blog-api-service php artisan make:factory PostFactory --model=Post

# Step 2:

docker exec blog-api-service php artisan make:seeder PostSeeder

# Step 3: Fill the table posts with fake data

docker exec blog-api-service php artisan db:seed --class=PostSeeder
