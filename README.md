# Proyecto API

## Descripción

El API está diseñado para gestionar reportes de semáforos en mal estado mediante una
aplicación en la que los usuarios pueden registrar, reportar y visualizar el estado de los semáforos
en su área, con la capacidad de incluir evidencias (como fotos o videos) y comentarios. Los
administradores, por su parte, pueden gestionar los reportes, asignarlos a semáforos específicos,
y marcar su resolución

## Requisitos

- Docker
- PHP 8.2
- Composer
- Laravel Framework 11.34.2

## Instalación y Ejecución

# Guía para Levantar un Proyecto Docker en Laravel

Esta guía te llevará a través del proceso para levantar un proyecto Laravel utilizando Docker, ejecutar los seeds y realizar pruebas con PHPUnit.

## Paso 1: Instalar compose 
```

docker run --rm -v $(pwd):/app -w /app composer install --no-dev --optimize-autoloader
```


## Paso 2: Hacer el Build del Contenedor Docker

Primero, asegúrate de tener Docker instalado en tu máquina. Si ya lo tienes, navega hasta la raíz de tu proyecto Laravel donde está el archivo `docker-compose.yml`.

##### Ejecuta el siguiente comando para construir las imágenes de Docker:

```bash

docker-compose build
docker compose up 

```


#### Luego crear la db, las migraciones  en el container por bash y correr los seeds 
#### Nota: Para ejecutar esto necesitas entrar en el container
```bash

php artisan migrate:refresh --seed

```

##### Ejecutar los specs , tambien puedes visualizarlos , se probo el controller y los modelos 

```bash

./vendor/bin/phpunit tests

```
##### Para ver la documentación de los endpoints, ir a

```bash

http://localhost:8000/api/documentation

```

### Imagenes referenciales de la doc
<img width="1430" alt="imagen" src="https://github.com/user-attachments/assets/452cd7b2-bcd6-41d1-ad79-3dfa372f1956">



<img width="1403" alt="imagen" src="https://github.com/user-attachments/assets/529b3330-201b-4e9b-bef9-970a8f03e66f">
<img width="1404" alt="imagen" src="https://github.com/user-attachments/assets/5b169edd-811d-47c9-b46b-075d4df55bf2">
<img width="1400" alt="imagen" src="https://github.com/user-attachments/assets/17b37f98-7d2b-4be7-864c-25dc7a1b9b87">
<img width="801" alt="imagen" src="https://github.com/user-attachments/assets/cc712266-8391-42bb-9654-308c42706766">


