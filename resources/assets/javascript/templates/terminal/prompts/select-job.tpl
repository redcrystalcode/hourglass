<div class="terminal__prompt card">
	<div class="prompt__icon prompt__icon--avatar"><i class="material-icons">person</i></div>
	<div class="prompt__header">
		<h2 class="prompt__title">{{name}}</h2>
		<!--<p class="prompt__subtext">27 hours this week.</p>-->
	</div>
	<h3 class="prompt__instructions prompt__instructions--subdued prompt__instructions--min-spacing">
		Choose a job to clock into.
	</h3>
	<form>
		<div class="mdl-textfield mdl-textfield--floating-label mdl-textfield--full-width mdl-js-textfield">
			<input class="mdl-textfield__input" type="text" id="search" name="search" value="" tabindex="1" autofocus>
			<label class="mdl-textfield__label" for="search">Search for Job</label>
		</div>
		<div class="job-search-region"></div>
	</form>
	<div class="prompt__actions">
		<button tabindex="3" class="js-submit mdl-button mdl-button--primary mdl-js-button mdl-js-ripple-effect" disabled>
			Clock In
		</button>
		<button tabindex="4" class="js-cancel mdl-button mdl-button mdl-js-button mdl-js-ripple-effect">
			Cancel
		</button>
	</div>
	<div class="prompt__toolbar">
		<button class="js-new-job toolbar__button mdl-js-button mdl-js-ripple-effect">
			<i class="button__icon material-icons">add</i>
			<span class="button__text">New Job</span>
		</button>
	</div>
</div>
