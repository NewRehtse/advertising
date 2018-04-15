# Advertising

Esto es un ejemplo de como gestionar una campaña de publicidad utilizando Symfony4.0 y DDD.
Se pueden crear anuncios con componentes, pudiendo acceder al detalle de cada uno, modificarlo o eliminarlo

## Docker 

Para probarlo se puede utilizar docker, hay que instalar docker y docker-compose.

Para acceder al contenedor del servidor web: 

  - **docker-compose exec --user application webserver bash**
  
Para acceder al contenedor del servidor de la base de datos: 

  - **docker-compose exec database bash**
  
Para generar el esquema de la base de datos dentro del contenedero del servidor web. 
(He modificado el .env.dist para que tire de database en lugar de localhost)
```
cd /var/www
php bin/console doctrine:schema:create
```
  
Los puertos expuestos:

  - **Servidor web**: 80
  - **Servidor base de datos**: 3306
  
Base de datos: sunmedia

Usuarios:

  - nombre de usuario: **root**
  - password: **root**
  

  - nombre de usuario: **sunmedia**
  - password: **sunmedia**
  
## Pendiente de hacer

- Falta pasar covertura completa.
- El resto de rutas de la api 
    - /advertisement/{id}/component - Para listar sólo los componentes de un anuncio | Borrar | Modificar
    - /advertisement/{id}/component/{id} - Para listar la info detallada de un componente | Borrar | Modificar
- Se podría validar que el formato de la url coincida con el formato, ejemplo url: http://www.sunmedia.tv/archivo.mp4 si el formato es mp4
- Pruebas con behat
