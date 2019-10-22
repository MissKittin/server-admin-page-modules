#!/bin/dash
# Command stack: df, tail, grep, sort, free
# free from procps-ng 3.3.12
# html comments are outdated

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
			# Settings
			label="$1"
			total="$2"
			used="$3"
			free="$4"
			shared="$5"
			buff_cache="$6"
			avail="$7"

			case $1 in
				#'-/+') # Buff
				#	echo "<tr>
				#		<td>Buff: </td>
				#		<td>$3</td><!-- used -->
				#		<td>$4</td><!-- total -->
				#		<!-- --><td></td><td></td><td></td><!-- -->
				#		<td>`$0 ram_usage_bars $1`</td>
				#	</tr>"
				#;;
				'Swap:')
					[ "$2" = "0B" ] || \
					echo "<tr>
						<td>$label </td>
						<td>$used</td>
						<td>$total</td>
						<!-- --><td></td><td></td><td></td><!-- no output -->
						<td>`$0 ram_usage_bars $1`</td>
					</tr>"
				;;
				*) # Mem
					echo "<tr>
						<td>$label </td>
						<td id=\"ram-usage\">$used</td>
						<td>$total</td>
						<td>$shared</td>
						<td style=\"color: #8F00FF;\">$buff_cache</td>
						<td>$avail</td>
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
			# Settings
			total="$2"
			used="$3"
			free="$4"
			buff_cache="$6"

			### if input data is about swap, calculate bar percent ((used*100)/(free+used))
			### else
			### calculate bar percent for mem: ((used*100)/total)
			### calculate bar cached for mem: ((buff_cache*100)/total)
			### color bars
			### create bars: two (usage and cache) for mem, one (usage) for swap

			# Parameters
			[ "$1" = 'Swap:' ] && \
				BAR_PERCENT=$((($used*100)/($free+$used))) || \
				BAR_PERCENT=$((($used*100)/$total))
			[ "$1" = 'Swap:' ] || \
				BAR_CACHED=$((($buff_cache*100)/$total))

			# Color bars
			BAR_COLOR=$CGREEN
			[ "$BAR_PERCENT" -ge 60 ] && \
				BAR_COLOR=$CYELLOW || \
			[ "$BAR_PERCENT" -ge 80 ] && \
				BAR_COLOR=$CRED

			# Create bar
			BAR='<div class="bar-out" style="margin-bottom: 1px;">
				<div id="ram-bar-usage" class="bar" style="width: '"$BAR_PERCENT"'px; background-color: #'"$BAR_COLOR"';"></div><!-- used -->
			</div>'
			[ "$1" = 'Swap:' ] || \
				BAR="$BAR"'<div class="bar-out">
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
