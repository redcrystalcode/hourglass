<div class="mini-chooser__loader">
	{{> loading }}
</div>
{{#if show_create_field}}
	<div class="mini-chooser__create-field">
		<div class="mini-chooser__create-field-icon">
			<i class="material-icons">add</i>
		</div>
		<div class="mini-chooser__create-field-input mdl-textfield mdl-textfield--full-width mdl-js-textfield">
			<input class="mdl-textfield__input" type="text" id="mini-chooser-create-field-input" tabindex="11">
			<label class="mdl-textfield__label" for="mini-chooser-create-field-input">New Location</label>
		</div>
		<div class="mini-chooser__create-field-submit">
			<button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
				<i class="material-icons">check</i>
			</button>
		</div>
	</div>
{{/if}}
<div class="mini-chooser__list {{#if is_scrollable}}mini-chooser__list--scrollable{{/if}} {{#if is_fixed_height}}mini-chooser__list--fixed{{/if}}">
</div>
