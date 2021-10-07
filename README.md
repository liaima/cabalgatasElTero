# cabalgatasElTero
Descripción...

## Puesta en marcha del Ambiente:

### Primer inicio:
- Correr el docker-compose:
```
docker-compose up -docker
```
- Instalar el Ambiente:
```
docker-compose exec -u www-data app bash -c "composer create-project --prefer-dist yiisoft/yii2-app-basic ."
```
### Inicios secundarios:
- Correr el docker-compose:
```
docker-compose up -docker
```
- Actualizar el Ambiente:
```
docker-compose exec -u www-data app bash -c "composer install" 
```
