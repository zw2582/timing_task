#!/bin/bash
#./etc/profile 
PNAME="/bin/php ./yii hello/index" 
PATHNAME=/home/wwwroot/integle_hui/apply/integle_task/
LENGTH=`ps -ef|grep "$PNAME"|grep -v grep|cut -b 49-200|wc -c ` 
if test $LENGTH -eq 0
then
cd $PATHNAME
$PNAME >/dev/null &
fi

PNAME="/bin/php ./yii hello/index" 
PATHNAME=/home/wwwroot/integle_hui/apply/integle_task/
PID=`ps -ef|grep "$PNAME"|grep -v "grep"|awk '{print $2}'`
#Лђеп
#PID=`ps -ef|grep "$PNAME"|grep -v "grep"|cut -b 10-15`
LENGTH=echo $PID|wc -c
if test $length -ne 0
then
kill -9 $PID
fi