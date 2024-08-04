# SecureDocSing

SecureDocSing es un proyecto Laravel para la firma digital de documentos PDF.

## Requisitos Previos

Asegúrate de tener instalados los siguientes requisitos en tu sistema:

- [PHP](https://www.php.net/) >= 8.2
- [Composer](https://getcomposer.org/)
- [Node.js](https://nodejs.org/) y npm (Node Package Manager)

## Instalación

Sigue estos pasos para instalar y configurar el proyecto:

1. **Clona el repositorio:**

    ```sh
    git clone https://github.com/cristianlosada/SecureDocSign.git
    cd tu_proyecto
    ```

2. **Instala las dependencias de PHP utilizando Composer:**

    ```sh
    composer install
    ```

3. **Copia el archivo de configuración de entorno y genera la clave de la aplicación:**

    ```sh
    cp .env.example .env
    php artisan key:generate
    ```

4. **Configura tu base de datos en el archivo `.env`:**

    Asegúrate de configurar las variables de entorno para tu base de datos en el archivo `.env`.

5. **Migra la base de datos:**

    ```sh
    php artisan migrate
    ```
6. **Instalar dependencias de node.js**

  ```sh
  npm install
  ```

## Levantar el Backend

Para levantar el backend de la aplicación, utiliza el siguiente comando:

```sh
php artisan serve
```

## Levantar el Frontend

Para levantar el frontend de la aplicación, utiliza el siguiente comando:

```sh
npm run dev
```