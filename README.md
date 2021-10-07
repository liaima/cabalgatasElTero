# cabalgatasElTero
Descripción...

## Puesta en marcha del Ambiente:

### Primer inicio:
- Correr el docker-compose:
```
docker-compose up -d
```
- Instalar el Ambiente:
```
docker-compose exec app bash -c "composer create-project --prefer-dist yiisoft/yii2-app-basic ."
```
### Inicios secundarios:
- Correr el docker-compose:
```
docker-compose up -d
```
- Actualizar el Ambiente:
```
docker-compose exec -u www-data app bash -c "composer install" 
```
