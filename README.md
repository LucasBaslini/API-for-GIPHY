# API de Giphy para PREX

## Instalacion
- clonar el repositorio
- se debe crear el archivo .env siguiendo el ejemplo del .env.example. Agregar la Api Key de GIPHY
- debemos instalar las dependencias de composer para poder iniciar el Laravel Sail. usamos el siguiente codigo
    docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/opt \
    -w /opt \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs
- Levantamos el proyecto con ./vendor/bin/sail up -d
- Creamos la clave de encriptacion ./vendor/bin/sail artisan key:generate
- Corremos las migraciones y el seeder para crear las Key de Passport ./vendor/bin/sail artisan mig:fr --seed

## Testing
- Crear una base de datos de nombre 'testing'
- Corremos los test de feature con ./vendor/bin/sail artisan test

## Collecion de postman

https://api.postman.com/collections/29191401-aab28074-b580-412e-83cc-cf4e44be7bee?access_key=PMAT-01J3ND4YZCC7Z6JQGGEE4NFRS0

Importar y cargar los datos de prueba en los respectivos request


## Diagramacion UML

https://drive.google.com/drive/folders/1PKL-OOAMvFMokH8nLrWcvC2jqxud2PA8?usp=sharing
