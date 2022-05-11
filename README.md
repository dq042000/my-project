# 安裝方式

## 切換開發環境分支

  - master
  - production : 正式環境
  - develop : 開發環境
```
  git checkout develop
```

## docker 設定檔

```
cp docker-compose-sample.yml docker-compose.yml
cp env-sample .env
```

## 啟動 docker

```
docker-compose up -d --build
```

## 安裝 php library

```
docker exec -ti mylaravel_php_1 composer install
```

## 開啟瀏覽器

    網站
    http://localhost:9810

    phpMyAdmin
    http://localhost:9811

