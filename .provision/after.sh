#!/usr/bin/env bash

# Show hint
echo "This may take a while..."

# Navigate to project directory
cd /vagrant/

# Create .env file by copying .env.example
php -r "file_exists('.env') || copy('.env.example', '.env');"

# Run composer install
composer install --no-progress &> /dev/null

# Generate application key
php artisan key:generate

# Create storage link
php artisan storage:link

# Publish Horizon assets
php artisan horizon:install

# Publish Telescope assets
php artisan telescope:install

# Install migrations
php artisan migrate:install

# Migrate and seed
php artisan migrate --seed

# Generate IDE Helper files
php artisan ide-helper:make

# Copy SSL certificates
sudo cp /etc/nginx/ssl/* /vagrant/.provision/ssl/
