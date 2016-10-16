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
				<span class="mdl-radio__label">Employee Group Timesheets</span>
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
	<h4 class="action-sheet__form-header">Report Settings</h4>
	<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="use-rounding-rules">
		<input class="mdl-checkbox__input" id="use-rounding-rules" name="use_rounding_rules" type="checkbox" value="true" checked>
		<span class="mdl-checkbox__label">
			Apply Rounding Rules
			<i class="material-icons" id="use-rounding-rules-tt">info_outline</i>
		</span>
		<span class="mdl-tooltip mdl-tooltip--large" for="use-rounding-rules-tt">
			If you check this box, rounding rules you have configured will be applied to this report.
		</span>
	</label>
	<div class="report-parameters-region"></div>
</form>
