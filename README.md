# cabalgatasElTero
Descripción...

## Puesta en marcha del Ambiente:

--Primer inicio:
```
docker-compose up -docker
```
```
docker-compose exec -u www-data app bash -c "composer create-project --prefer-dist yiisoft/yii2-app-basic ."
```

- Inicios secundarios:

```
docker-compose up -docker
```
```
docker-compose exec -u www-data app bash -c "composer install" 
```
