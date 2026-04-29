# Run php commands inside the container

docker exec blog-api-ms php artisan list

docker exec blog-api-ms php artisan make:model Post -m

docker exec blog-api-ms php artisan migrate

docker exec -it blogdb psql -U postgres

docker exec blog-api-ms php artisan migrate:rollback

# Seed database with fake posts

# Step 1:

docker exec blog-api-ms php artisan make:factory PostFactory --model=Post

# Step 2: Fill the table posts with fake data

docker exec blog-api-ms php artisan make:seeder PostSeeder

# Step 3: Building The Blog Api

docker exec blog-api-ms php artisan make:controller Api/CoreApiController

docker exec blog-api-ms php artisan make:controller Api/V1/PostController

docker exec blog-api-ms php artisan make:request Api/V1/Blog/Post/PostStoreRequest

<!-- Create the API Resource (Output Formatting) -->

docker exec blog-api-ms php artisan make:resource Api/V1/Blog/Post/PostResource

<!-- Create the controller to handle the requests -->

docker exec blog-api-ms php artisan make:controller Api/V1/Blog/Post/PostController

docker exec blog-api-ms php artisan install:api
