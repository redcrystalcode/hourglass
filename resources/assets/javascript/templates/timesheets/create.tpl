<form>
	<h4 class="action-sheet__form-header">Employee</h4>
	<div class="employee-chooser-region">

	</div>
	<div class="form-validation-error" data-validation-error-for="employee.id"></div>


	<h4 class="action-sheet__form-header">Job</h4>
	<p class="action-sheet__form-hint">Choose the job that this employee worked on.</p>
	<div class="job-chooser-region">

	</div>
	<div class="form-validation-error" data-validation-error-for="job.id"></div>


	<div class="mdl-textfield mdl-textfield--floating-label mdl-textfield--full-width mdl-js-textfield">
		<input class="js-date-field mdl-textfield__input" type="text" id="date" name="date" value="{{date}}">
		<label class="mdl-textfield__label" for="date">Date</label>
	</div>
	<div class="mdl-textfield mdl-textfield--floating-label mdl-textfield--full-width mdl-js-textfield">
		<input class="mdl-textfield__input" type="text" id="time_in" name="time_in" value="{{time_in}}">
		<label class="mdl-textfield__label" for="time_in">Start Time</label>
	</div>
	<div class="mdl-textfield mdl-textfield--floating-label mdl-textfield--full-width mdl-js-textfield">
		<input class="mdl-textfield__input" type="text" id="time_out" name="time_out" value="{{time_out}}">
		<label class="mdl-textfield__label" for="time_out">End Time</label>
	</div>
</form>
