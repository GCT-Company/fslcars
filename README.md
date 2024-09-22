<<<<<<<< Update Guide >>>>>>>>>>>
Immediate Older Version: 1.1.0
Current Version: 1.2.0
Feature Update:
1. Optimization & Bug Fixing
2. Cookie Added
3. Mail From Address Added in Email Configuration
4. User Dashboard - Find Car Menu Added
5. User Dashboard History Page Modify With Details Page Added
6. Admin Panel - Car Booking And Booking Details Page Modified 
7. Installer Update

Please Use Those Command On Your Terminal To Update Full System
1. To Run Project Please Run This Command On Your Terminal
    composer update && composer dump-autoload && php artisan migrate
2. To Update Feature
    php artisan db:seed --class=Database\\Seeders\\UpdateFeatureSeeder
