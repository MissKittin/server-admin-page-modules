#!/bin/dash

# Import PATH variable
. ./lib/shell/path.rc

case $1 in
	'disk_usage')
		CGREEN='00aa00'
		CRED='ff0000'
		CYELLOW='cccc00'

		fquery()
		{
			### function parameters: fquery_nodev=false|true

			# Edit parameters
			case $6 in
				'/')
					MOUNTPOINT=' root'
					DEVICE='sda1'
				;;
				*)
					MOUNTPOINT=`echo $6 | sed -e 's\/media/\ \g'`
					DEVICE=`echo $1 | sed -e 's\/dev/\ \g'`
				;;
			esac
			BAR_PERCENT=`echo $5 | sed -e 's/%/px/g'`
			# Color bars
			BAR_COLOR=$CGREEN
			[ "`echo $5 | sed -e 's/%/ /g'`" -ge 70 ] && \
				BAR_COLOR=$CYELLOW
			[ "`echo $5 | sed -e 's/%/ /g'`" -ge 95 ] && \
				BAR_COLOR=$CRED
			# Create bar
			BAR='<div class="bar-out">
				<div class="bar" style="width: '"$BAR_PERCENT"'; background-color: #'"$BAR_COLOR"';">
				</div>
			</div>'
			# Make table row
			echo "<tr>
				<td>$MOUNTPOINT</td>
				<td>$2</td><!-- size -->
				<td>$3</td><!-- used -->
				<td>$4</td><!-- avail -->
				"; [ $fquery_nodev ] || echo "<td>$DEVICE</td>"; echo "
				<td>$BAR</td>
				<td style='text-align: right'>$5</td><!-- used -->
			</tr>"
		}

		case $2 in
			'') # normal
				# root
				df -h / | tail -n +2 | while read line; do
					fquery $line
				done
		
				# storage
				df -h | grep media | sort -k2 | while read line; do
					fquery $line
				done
			;;
			*) # custom
				[ "$3" = 'nodev' ] && fquery_nodev=true # setup fquery
				df -h | grep $2 | sort -k2 | while read line; do
					fquery $line
				done
			;;
		esac
	;;
	'ram_usage')
		fquery()
		{
			case $1 in
				'-/+') # Buff
					echo "<tr>
						<td>Buff: </td>
						<td>$3</td><!-- used -->
						<td>$4</td><!-- total -->
						<!-- --><td></td><td></td><td></td><!-- -->
						<td>`$0 ram_usage_bars $1`</td>
					</tr>"
				;;
				'Swap:') # Swap
					[ "$2" = "0B" ] || \
					echo "<tr>
						<td>$1 </td><!-- Swap: -->
						<td>$3</td><!-- used -->
						<td>$2</td><!-- total -->
						<!-- --><td></td><td></td><td></td><!-- -->
						<td>`$0 ram_usage_bars $1`</td>
					</tr>"
				;;
				*) # Mem
					echo "<tr>
						<td>$1 </td><!-- Mem: -->
						<td id=\"ram-usage\">$3</td><!-- used -->
						<td>$2</td><!-- total -->
						<td>$5</td><!-- shr -->
						<td>$6</td><!-- buff -->
						<td style=\"color: #8F00FF;\">$7</td><!-- cchd -->
						<td>`$0 ram_usage_bars $1`</td>
					</tr>"
				;;
			esac
		}
		free -h | tail -n +2 | while read line; do
			fquery $line
		done
	;;
	'ram_usage_bars')
		CGREEN='00aa00'
		CRED='ff0000'
		CYELLOW='888800'

		fquery()
		{
			## $1(Mem:) $2(1031716) $3(487920) $4(543796) $5(0) $6(13084)
			# Parameters
			[ "$1" = '-/+' ] && \
				BAR_PERCENT=$((($3*100)/($4+$3))) || \
				BAR_PERCENT=$((($3*100)/$2))
			[ "$1" = '-/+' ] || \
				BAR_CACHED=$((($7*100)/$2))
			# Color bars
			BAR_COLOR=$CGREEN
			[ "$BAR_PERCENT" -ge 60 ] && \
				BAR_COLOR=$CYELLOW || \
			[ "$BAR_PERCENT" -ge 80 ] && \
				BAR_COLOR=$CRED
			# Create bar
			BAR='<div class="bar-out" style="margin-bottom: 1px;">
				<div id="ram-bar-usage" class="bar" style="width: '"$BAR_PERCENT"'px; background-color: #'"$BAR_COLOR"';"></div><!-- used -->
			</div>
			<div class="bar-out">
				<div id="ram-bar-cached" class="bar" style="width: '"$BAR_CACHED"'px; background-color: #8F00FF;"></div><!-- cached -->
			</div>'

			# Print
			echo "$BAR"
		}
		free | grep -e $2 | while read line; do
			fquery $line
		done
	;;
esac

exit 0
