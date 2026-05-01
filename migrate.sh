#!/bin/bash
touch database/database.sqlite
php artisan migrate:fresh --seed --no-interaction
