<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## Simple Inventory
<h4>How to run using Docker Toolbox</h4>
Download Docker Toolbox from this site: https://github.com/docker/toolbox/releases
<br>
Docker Toolbox is using IP: 192.168.99.100
<br>
1. Create a directory for the simple inventory.\
2. Pull the latest laradock using "git clone https://github.com/Laradock/laradock.git" inside the directory you have created.\
3. Open a terminal and navigate inside the laradock directory\
4. Create an env and copy the configuration from env-example using "cp env-example .env"\
5. Run docker-compose up -d nginx mysql (in my case, I am using mysql workbench instead of phpmyadmin).\
	* If you want to use phpmyadmin, run: docker-compose up -d nginx mysql phpmyadmin\
6. After the process, check the services using "docker-compose ps" to see if the services has "Exited" status.\
7. If the service status of MySQL is "Exited 1", go to laradock->mysql and open my.cnf and add this code\
	* innodb_use_native_aio=0\
	Under \
	default-authentication-plugin=mysql_native_password\
8. Update DATA_PATH_HOST from .env inside laradock and change the value from your preferred value.\
9. Navigate to laradock->nginx->sites, and copy laravel.conf.example inside the same directory and name it to your preferred name.\
10. /var/www/laravel (change this to the same name of the inventory. Example: inventory)/public\
	* Add the server from the host file located in Windows/System32/drivers/etc/host\
	ex: 192.168.99.100 inventory.test\
11. Run "docker-compose build --no-cache mysql" to update laradock's config for mysql.\
12. Run "docker-compose up -d mysql" again and it should be fixed.\
13. Once all the services are running, navigate to the root directory you have created, and clone the simple inventory.\
14. Once the cloning is finished, navigate inside the laradock and run: docker-compose exec workspace bash\
15. Navigate inside the inventory's directory, and run: cp .env.example .env\
16. Once the .env is created run: composer update\
17. Once the update is finished make sure your credentials in MySQL configuration from .env inside laradock is the same as the configuration from .env inside the inventory directory.\
	* The value of DB_HOST inside inventory/.env should also be mysql\
		- 	DB_CONNECTION=mysql\
		-	DB_HOST=mysql\
		-	DB_PORT=3306\
		-	DB_DATABASE=default\
		-	DB_USERNAME=default\
		-	DB_PASSWORD=secret\
18. Run the database migration: php artisan migrate\
19. Run php artisan key:generate\
20. Run phpunit to run the test.\

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
