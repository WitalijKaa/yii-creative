# use it with docker

```
docker compose -f docker/docker-compose-dev.yaml build

docker compose -f docker/docker-compose-dev.yaml -p wk13 up -d

docker compose -f docker-compose-dev.yaml -p wk13 exec -u www-data php php yii migrate --interactive=0
```

- http://localhost/

# yii-creative

- composer create-project --prefer-dist yiisoft/yii2-app-basic yii-creative

# for DEV

create config/params-env.php file

then use docker-compose-dev.yaml file to mount your locals dirs, but dont forget if u add new one

```
docker compose -f docker/docker-compose-dev.yaml build

docker compose -f docker/docker-compose-dev.yaml -p wk13 up -d
```

#### do migration once

```
docker compose -f docker-compose-dev.yaml -p wk13 exec -u www-data php php yii migrate --interactive=0
```

rollback

```
docker compose -f docker-compose-dev.yaml -p wk13 exec -u www-data php php yii migrate/down 1 --interactive=0
```

## check yaml

```
docker compose -f docker-compose-dev.yaml -p wk13 -f docker/docker-compose-dev.yaml config
```

#### artisan stub for docker

```
docker compose -f docker-compose-dev.yaml -p sc13 exec -u www-data sc_php php artisan 
docker compose -f docker-compose-dev.yaml -p sc22 exec -u www-data sc_php php artisan 
```

#### DEBUG

```
docker compose -f docker-compose-dev.yaml -p sc13 exec sc_php php artisan tinker
docker compose -f docker-compose-dev.yaml -p sc13 exec sc_php php -r 'echo "hi\n";'
docker compose -f docker-compose-dev.yaml -p sc13 exec sc_php ls -la /app/storage /app/storage/logs
docker compose -f docker-compose-dev.yaml -p sc13 exec sc_php ls -la /app
```