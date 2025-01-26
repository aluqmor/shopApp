# Aplicación de Venta de Productos

Esta es una aplicación web desarrollada en Laravel que permite crear, comprar y eliminar productos; además de crear y gestionar perfiles de usuario..

## Características

- Creación de usuarios
- Posibilidad de editar nombre de usuario, email y contraseña del propio usuario
- Posibilidad de crear, comprar y eliminar productos


![1](screenshots/1.jpg)


![2](screenshots/2.jpg)


![3](screenshots/3.jpg)


![4](screenshots/4.jpg)


![5](screenshots/5.jpg)


## Instalación

Sigue estos pasos para descargar y configurar el repositorio:

1. Clona el repositorio:

    ```sh
    git clone https://github.com/aluqmor/userApp.git
    ```

2. Navega al directorio del proyecto:

    ```sh
    cd tu-repositorio
    ```

3. Instala las dependencias de Composer:

    ```sh
    composer install
    ```

4. Copia el archivo database.sql y crea la base de datos junto con usuario y contraseña.

5. Cambia el nombre de `.env.example` a `.env`.

6. Configura tu base de datos en el archivo `.env`:

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=nombre_de_tu_base_de_datos
    DB_USERNAME=tu_usuario
    DB_PASSWORD=tu_contraseña
    ```
    
7. Genera la clave de la aplicación:

    ```sh
    php artisan key:generate
    ```

8. Ejecuta las migraciones para crear las tablas necesarias:

    ```sh
    php artisan migrate
    ```
