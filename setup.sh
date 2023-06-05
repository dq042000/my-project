#!/bin/bash

set -e

# Color https://blog.csdn.net/qq_42372031/article/details/104137272
COLOR_RED='\e[0;31m';
COLOR_GREEN='\e[0;32m';
COLOR_YELLOW='\e[0;33m';
COLOR_BLUE='\e[0;34m';
COLOR_REST='\e[0m'; # No Color
COLOR_BACKGROUND_RED='\e[0;101m';
COLOR_BACKGROUND_GREEN='\e[1;42m';
COLOR_BACKGROUND_YELLOW='\e[1;43m';
COLOR_BACKGROUND_BLUE_GREEN='\e[46m'; # 青色

RemoveContainer () {
    lastResult=$?
    if [ $lastResult -ne 0 ] && [ $lastResult -ne 1 ] && [ $lastResult -ne 130 ] && [ $lastResult -ne 16888 ]; then
        echo "$COLOR_BACKGROUND_RED 狀態:$lastResult, 啟動專案過程有錯誤，移除所有容器。 $COLOR_REST"
        docker-compose down
    elif [ $lastResult = 16888 ]; then
        echo "$COLOR_BACKGROUND_RED 中止... $COLOR_REST"
        docker-compose down
    fi
}
trap RemoveContainer EXIT

