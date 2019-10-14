#!/bin/dash

# Import PATH variable
. ./lib/shell/path.rc

case $1 in
	logged_users)
		fquery()
		{
			HOST=`echo $6 | sed -e 's/(/ /g' | sed -e 's/)/ /g'`
			[ $HOST ] || HOST="local terminal"
			echo "<tr>
				<td>$1</td><!-- user -->
				<td>$2</td><!-- term -->
				<td>$4 $3 $5</td><!-- date -->
				<td>$HOST</td><!-- ip -->
				<td>"'<button type="submit" name="kick_user" value="'"$2"'">Kick</button></td>
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
esac

exit 0
