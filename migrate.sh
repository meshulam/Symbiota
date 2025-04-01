#!/usr/bin/env bash

set -euo pipefail

CONFIG=/root/oitdev.my.cnf
DB=msi_symbiota_dev

echo `date` " - starting backup"
# dump local db to file
mkdir -p /var/staging/db
mysqldump --single-transaction --quick -u symbiota_ro -h chaos.msi.umn.edu -p symbiota_production | gzip > /var/staging/db/symbiota1-finalbackup.sql.gz

echo `date` " - backup finished, starting import to $DB"
# update character set before importing
zcat /var/staging/db/symbiota1-finalbackup.sql.gz \
  | sed 's/CHARACTER SET utf8 COLLATE utf8_general_mysql500_ci//' \
  | sed 's/DEFAULT CHARSET=utf8.*;$/DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;/' \
  | sed 's/UNIQUE KEY `sciname_unique`.*$//' \
  | mysql --defaults-file=$CONFIG --init-command="SET SESSION FOREIGN_KEY_CHECKS=0;" $DB

echo `date` " - applying bellatlas-consistency"
mysql --defaults-file=$CONFIG $DB < /var/mbaenrm/symbiota_dev/config/schema/1.0/patches-bellatlas/db_schema_patch-bellatlas-consistency.sql
echo `date` " - applying patch 1.2"
mysql --defaults-file=$CONFIG $DB < /var/mbaenrm/symbiota_dev/config/schema/1.0/patches-bellatlas/db_schema_patch-1.2.sql
echo `date` " - applying patch 3.0"
mysql --defaults-file=$CONFIG $DB < /var/mbaenrm/symbiota_dev/config/schema/1.0/patches-bellatlas/db_schema_patch-3.0.sql
echo `date` " - applying patch 3.1"
mysql --defaults-file=$CONFIG $DB < /var/mbaenrm/symbiota_dev/config/schema/3.0/patches-bellatlas/db_schema_patch-3.1.sql
echo `date` " - applying patch bellatlas-custom"
mysql --defaults-file=$CONFIG $DB < /var/mbaenrm/symbiota_dev/config/schema/3.0/patches-bellatlas/db_schema_patch-bellatlas-custom.sql

echo `date` " - Done!"
