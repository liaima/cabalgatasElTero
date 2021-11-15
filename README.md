# cabalgatasElTero

![](https://github.com/liaima/cabalgatasElTero/blob/main/icon.png)

Aplicación para el registro de reservas de Cabalgatas El Tero en Villa La Angostura - Neuquén - Patagonia Argentina.

Ultima versión a la fecha: 0.0.1-alpha

## Descargar la App Android

### [Descargar](https://github.com/liaima/cabalgatasElTero/raw/main/AppAndroid/_ReservationRegistry_14769994.apk "Descargar App")

## Puesta en marcha del Ambiente:

### Puesta en marcha del ambiente PRODUCCION:

- Ejecutar el docker compose:

```
  docker-compose up -d
```

- Igresar al contenedor e intalar composer:

```
docker-compose exec app bash -c "composer install"
```

- Asignar los permisos a las carpetas del repo:

```
sudo chmod 777 src/app/runtime/ src/app/web/assets/ &&\
sudo chmod 775 src/app/models src/app/controllers -R src/app/views
```

### Puesta en marcha del ambiente DESARROLLO:

- Ejecutar el docker compose:

```
  docker-compose -f docker-compose.yml -f docker-compose-dev-yml up -d
```

- Igresar al contenedor e intalar composer:

```
docker-compose exec app bash -c "composer install"
```

- Asignar los permisos a las carpetas del repo:

```
sudo chmod 777 src/app/runtime/ src/app/web/assets/ \
src/app/models src/app/controllers -R src/app/views
```
