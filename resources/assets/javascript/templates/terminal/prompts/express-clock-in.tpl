<div class="terminal__prompt card express-clock-in">
	<div class="prompt__icon"><i class="material-icons">timer</i><i class="material-icons prompt__icon-sub">done_all</i></div>
	<div class="prompt__header">
		<h3 class="prompt__instructions prompt__instructions--min-spacing">
			Express Clock In
		</h3>
		<h3 class="prompt__instructions prompt__instructions--subdued prompt__instructions--min-spacing">
			Swipe your timecard to clock in to this job.
		</h3>
	</div>
	<div class="selected-job">
		<div class="selected-job__icon">
			<i class="material-icons">work</i>
		</div>
		<div class="selected-job__body" title="#{{job.number}} ({{job.name}})">
			#{{job.number}}
			<span class="selected-job__body-secondary">
				{{job.name}}
			</span>
		</div>
	</div>
	<form>
		<div class="mdl-textfield mdl-textfield--floating-label mdl-textfield--full-width mdl-js-textfield">
			<input class="mdl-textfield__input" type="password" id="terminal_key" name="terminal_key" value="" tabindex="1" autofocus>
			<label class="mdl-textfield__label" for="terminal_key">Timecard</label>
		</div>
	</form>
	<div class="prompt__actions">
		<button tabindex="2" class="js-finish mdl-button mdl-button--primary mdl-js-button mdl-js-ripple-effect">
			All Done
		</button>
	</div>
</div>
