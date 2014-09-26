#!/bin/bash
PATH=/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin

# Generates changelog day by day

echo "<h3>CHANGELOG</h3>"

echo ----------------------

echo "<p>CRON Update:"
echo `date +\%F::\%T`
echo "</p>"

/usr/bin/git log --no-merges --format="%cd" --date=short | sort -u -r | while read DATE ; do

    echo "<br />"

    echo "<p>[$DATE]</p>"

    GIT_PAGER=cat /usr/bin/git log --no-merges --format="<p> * %s</p>" --since="$DATE 00:00:00" --until="$DATE 24:00:00"

done
