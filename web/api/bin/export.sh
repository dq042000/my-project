#!/bin/bash

rm -f $(pwd)/data/temp/*
vendor/bin/mysql-workbench-schema-export --config=db/db-mwb.json db/$1