# API de Giphy
Este API es una prueba tecnica que realice para una empresa a la cual postule. Consta de una integracion con GIPHY para obtener informacion detallada de Gifs, los cuales pueden ser buscados por nombre o palabras clave, puede ser obtenida la informacion de un gif especifico mediante su ID, como asi tambien pueden ser almcacenados como favoritos para un usuario. Por supuesto, tambien puede registrarse un nuevo usuario, iniciar sesion, cerrarla y obtener informacion de un usuario que este loggeado.

## Stack tecnologico
Este API funciona en base a Laravel 10 y MySQL. Para la autenticacion de usuarios se utiliza Laravel Passport para aplicar OAuth2.0. La diagramacion UML esta hecha con Luchidart y las pruebas unitarias estan hechas con PHPUnit, tambien se adjunta la coleccion de Postman para testeos. El API se monta en un servidor containerizado con Docker.

## Instalacion
- clonar el repositorio
- se debe crear el archivo .env siguiendo el ejemplo del .env.example. Agregar la Api Key de GIPHY (se debe crear previamente)
- debemos instalar las dependencias de composer para poder iniciar el Laravel Sail. usamos el siguiente codigo
    docker run --rm -u "$(id -u):$(id -g)" -v $(pwd):/opt -w /opt laravelsail/php82-composer:latest composer install --ignore-platform-reqs
- Levantamos el proyecto con ./vendor/bin/sail up -d
- Creamos la clave de encriptacion necesaria para Laravel ./vendor/bin/sail artisan key:generate
- Corremos las migraciones y el seeder para crear las Key de Passport ./vendor/bin/sail artisan mig:fr --seed

## Testing
- Crear una base de datos de nombre 'testing'
- Corremos los test de feature con ./vendor/bin/sail artisan test

## Collecion de postman

https://api.postman.com/collections/29191401-aab28074-b580-412e-83cc-cf4e44be7bee?access_key=PMAT-01J3ND4YZCC7Z6JQGGEE4NFRS0

Importar y cargar los datos de prueba en los respectivos request


## Diagramacion UML

https://drive.google.com/drive/folders/1PKL-OOAMvFMokH8nLrWcvC2jqxud2PA8?usp=sharing
