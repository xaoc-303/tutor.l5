#!/usr/bin/env bash

# Copy laravel-horizon.conf to Supervisor configurations directory
cp /vagrant/.provision/supervisor/laravel-horizon.conf /etc/supervisor/conf.d/

# Supervisor reread configuration files
supervisorctl reread

# Supervisor update
supervisorctl update

# Supervisor start laravel-horizon
supervisorctl start laravel-horizon:*
