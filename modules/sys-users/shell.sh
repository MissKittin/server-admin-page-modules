#!/usr/local/share/router/webadmin/share/webadmin/lib/shell/superuser.sh /bin/dash
#?php has_superuser_shebang
# Command stack: dash, sed, last, grep, who

# Import PATH variable
. ./lib/shell/path.rc

case $1 in
	'logged_users')
		fquery()
		{
			# $1 -> user
			# $2 -> term
			# $4 $3 $5 -> date
			# $HOST -> ip

			HOST=`echo $6 | sed -e 's/(/ /g' | sed -e 's/)/ /g'`
			[ $HOST ] || HOST="local terminal"
			echo "<tr>
				<td>$1</td>
				<td>$2</td>
				<td>$4 $3 $5</td>
				<td>$HOST</td>
				<td>"'<button class="system_button" type="submit" name="kick_user" value="'"$2"'">Kick</button></td>
			</tr>'
		}
		if ! last | grep 'still logged in' > /dev/null 2>&1; then
			echo '<tr>
				<td>-</td>
				<td>-</td>
				<td>- - -</td>
				<td>-</td>
			</tr>'
		else
			who | while read line; do
				fquery $line
			done
		fi
	;;
	'kick_user')
		/usr/bin/pkill -9 -t $2
	;;
esac

exit 0
