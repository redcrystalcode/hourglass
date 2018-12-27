<section class="section">
	<header class="section__header">
		<h3 class="header__title">Timesheets</h3>
	</header>
	<div class="timesheets card card--flush">
		<div class="timesheets-card__loader">
			{{> loading }}
		</div>
		<button class="timesheets__fab js-add-button mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--fab mdl-button--mini-fab mdl-button--colored">
			<i class="material-icons">add</i>
		</button>
		<table class="table table--full-width timesheets__table timesheets__table--empty" >
			<thead>
				<tr>
					<th class="timesheets__date-column table__cell table__cell--non-numeric">Date</th>
					<th class="timesheets__name-column table__cell table__cell--non-numeric">Name</th>
					<th class="timesheets__job-column table__cell table__cell--non-numeric">Job</th>
					<th class="timesheets__time-in-column table__cell table__cell--non-numeric">Time In</th>
					<th class="timesheets__time-out-column table__cell table__cell--non-numeric">Time Out</th>
					<th class="timesheets__total-time-column table__cell table__cell--non-numeric">Hrs. Worked</th>
					<th class="timesheets__edit-column table__cell table__cell--edit"></th>
				</tr>
			</thead>
			<tbody></tbody>
			<tfoot>
				<td colspan="7">
					{{#if pagination.end}}
					<span class="pagination__stats"><strong>{{pagination.start}}-{{pagination.end}}</strong> of {{pagination.total}}</span>
					{{/if}}
					<a href="#" class="pagination__arrow js-page-prev {{#unless pagination.enable_prev}}pagination__arrow--disabled{{/unless}}">
						<i class="material-icons">chevron_left</i>
					</a>
					<a href="#" class="pagination__arrow js-page-next {{#unless pagination.enable_next}}pagination__arrow--disabled{{/unless}}">
						<i class="material-icons">chevron_right</i>
					</a>
				</td>
			</tfoot>
		</table>
	</div>
</section>
