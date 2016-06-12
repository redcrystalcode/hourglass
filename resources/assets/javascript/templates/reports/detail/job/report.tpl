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
</div>

<div class="reports-container"></div>
