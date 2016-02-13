#!/bin/bash
########################################################################################################################
SCRIPT=`basename $0`
LOCKFILE=/tmp/${SCRIPT}.lock
MAINTAINS_LOCK_FILE="/tmp/${SCRIPT}-maintain.lock"

if [ -f ${MAINTAINS_LOCK_FILE} ]; then
    echo "$0: quit at start: maintains lock file exist!"
    exit 0

fi

if [ -f ${LOCKFILE} ]; then
    if [ "$(ps -p `cat ${LOCKFILE}` | wc -l)" -gt 1 ]; then
        echo "$0: quit at start: lingering process `cat ${LOCKFILE}`"
        exit 0
    else
        echo "$0: orphan lock file warning. Lock file deleted."
        rm ${LOCKFILE}
    fi
fi

echo $$ > ${LOCKFILE}
########################################################################################################################

echo Process ID is $$

DIR=`dirname $0`
TEMP="/tmp/$(basename $0).$$.tmp"

while true; do
	if [ -f ${DIR}/cache/stop ]; then
		echo Stop on file
		break
	fi

	/usr/bin/php ${DIR}/task.php main ping

	echo "Okay" > ${DIR}/daemon.log
	TASKS=`/usr/bin/php ${DIR}/task.php main execute`

	if [ "" != "${TASKS}" ]; then
		while read -r line; do
			JID=$(echo $line | awk -F":" '{ print $1 }')
			CMD=$(echo $line | awk -F":" '{ print $2 }')
			echo Executing job $JID: $CMD
			$($CMD > $TEMP)
			/usr/bin/php ${DIR}/task.php main response $JID $TEMP
		done <<< "$TASKS"
	fi
	sleep 5
done

rm -f $TEMP

########################################################################################################################
rm -f ${LOCKFILE}
