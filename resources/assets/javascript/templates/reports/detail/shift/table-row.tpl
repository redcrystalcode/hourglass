<td class="table__cell table__cell--non-numeric">{{date}}</td>
<td class="report__data--job-col table__cell table__cell--non-numeric">{{employee.name}}</td>
<td class="table__cell">
	{{#if original_time_in}}
		<i class="report__data--time-tooltip-icon material-icons" id="original-time-in-{{id}}-tt">info_outline</i>
		<span class="report__data--time-tooltip mdl-tooltip" for="original-time-in-{{id}}-tt">
			<strong>Rounded from:</strong> {{original_time_in}}
		</span>
	{{/if}}
	{{time_in}}
</td>
<td class="table__cell">
	{{#if original_time_out}}
		<i class="report__data--time-tooltip-icon material-icons" id="original-time-out-{{id}}-tt">info_outline</i>
		<span class="report__data--time-tooltip mdl-tooltip" for="original-time-out-{{id}}-tt">
			<strong>Rounded from:</strong> {{original_time_out}}
		</span>
	{{/if}}
	{{time_out}}
</td>
<td class="table__cell">{{total_time}}</td>
