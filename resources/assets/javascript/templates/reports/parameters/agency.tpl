<br>
<h4 class="action-sheet__form-header">Group</h4>
<div class="mdl-textfield mdl-textfield--floating-label mdl-textfield--full-width mdl-js-textfield">
	<input class="js-collection-search mdl-textfield__input" type="text" id="search" value="" tabindex="2">
	<label class="mdl-textfield__label" for="search">Search for Group</label>
</div>
<div class="agency-chooser-region"></div>
<div class="form-validation-error" data-validation-error-for="agency_id"></div>

<h4 class="action-sheet__form-header">Date Range</h4>
<div class="mdl-textfield mdl-textfield--floating-label mdl-textfield--full-width mdl-js-textfield">
	<input class="js-date-start mdl-textfield__input" type="text" id="start" name="start" value="" tabindex="2">
	<label class="mdl-textfield__label" for="start">Start Date</label>
</div>
<div class="mdl-textfield mdl-textfield--floating-label mdl-textfield--full-width mdl-js-textfield">
	<input class="js-date-end mdl-textfield__input" type="text" id="end" name="end" value="" tabindex="2">
	<label class="mdl-textfield__label" for="end">End Date</label>
</div>
<h4 class="action-sheet__form-header">Options</h4>
<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="include-no-hours">
	<input class="mdl-checkbox__input" id="include-no-hours" name="include_empty" type="checkbox" value="true">
	<span class="mdl-checkbox__label">
		Include Non-Working Employees
		<i class="material-icons" id="include-no-hours-tt">info_outline</i>
	</span>
	<span class="mdl-tooltip mdl-tooltip--large" for="include-no-hours-tt">
		Include employees that did not work during the date range selected.
	</span>
</label>
<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="include-archived">
	<input class="mdl-checkbox__input" id="include-archived" name="include_archived" type="checkbox" value="true">
	<span class="mdl-checkbox__label">
		Include Archived Employees
		<i class="material-icons" id="include-archived-tt">info_outline</i>
	</span>
	<span class="mdl-tooltip mdl-tooltip--large" for="include-archived-tt">
		Check this box if you want the report to include employees that you've archived.
	</span>
</label>
<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="summary-only">
	<input class="mdl-checkbox__input" id="summary-only" name="summary_only" type="checkbox" value="true">
	<span class="mdl-checkbox__label">
		Summary Page Only
		<i class="material-icons" id="summary-only-tt">info_outline</i>
	</span>
	<span class="mdl-tooltip mdl-tooltip--large" for="summary-only-tt">
		Check this box if you only want the summary page of this report.
	</span>
</label>
