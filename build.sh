#!/bin/bash
touch database/database.sqlite
php artisan migrate --force
php artisan db:seed --class=RuLangSeeder --force
php artisan db:seed --class=KkLangSeeder --force
php artisan db:seed --class=FamilyClubSeeder --force
php artisan db:seed --class=ProgressStageSeeder --force
php artisan view:cache
