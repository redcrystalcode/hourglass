<div class="terminal__prompt card animate-enter">
	<div class="prompt__icon"><i class="material-icons">credit_card</i><i class="material-icons prompt__icon-sub">add</i></div>
	<h3 class="prompt__instructions">
		Register Timecard
	</h3>
	<form>
		<div class="mdl-textfield mdl-textfield--floating-label mdl-textfield--full-width mdl-js-textfield">
			<input class="mdl-textfield__input" type="password" id="terminal_key" name="terminal_key" value="" tabindex="1" autofocus>
			<label class="mdl-textfield__label" for="terminal_key">Timecard</label>
		</div>
		<div class="mdl-textfield mdl-textfield--floating-label mdl-textfield--full-width mdl-js-textfield">
			<input class="mdl-textfield__input" type="text" id="search" name="search" value="" tabindex="2" autofocus>
			<label class="mdl-textfield__label" for="search">Search for Employee</label>
		</div>
		<div class="employee-search-region"></div>
	</form>

	<div class="prompt__actions">
		<button tabindex="3" class="js-register mdl-button mdl-button--primary mdl-js-button mdl-js-ripple-effect" disabled>
			Register
		</button>
		<button tabindex="4" class="js-cancel mdl-button mdl-button mdl-js-button mdl-js-ripple-effect">
			Cancel
		</button>
	</div>

	<div class="prompt__toolbar">
		<button class="js-new-employee toolbar__button mdl-js-button mdl-js-ripple-effect">
			<i class="button__icon material-icons">add</i>
			<span class="button__text">New Employee</span>
		</button>
	</div>
</div>
