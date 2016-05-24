<p>
	Fill out the fields below to create a new employee.
</p>
<form>
	<div class="mdl-textfield mdl-textfield--floating-label mdl-textfield--full-width mdl-js-textfield">
		<input class="mdl-textfield__input" type="text" id="name" name="name" tabindex="10">
		<label class="mdl-textfield__label" for="name">Name</label>
	</div>
	<div class="mdl-textfield mdl-textfield--floating-label mdl-textfield--full-width mdl-js-textfield">
		<input class="mdl-textfield__input" type="text" id="position" name="position" tabindex="11">
		<label class="mdl-textfield__label" for="position">Position</label>
	</div>
	<div class="mdl-textfield mdl-textfield--floating-label mdl-textfield--full-width mdl-js-textfield">
		<input class="mdl-textfield__input" type="password" id="terminal-key" name="terminal_key" tabindex="12">
		<label class="mdl-textfield__label" for="terminal_key">Swipe a Timecard (Optional)</label>
		<div class="mdl-textfield__tooltip">
			<i class="material-icons" id="terminal-key-tt">info_outline</i>
			<span class="mdl-tooltip mdl-tooltip--large mdl-tooltip--left" for="terminal-key-tt">
				You can always add this later or change this by clicking <strong>Register Timecard</strong> on the main screen.
			</span>
		</div>
	</div>
	<h4 class="action-sheet__form-header">Location</h4>
	<p>Choose the location this employee will primarily work in.</p>
	<div class="location-chooser-region">

	</div>
	<h4 class="action-sheet__form-header">Agency</h4>
	<p>What agency is this employee from? <span class="text-hint">(Optional)</span></p>
	<div class="agency-chooser-region">

	</div>
</form>
