#!/bin/sh
# 检测php-fpm是否意外退出, 自动重启

LOGFILE=/var/log/$(basename $0 .sh).log
PATTERN="php-fpm"
RECOVERY="/usr/local/php/sbin/php-fpm start"

while true
do
        TIMEPOINT=$(date -d "today" +"%Y-%m-%d_%H:%M:%S")
        PROC=$(pgrep -o -f ${PATTERN})
        #echo ${PROC}
        if [ -z "${PROC}" ]; then
            ${RECOVERY} >> $LOGFILE
            echo "[${TIMEPOINT}] ${PATTERN} ${RECOVERY}" >> $LOGFILE
                
        #else
            #echo "[${TIMEPOINT}] ${PATTERN} ${PROC}" >> $LOGFILE
        fi
sleep 5
done & 
    
