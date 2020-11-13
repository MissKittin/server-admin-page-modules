<?php $session_regenerate=false; include($system['location_php'] . '/lib/login/login.php'); unset($session_regenerate); ?>
<?php if(!function_exists('prevent_direct')) include($system['location_php'] . '/lib/prevent-direct.php'); prevent_direct('index.full.php'); ?>
<?php header('Content-type: text/javascript; charset: UTF-8'); ?>
// Frontend format
document.addEventListener('DOMContentLoaded', function(){
	// for convert_tables() from MissKittin/simpleblog@GitHub:blog/admin/lib/convertBytes.php
	function convertKilobytes(input)
	{
		if(input === '') return ''; // don't print 0 in empty cell
		if(input === 0) return 0; // don't print unit in cell with 0

		var depth=0;
		while(input >= 1024)
		{
			input=input/1024;
			depth++;
		}
		switch(depth)
		{
			case 0:
				var unit='kB';
				break;
			case 1:
				var unit='MB';
				break;
			case 2:
				var unit='GB';
				break;
			case 3:
				var unit='TB';
				break;
			case 4:
				var unit='PB';
				break;
			default:
				var unit='?B';
		}
		if(depth === 0) // "TypeError: input.toFixed is not a function" workaround
			return input + unit;
		else
			return input.toFixed(1) + unit;
	}

	// run convertKilobytes() on every <td>number</td>
	function convert_tables(div_id)
	{
		var tables=document.getElementById(div_id).getElementsByTagName('table');
		for(var i=0; i<tables.length; i++)
			for(var x=0, row; row=tables[i].rows[x]; x++)
				for(var y=0, col; col=row.cells[y]; y++)
					if(!isNaN(col.innerHTML))
						col.innerHTML=convertKilobytes(col.innerHTML); // number exists in column, convert it
	}

	// create fancy bars
	function create_bars(mainDiv_id, table_index, bar_index, source_index) // source_index is ignored in RAM usage
	{
		var tables=document.getElementById(mainDiv_id).getElementsByTagName('table')[table_index];
		for(var i=1, row; row=tables.rows[i]; i++)
			if(row.cells[0].innerHTML === 'Mem:') // RAM usage
			{
				// calculate bar width
				var total=row.cells[2].innerHTML;
				var avail=row.cells[5].innerHTML;
				var cached=row.cells[4].innerHTML;
				var width_used=Math.floor(((total-avail)*100)/total);
				var width_cached=Math.floor((cached*100)/total);

				// choose bar color
				var used_bar_color='00aa00';
				if(width_used >= 70) var used_bar_color='cccc00';
				if(width_used >= 95) var used_bar_color='ff0000';

				row.cells[bar_index].innerHTML=' \
					<div class="bar-out" style="margin-bottom: 1px;"> \
						<div class="bar-in" style="width: ' + width_used + 'px; background-color: #' + used_bar_color + ';"></div> \
					</div> \
					<div class="bar-out"> \
						<div class="bar-in" style="width: ' + width_cached + 'px; background-color: #8f00ff;"></div> \
					</div> \
				';
			}
			else if(row.cells[0].innerHTML === 'Swap:')  // RAM usage
			{
				// calculate bar width
				var total=row.cells[2].innerHTML;
				var used=row.cells[1].innerHTML;
				var width=Math.floor((used*100)/total);

				// choose bar color
				var bar_color='00aa00';
				if(width >= 70) var bar_color='cccc00';
				if(width >= 95) var bar_color='ff0000';

				row.cells[bar_index].innerHTML=' \
					<div class="bar-out"> \
						<div class="bar-in" style="width: ' + width + 'px; background-color: #' + bar_color + ';"></div> \
					</div> \
				';
			}
			else // Storage/RAM Disks (source_index must be defined in args)
			{
				// remove % char
				var width=row.cells[source_index].innerHTML.replace('%', '');

				// choose bar color
				var bar_color='00aa00';
				if(width >= 70) var bar_color='cccc00';
				if(width >= 95) var bar_color='ff0000';

				row.cells[bar_index].innerHTML=' \
					<div class="bar-out"> \
						<div class="bar-in" style="width: ' + width + 'px; background-color: #' + bar_color + ';"></div> \
					</div> \
				';
			}
	}

	// apply color from bar to text
	function bar_col2td(mainDiv_id, table_index, row_index, cell_index, barCell_index, bar_index)
	{
		var mainDiv=document.getElementById(mainDiv_id);
		var selectedTable=mainDiv.getElementsByTagName('table')[table_index];
		var selectedRow=selectedTable.rows[row_index];
		if(selectedRow != null) // skip error when swap is off
		{
			var selectedCell=selectedRow.cells[cell_index];
			var sourceColor=selectedRow.cells[barCell_index].children[bar_index].children[0].style.backgroundColor;
			selectedCell.style.color=sourceColor;
		}
	}

	// create RAM usage tooltips events for better readability
	function ram_bars_tooltips(mainDiv_id, table_index, bar_index)
	{
		var rowsInTable=document.getElementById(mainDiv_id).getElementsByTagName('table')[table_index].rows;
		for(var i=0; i<rowsInTable.length; i++)
		{
			var bars=rowsInTable[i].cells[bar_index].children;
			for(var x=0; x<bars.length; x++)
			{
				bars[x].addEventListener('mouseenter', function(){
					// create new cell and put percentage value
					var barColor=this.children[0].style.backgroundColor;
					var barTooltip=this.children[0].style.width.replace('px', '%');
					var selectedRow=this.parentElement.parentElement; // selectedRow from ram_bars_tooltips is not available here
					var tooltipRowIndex=selectedRow.cells.length; // contains new cell index
					selectedRow.insertCell(tooltipRowIndex);
					var tooltipRow=selectedRow.cells[tooltipRowIndex];
					tooltipRow.innerHTML=barTooltip;
					tooltipRow.style.color=barColor;
				});
				bars[x].addEventListener('mouseleave', function(){
					// delete cell created by mouseenter event
					var selectedRow=this.parentElement.parentElement; // selectedRow from ram_bars_tooltips is not available here
					var tooltipRowIndex=selectedRow.cells.length-1; // must be -1
					selectedRow.deleteCell(tooltipRowIndex);
				});
			}
		}
	}

	// start
	create_bars('system_content', 0, 5, 6); // Storage
	create_bars('system_content', 1, 4, 5); // RAM disks
	create_bars('system_content', 2, 6, null); // RAM usage
	convert_tables('system_content');
	bar_col2td('system_content', 2, 1, 1, 6, 0); // RAM Mem Used
	bar_col2td('system_content', 2, 1, 3, 6, 0); // RAM Mem Shared
	bar_col2td('system_content', 2, 1, 4, 6, 1); // RAM Mem Cached
	bar_col2td('system_content', 2, 2, 1, 6, 0); // RAM Swap Used
	ram_bars_tooltips('system_content', 2, 6);
});