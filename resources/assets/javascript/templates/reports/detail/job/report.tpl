<div class="report">
	<div class="report__header">
		<div class="report__header-meta">
			<div class="report__title">Job Summary Report</div>
			<div class="report__date-range">{{{dates}}}</div>
		</div>
		<div class="report__header-main">
			<div class="report__header-details">
				<div class="report__icon"><i class="material-icons">work</i></div>
				<div class="report__info">
					<div class="report__info-title">#{{job.number}} - {{job.name}}</div>
					<div class="report__info-details">
						<strong>Location:</strong> {{job.location}}<br>
						<strong>Customer:</strong> {{job.customer}}<br>
						<strong>Projected Qty. Per Hour:</strong> {{job.productivity.quantity}}<br>
						<strong>No. of Employees Required:</strong> {{job.productivity.employees}}
					</div>
				</div>
			</div>
			<div class="report__header-summary">
				<div class="report__header-summary-title">
					Productivity Score
				</div>
				<div class="report__header-summary-stat">
					{{score}}
				</div>
			</div>
		</div>
	</div>
	<table class="report__data table">
		<tfoot>
		<tr>
			<th colspan="2" class="report__data-total table__cell--non-numeric">
				<span class="total__label">Finished Product</span>
				<span class="total__data">{{totals.quantity}}</span>
			</th>
			<th colspan="3" class="report__data-total">
				<span class="total__label">Total Time</span>
				<span class="total__data">{{total_time}}</span>
			</th>
		</tr>
		</tfoot>
	</table>
</div>

<div class="reports-container"></div>
