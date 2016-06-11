<form>
	<h4 class="action-sheet__form-header">Report Type</h4>
	<div class="form-validation-error" data-validation-error-for="type"></div>
	<p>Choose what type of report you'd like to create.</p>
	<div class="mdl-radio-group">
		<div class="mdl-radio-group__options">
			<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="report-type-timesheet">
				<input class="mdl-radio__button" id="report-type-timesheet" name="type" type="radio" value="timesheet">
				<span class="mdl-radio__label">Employee Timesheet</span>
			</label>
			<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="report-type-agency">
				<input class="mdl-radio__button" id="report-type-agency" name="type" type="radio" value="agency">
				<span class="mdl-radio__label">Agency Employee Timesheets</span>
			</label>
			<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="report-type-shift">
				<input class="mdl-radio__button" id="report-type-shift" name="type" type="radio" value="shift">
				<span class="mdl-radio__label">Job Shift</span>
			</label>
			<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="report-type-job">
				<input class="mdl-radio__button" id="report-type-job" name="type" type="radio" value="job">
				<span class="mdl-radio__label">Job Summary</span>
			</label>
		</div>
	</div>
	<div class="report-parameters-region"></div>
</form>
