<div class="report">
	<div class="report__header">
		<div class="report__header-meta">
			<div class="report__title">Agency Employee Timesheets</div>
			<div class="report__date-range">{{start}} &mdash; {{end}}</div>
		</div>
		<div class="report__header-main">
			<div class="report__header-details">
				<div class="report__icon"><i class="material-icons">business_center</i></div>
				<div class="report__info">
					<div class="report__info-title">{{agency.name}}</div>
					<ul class="report__info-details">
						{{#if include_archived}}<li>Including <strong>Archived</strong> Employees</li>{{/if}}
						{{#if include_empty}}<li>Including <strong>Non-Working</strong> Employees</li>{{/if}}
					</ul>
				</div>
			</div>
			<div class="report__header-summary">
				<div class="report__header-summary-title">
					Number of Employees
				</div>
				<div class="report__header-summary-stat">
					{{count}}
				</div>
			</div>
		</div>
	</div>
</div>

<div class="reports-container"></div>
