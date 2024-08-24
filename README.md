# API de Giphy
Español:
Este API es una prueba tecnica que realice para una empresa a la cual postule. Consta de una integracion con GIPHY para obtener informacion detallada de Gifs, los cuales pueden ser buscados por nombre o palabras clave, puede ser obtenida la informacion de un gif especifico mediante su ID, como asi tambien pueden ser almcacenados como favoritos para un usuario. Por supuesto, tambien puede registrarse un nuevo usuario, iniciar sesion, cerrarla y obtener informacion de un usuario que este logueado.

English:
This API is a technical test I performed for a company I applied to. It consists of an integration with GIPHY to obtain detailed information about the Gifs, which can be searched by name or keywords, information about a specific gif can be obtained through its ID, and they can also be stored as a user's favorites. Of course, a new user can also register, log in, log out, and get information from a logged in user.

## Stack tecnologico // Tech Stack
Español:
Este API funciona en base a Laravel 10 y MySQL. Para la autenticacion de usuarios se utiliza Laravel Passport para aplicar OAuth2.0. La diagramacion UML esta hecha con Luchidart y las pruebas unitarias estan hechas con PHPUnit, tambien se adjunta la coleccion de Postman para testeos. El API se monta en un servidor containerizado con Docker.

English:
This API works based on Laravel 10 and MySQL. For user authentication, Laravel Passport is used to apply OAuth2.0. The UML diagramming is done with Luchidart and the unit tests are done with PHPUnit, the Postman collection is also attached for testing. The API is mounted on a containerized server with Docker.

## Instalacion // Setup
Español:
- clonar el repositorio
- se debe crear el archivo .env siguiendo el ejemplo del .env.example. Agregar la Api Key de GIPHY (se debe crear previamente)
- debemos instalar las dependencias de composer para poder iniciar el Laravel Sail. usamos el siguiente codigo
    docker run --rm -u "$(id -u):$(id -g)" -v $(pwd):/opt -w /opt laravelsail/php82-composer:latest composer install --ignore-platform-reqs
- Levantamos el proyecto con ./vendor/bin/sail up -d
- Creamos la clave de encriptacion necesaria para Laravel ./vendor/bin/sail artisan key:generate
- Corremos las migraciones y el seeder para crear las Key de Passport ./vendor/bin/sail artisan mig:fr --seed

English:
- clone the repository
- the .env file must be created following the example of .env.example. Add the GIPHY Api Key (must be created previously)
- we must install the composer dependencies to be able to start Laravel Sail. we use the following code
    docker run --rm -u "$(id -u):$(id -g)" -v $(pwd):/opt -w /opt laravelsail/php82-composer:latest composer install --ignore-platform-reqs
- We run the project with ./vendor/bin/sail up -d
- We create the necessary encryption key for Laravel ./vendor/bin/sail artisan key:generate
- We run the migrations and the seeder to create the Passport Keys ./vendor/bin/sail artisan mig:fr --seed
- 
## Pruebas // Testing
Spanish:
- Crear una base de datos de nombre 'testing'
- Corremos los test de feature con ./vendor/bin/sail artisan test

English:
- Create a database named 'testing'
- We run the feature tests with ./vendor/bin/sail artisan test

## Collecion de postman // Postman collection

https://api.postman.com/collections/29191401-aab28074-b580-412e-83cc-cf4e44be7bee?access_key=PMAT-01J3ND4YZCC7Z6JQGGEE4NFRS0

Importar y cargar los datos de prueba en los respectivos request

Import and load the test data in the respective requests


## Diagramacion UML // UML diagram

https://drive.google.com/drive/folders/1PKL-OOAMvFMokH8nLrWcvC2jqxud2PA8?usp=sharing
