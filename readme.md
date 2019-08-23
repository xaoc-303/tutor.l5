## Tutor.L5

### Docker, Laravel, Vue, MySQL, Adminer, Queue, Redis, Parser

1. System startup.

    ```
    cp .env.example .env
    docker-compose up -d
    docker ps
    docker-compose exec app composer install
    docker-compose exec app php artisan key:generate
    docker-compose exec app php artisan config:cache
    ```

2. Checking MySQL.

    ```
    docker-compose exec db mysql -uuser -ppass -e "show databases"
    ```
    or check using "adminer" service in browser http://localhost:8080

3. Init and checking migrations.
    
    `docker exec -it app bash` or `docker-compose exec app bash` 

    ```
    php artisan migrate
    php artisan db:seed
    php artisan tinker
    \DB::table('migrations')->get();
    ```

4. NPM install

    ```
    npm install
    npm run watch
    ```
   
5. Start parser and queue processing

    ```
    php artisan parser
    php artisan queue:listen --queue=petrovich
    ```

6. Check http://localhost in the browser.
