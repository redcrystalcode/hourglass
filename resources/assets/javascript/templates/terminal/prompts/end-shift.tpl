<div class="terminal__prompt card">
	<div class="prompt__icon"><i class="material-icons">assignment_turned_in</i></div>
	<div class="prompt__header">
		<h3 class="prompt__instructions prompt__instructions--min-spacing">
			End Shift
		</h3>
		<h3 class="prompt__instructions prompt__instructions--min-spacing prompt__instructions--subdued">
			Add productivity information for this shift.
		</h3>
	</div>
	<div class="selected-job">
		<div class="selected-job__icon">
			<i class="material-icons">assignment</i>
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
			<input class="mdl-textfield__input" type="text" id="quantity" name="quantity" value="" tabindex="1" autofocus>
			<label class="mdl-textfield__label" for="quantity">Total Quantity Produced</label>
		</div>
		<div class="mdl-textfield mdl-textfield--floating-label mdl-textfield--full-width mdl-js-textfield">
			<input class="mdl-textfield__input" type="text" id="setup" name="setup" value="" tabindex="2">
			<label class="mdl-textfield__label" for="setup">Setup Time (man-hours)</label>
		</div>
		<div class="mdl-textfield mdl-textfield--floating-label mdl-textfield--full-width mdl-js-textfield">
			<textarea class="mdl-textfield__input" type="text" rows="3" id="comments" name="comments" tabindex="3"></textarea>
			<label class="mdl-textfield__label" for="comments">Comments</label>
		</div>
	</form>
	<div class="prompt__actions">
		<button tabindex="4" class="js-end mdl-button mdl-button--primary mdl-js-button mdl-js-ripple-effect">
			End
		</button>
		<button tabindex="5" class="js-cancel mdl-button mdl-js-button mdl-js-ripple-effect">
			Cancel
		</button>
	</div>
</div>
