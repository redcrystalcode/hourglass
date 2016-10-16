<div class="report">
	<div class="report__header">
		{{#if show_meta}}
			<div class="report__header-meta">
				<div class="report__title">Employee Timesheet</div>
				<div class="report__date-range">{{start}} &mdash; {{end}}</div>
			</div>
		{{/if}}
		<div class="report__header-main">
			<div class="report__header-details">
				<div class="report__icon report__icon--avatar"><i class="material-icons">person</i></div>
				<div class="report__info">
					<div class="report__info-title">{{employee.name}}</div>
					<div class="report__info-details">
						<strong>Location:</strong> {{employee.location}}<br>
						<strong>Group:</strong> {{employee.agency}}
					</div>
				</div>
			</div>
			<div class="report__header-summary">
				<div class="report__header-summary-title">
					Total Time Worked
				</div>
				<div class="report__header-summary-stat">
					{{total_time}}
				</div>
			</div>
		</div>
	</div>
	<table class="report__data table">
		<thead>
			<tr>
				<th class="table__cell table__cell--non-numeric">Date</th>
				<th class="report__data--job-col table__cell table__cell--non-numeric">Job</th>
				<th class="table__cell">Time In</th>
				<th class="table__cell">Time Out</th>
				<th class="table__cell">Total Time</th>
			</tr>
		</thead>
		<tbody></tbody>
		<tfoot>
			<tr>
				<th colspan="5" class="report__data-total">
					<span class="total__label">Total Time Worked</span>
					<span class="total__data">{{total_time}}</span>
				</th>
			</tr>
		</tfoot>
	</table>
</div>
