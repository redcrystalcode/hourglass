<form>
	<div class="mdl-textfield mdl-textfield--floating-label mdl-textfield--full-width mdl-js-textfield">
		<input class="mdl-textfield__input" type="text" id="start" name="start" value="{{start}}" tabindex="1">
		<label class="mdl-textfield__label" for="start">Rule Start Time</label>
	</div>
	<div class="mdl-textfield mdl-textfield--floating-label mdl-textfield--full-width mdl-js-textfield">
		<input class="mdl-textfield__input" type="text" id="end" name="end" value="{{end}}" tabindex="1">
		<label class="mdl-textfield__label" for="end">Rule End Time</label>
	</div>
	<div class="mdl-radio-group">
		<span class="mdl-radio-group__label">Criteria</span>
		<div class="mdl-radio-group__options">
			<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="criteria-all">
				<input {{#compare criteria.time "all"}}checked{{/compare}} class="mdl-radio__button" id="criteria-all" name="criteria[time]" type="radio" value="all">
				<span class="mdl-radio__label">
					All Time Entries
					<i class="material-icons" id="criteria-all-tt">info_outline</i>
				</span>
				<span class="mdl-tooltip mdl-tooltip--large" for="criteria-all-tt">
					This rounding rule will apply to both Clock In, Clock Out, and Break times.
				</span>
			</label>
			<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="criteria-clock-in">
				<input {{#compare criteria.time "clock_in"}}checked{{/compare}} class="mdl-radio__button" id="criteria-clock-in" name="criteria[time]" type="radio" value="clock_in">
				<span class="mdl-radio__label">
					Clock In Entries
					<i class="material-icons" id="criteria-clock-in-tt">info_outline</i>
				</span>
				<span class="mdl-tooltip mdl-tooltip--large" for="criteria-clock-in-tt">
					This rounding rule will only apply to employee Clock In times.
				</span>
			</label>
			<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="criteria-clock-out">
				<input {{#compare criteria.time "clock_out"}}checked{{/compare}} class="mdl-radio__button" id="criteria-clock-out" name="criteria[time]" type="radio" value="clock_out">
				<span class="mdl-radio__label">
					Clock Out Entries
					<i class="material-icons" id="criteria-clock-out-tt">info_outline</i>
				</span>
				<span class="mdl-tooltip mdl-tooltip--large" for="criteria-clock-out-tt">
					This rounding rule will only apply to employee Clock Out times.
				</span>
			</label>
		</div>
	</div>
	<div class="mdl-textfield mdl-textfield--floating-label mdl-textfield--full-width mdl-js-textfield">
		<input class="mdl-textfield__input" type="text" id="resolution" name="resolution" value="{{resolution}}" tabindex="1">
		<label class="mdl-textfield__label" for="resolution">Round To</label>
	</div>
</form>
