{{#if searchable}}
	<div class="mdl-textfield mdl-textfield--floating-label mdl-textfield--full-width mdl-js-textfield">
		<input class="js-collection-search mdl-textfield__input" type="text" id="search" autocomplete="off" value="">
		<label class="mdl-textfield__label" for="search">Search</label>
	</div>
{{/if}}
<div class="mini-chooser__loading-wrapper">
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
    {{#if selected_model}}
		<div class="mini-chooser__selected">
			<div class="mini-chooser__list-item mini-chooser__list-item--selected">
				<div class="mini-chooser__list-item-icon">
					<i class="material-icons">{{icon}}</i>
				</div>
				<div class="mini-chooser__list-item-body" title="{{primary}}{{#if secondary_clean}} ({{secondary_clean}}){{/if}}">
					{{primary}}
					<span class="mini-chooser__list-item-body-secondary">
						{{{secondary}}}
					</span>
				</div>
				<div class="mini-chooser__list-item-selector">SELECTED</div>

			</div>
		</div>
	{{/if}}
    <div class="mini-chooser__list {{#if is_scrollable}}mini-chooser__list--scrollable{{/if}} {{#if is_fixed_height}}mini-chooser__list--fixed{{/if}}"></div>
</div>