# 取得資料夾名稱，因資料夾名稱是容器名稱的 prefix
dir=$(pwd)
fullPath="${dir%/}";
containerNamePrefix=${fullPath##*/}

echo "$COLOR_BACKGROUND_BLUE_GREEN 現在位置 - ${containerNamePrefix} $COLOR_REST"

# Copy config files
cp env-sample .env
cp docker-compose.yml.sample docker-compose.yml
cp .docker/nginx/default.conf.dist .docker/nginx/default.conf
echo "$COLOR_BACKGROUND_YELLOW 準備啟動檔案... 成功 $COLOR_REST"

# 讀取「.env」
. ${dir}/.env

# 預設設定
DefaultSetting() {
    # Copy php config files
    cp web/${PHP_DIRECTORY}/config/autoload/local.php.dist web/${PHP_DIRECTORY}/config/autoload/local.php
    cp web/${PHP_DIRECTORY}/config/autoload/doctrine.local.php.dist web/${PHP_DIRECTORY}/config/autoload/doctrine.local.php
    cp web/${PHP_DIRECTORY}/config/autoload/module.doctrine-mongo-odm.local.php.dist web/${PHP_DIRECTORY}/config/autoload/module.doctrine-mongo-odm.local.php
    cp web/${PHP_DIRECTORY}/config/autoload/memcached.local.php.dist web/${PHP_DIRECTORY}/config/autoload/memcached.local.php
    echo "$COLOR_BACKGROUND_YELLOW 複製 專案 Config 檔案... 成功 $COLOR_REST"

    # Start container
    docker-compose up -d --build
    echo "$COLOR_BACKGROUND_GREEN 啟動容器... 成功 $COLOR_REST"
}

# 開始執行
echo $COLOR_YELLOW"(1) 專案初始化 + 啟動開發環境"$COLOR_REST;
echo $COLOR_YELLOW"(2) 啟動開發環境"$COLOR_REST;
echo $COLOR_YELLOW"(3) 模擬啟動正式環境"$COLOR_REST;
echo $COLOR_YELLOW"(4) 匯入資料庫 $COLOR_RED(確保匯入前將資料庫清空及匯入檔案放置: $COLOR_GREEN./web/${PHP_DIRECTORY}/data/sql) $COLOR_YELLOW"$COLOR_REST;
echo $COLOR_YELLOW"(5) 執行 Migrate"$COLOR_REST;
echo $COLOR_YELLOW"(6) 查看 CLI 指令"$COLOR_REST;
echo $COLOR_YELLOW"(7) 更新 composer 套件"$COLOR_REST;
read -p "請輸入要執行的項目($(tput setaf 2 )1-6$(tput sgr0))[$(tput setaf 3 )2$(tput sgr0)]:" -r user_select
user_select=${user_select:-2}   # 預設為 2

########################################
# 專案初始化 + 啟動開發環境
if [ $user_select = 1 ]; then
    # Run default setting
    DefaultSetting

    # Install php packages
    docker exec -it ${containerNamePrefix}_php_1 composer install && echo "$COLOR_BACKGROUND_GREEN 安裝 php 相關套件... 成功 $COLOR_REST"

    # Cache disabled
    docker exec -it ${containerNamePrefix}_php_1 composer development-enable && echo "$COLOR_BACKGROUND_GREEN 取消 Cache 功能... 成功 $COLOR_REST"

    # Change permission
    sudo chmod 777 -R web/${PHP_DIRECTORY}/data

    echo "$COLOR_BACKGROUND_GREEN 啟動容器... 成功 $COLOR_REST"

    # Start container
    # docker-compose down && echo "$COLOR_BACKGROUND_GREEN 停止容器... 成功 $COLOR_REST"
    # docker-compose up -d --build && echo "$COLOR_BACKGROUND_GREEN 啟動容器... 成功 $COLOR_REST"
    # docker exec -it ${containerNamePrefix}_php_1 bin/cli.sh base:install && echo "$COLOR_BACKGROUND_GREEN 安裝 DB... 成功 $COLOR_REST"

    return 0

########################################
# 啟動開發環境
elif [ $user_select = 2 ]; then
    # Run default setting
    # DefaultSetting

    # Update php packages
    docker exec -it ${containerNamePrefix}_php_1 composer update && echo "$COLOR_BACKGROUND_GREEN 更新 php 相關套件... 成功 $COLOR_REST"

    # Change permission
    sudo chmod 777 -R web/${PHP_DIRECTORY}/data

    echo "$COLOR_BACKGROUND_GREEN 啟動容器... 成功 $COLOR_REST"

    return 0

########################################
# 模擬啟動正式環境
elif [ $user_select = 3 ]; then
    # Run default setting
    # DefaultSetting

    # Update php packages
    docker exec -it ${containerNamePrefix}_php_1 composer update && echo "$COLOR_BACKGROUND_GREEN 更新 php 相關套件... 成功 $COLOR_REST"

    return 0

########################################
# 匯入資料庫
elif [ $user_select = 4 ]; then
    # 存放SQL位置
    dirSQL=web/${PHP_DIRECTORY}/data/sql
    for fileLevelOne in "$dirSQL"/*
    do
        for fileLevelTwo in "$fileLevelOne"
        do
            # 取得檔案名稱
            fileLevelTwoName=$(basename "${fileLevelTwo}")

            # 只允許副檔名為「.sql」
            if [ "${fileLevelTwoName##*.}" = "sql" ]; then
                env LANG=zh_TW.UTF-8 cat $FILE2 | docker exec -i ${containerNamePrefix}_mysqldb_1 mysql -u${MYSQL_ROOT_USER} -p${MYSQL_ROOT_PASSWORD} -h${MYSQL_HOST} ${MYSQL_DATABASE}
                echo "$COLOR_BACKGROUND_GREEN ${fileLevelTwo}... 成功 $COLOR_REST"
            fi
        done
    done

    echo "$COLOR_BACKGROUND_YELLOW 資料匯入... 成功 $COLOR_REST"
    return 0

########################################
# Migrate
elif [ $user_select = 5 ]; then
    ##
    # for php >= 8.0 (php < 8.0 migrations_paths 請留空)
    #
    # 請參考 config/autoload/doctrine.local.php 搜尋: migrations_paths 的設置名稱
    # ex.
    # 'migrations_paths' => [
    #    'Application' => 'data/DoctrineORMModule/Migrations',
    # ],
    # 取得 `Application`
    ##
    migrations_paths='Application\'

    # 開始執行
    echo $COLOR_YELLOW "(1) 執行 workbench export + migrate" $COLOR_REST;
    echo $COLOR_YELLOW "(2) 執行 workbench export" $COLOR_REST;
    echo $COLOR_YELLOW "(3) 產生 migrate 檔案" $COLOR_REST;
    echo $COLOR_YELLOW "(4) 執行 migrate" $COLOR_REST;
    echo $COLOR_YELLOW "(5) 還原 migrate" $COLOR_REST;
    read -p "請輸入要執行的項目(1-5):" migrate_select

    # (1) 執行 workbench export + migrate
    if [ $migrate_select = 1 ]; then
        read -p "$(echo $COLOR_GREEN"確定要執行嗎？(yes/no)"$COLOR_REST"["$COLOR_YELLOW"yes"$COLOR_REST"]")" user_confirm
        user_confirm=${user_confirm:-yes}   # 預設為 yes

        # yes 就執行
        if [ "$user_confirm" = 'yes' ] || [ "$user_confirm" = 'YES' ]; then
            rm -f ${dir}/web/${PHP_DIRECTORY}/data/temp/*
            docker exec -ti ${containerNamePrefix}_php_1 sh bin/export.sh ${MIGRATION_FILE}
            cp ${dir}/web/${PHP_DIRECTORY}/data/temp/*.php ${dir}/web/${PHP_DIRECTORY}/module/Base/src/Entity/
            docker exec -ti ${containerNamePrefix}_php_1 sh bin/doctrine.sh migrations:diff
            git restore web/api/module/Base/src/Entity/*.php
            docker exec -ti ${containerNamePrefix}_php_1 sh bin/doctrine.sh migrations:migrate --no-interaction
            rm -f ${dir}/web/${PHP_DIRECTORY}/data/temp/*
        fi

    # (2) 執行 workbench export
    elif [ $migrate_select = 2 ]; then
        read -p "$(echo $COLOR_GREEN"確定要執行嗎？(yes/no)"$COLOR_REST"["$COLOR_YELLOW"yes"$COLOR_REST"]")" user_confirm
        user_confirm=${user_confirm:-yes}   # 預設為 yes

        # yes 就執行
        if [ "$user_confirm" = 'yes' ] || [ "$user_confirm" = 'YES' ]; then
            rm -f ${dir}/web/${PHP_DIRECTORY}/data/temp/*
            docker exec -ti ${containerNamePrefix}_php_1 sh bin/export.sh ${MIGRATION_FILE}
        fi

    # (3) 產生 migrate 檔案
    elif [ $migrate_select = 3 ]; then
        read -p "$(echo $COLOR_GREEN"確定要執行嗎？(yes/no)"$COLOR_REST"["$COLOR_YELLOW"yes"$COLOR_REST"]")" user_confirm
        user_confirm=${user_confirm:-yes}   # 預設為 yes

        # yes 就執行
        if [ "$user_confirm" = 'yes' ] || [ "$user_confirm" = 'YES' ]; then
            cp ${dir}/web/${PHP_DIRECTORY}/data/temp/*.php ${dir}/web/${PHP_DIRECTORY}/module/Base/src/Entity/
            docker exec -ti ${containerNamePrefix}_php_1 sh bin/doctrine.sh migrations:diff
            git restore web/api/module/Base/src/Entity/*.php
        fi

    # (4) 執行 migrate
    elif [ $migrate_select = 4 ]; then
        read -p "$(echo "請輸入要"$COLOR_YELLOW"migrate"$COLOR_REST"的版本號碼["$COLOR_YELLOW"ex.Version20221202033436"$COLOR_REST"]"):" version_number
        read -p "$(echo $COLOR_GREEN"確定要 migrate 嗎？(yes/no)"$COLOR_REST"["$COLOR_YELLOW"yes"$COLOR_REST"]")" user_answer
        user_answer=${user_answer:-yes}   # 預設為 yes

        # yes 就執行
        if [ "$user_answer" = 'yes' ] || [ "$user_answer" = 'YES' ]; then
            docker exec -ti ${containerNamePrefix}_php_1 bin/doctrine.sh migrations:migrate "${migrations_paths}${version_number}"
            # or 
            # docker exec -ti ${containerNamePrefix}_php_1 bin/doctrine.sh migrations:execute "Application\${version_number}" --up
        fi

    # (5) 還原 migrate
    elif [ $migrate_select = 5 ]; then
        read -p "$(echo "請輸入要"$COLOR_RED"還原"$COLOR_REST"的版本號碼["$COLOR_YELLOW"ex.Version20221202033436"$COLOR_REST"]"):" version_number
        if [ -z "$version_number" ]; then
            echo "$COLOR_RED 請輸入版本號碼 $COLOR_REST"
        else
            read -p "$(echo $COLOR_GREEN"確定要"$COLOR_REST$COLOR_RED"還原"$COLOR_REST $COLOR_GREEN"嗎？(yes/no)"$COLOR_REST"["$COLOR_YELLOW"yes"$COLOR_REST"]")" user_answer
            user_answer=${user_answer:-yes}   # 預設為 yes

            # yes 就執行
            if [ "$user_answer" = 'yes' ] || [ "$user_answer" = 'YES' ]; then
                docker exec -ti ${containerNamePrefix}_php_1 bin/doctrine.sh migrations:execute "${migrations_paths}${version_number}" --down
            fi
        fi
    else
        return 16888
    fi

    echo "$COLOR_BACKGROUND_YELLOW Migrate... 成功 $COLOR_REST"
    return 0

########################################
# 查看 CLI 指令
elif [ $user_select = 6 ]; then
    docker exec -ti ${containerNamePrefix}_php_1 sh bin/cli.sh

    while true; do
        read -p "請輸入要執行的指令，或輸入 exit 離開：" cli_select
        if [ "$cli_select" = "exit" ]; then
            echo "結束..."
            break
        elif [ -n "$cli_select" ]; then
            docker exec -ti ${containerNamePrefix}_php_1 sh bin/cli.sh $cli_select
            echo "$COLOR_BACKGROUND_GREEN 執行... 成功 $COLOR_REST"
        else
            echo "請輸入要執行的指令..."
        fi
    done
    return 0

########################################
# 更新 composer 套件
elif [ $user_select = 7 ]; then
    # Update php packages
    docker exec -it ${containerNamePrefix}_php_1 composer update && echo "$COLOR_BACKGROUND_GREEN 更新 php 相關套件... 成功 $COLOR_REST"

    return 0

else
    echo "請輸入要執行的項目(1-6)"
    return 0
fi