#!/bin/bash
composer create-project laravel/laravel:^11.0 temp_laravel --no-interaction
mv temp_laravel/* .
mv temp_laravel/.* .
rm -rf temp_laravel
