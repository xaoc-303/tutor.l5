## Tutor.L5

1. System startup.

    ```
    cp .env.example .env
    docker-compose up -d
    docker ps
    docker-compose exec app composer install
    docker-compose exec app php artisan key:generate
    docker-compose exec app php artisan config:cache
    ```

2. Check http://localhost in the browser.

3. Checking MySQL.

    ```
    docker-compose exec db mysql -uuser -ppass -e "show databases"
    ```
    or check using "adminer" service in browser http://localhost:8080

4. Checking migrations.
    
    `docker exec -it app bash` or `docker-compose exec app bash` 

    ```
    php artisan migrate
    php artisan db:seed
    php artisan tinker
    \DB::table('migrations')->get();
    ```
