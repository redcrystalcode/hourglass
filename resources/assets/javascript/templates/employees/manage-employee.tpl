<form>
	{{! Prevent Chrome Password Autofill from Taking Over !}}
	<input type="password" style="width: 0;height: 0; visibility: hidden;position:absolute;left:0;top:0;"/>
	<div class="mdl-textfield mdl-textfield--floating-label mdl-textfield--full-width mdl-js-textfield">
		<input class="mdl-textfield__input" type="text" id="name" name="name" value="{{name}}" tabindex="10">
		<label class="mdl-textfield__label" for="name">Name</label>
	</div>
	<div class="mdl-textfield mdl-textfield--floating-label mdl-textfield--full-width mdl-js-textfield">
		<input class="mdl-textfield__input" type="text" id="position" name="position" value="{{position}}" tabindex="11" autocomplete="off">
		<label class="mdl-textfield__label" for="position">Position</label>
	</div>
	<div class="mdl-textfield mdl-textfield--floating-label mdl-textfield--full-width mdl-js-textfield">
		<input class="mdl-textfield__input" type="text" id="terminal-key" name="terminal_key" value="{{terminal_key}}" tabindex="12" autocomplete="off">
		<label class="mdl-textfield__label" for="terminal_key">Swipe a Timecard (Optional)</label>
		<div class="mdl-textfield__tooltip">
			<i class="material-icons" id="terminal-key-tt">info_outline</i>
			<span class="mdl-tooltip mdl-tooltip--large mdl-tooltip--left" for="terminal-key-tt">
				You can always add this later or change this by clicking <strong>Register Timecard</strong> on the main screen.
			</span>
		</div>
	</div>
	<h4 class="action-sheet__form-header">Location</h4>
	<div class="form-validation-error" data-validation-error-for="location.id"></div>
	<p>Choose the location this employee will primarily work in.</p>
	<div class="location-chooser-region">

	</div>
	<h4 class="action-sheet__form-header">Group</h4>
	<div class="form-validation-error" data-validation-error-for="agency.id"></div>
	<p>Assign this employee to a group.</p>
	<div class="agency-chooser-region">

	</div>
</form>
