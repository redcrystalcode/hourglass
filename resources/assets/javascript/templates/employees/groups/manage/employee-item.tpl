<span class="mdl-list__item-primary-content">
	<i class="material-icons mdl-list__item-avatar">person</i>
	<span>
		{{name}}
		{{#if is_add}}
			{{#if agency}} <span class="badge">{{agency.name}}</span>{{/if}}
		{{/if}}
	</span>
</span>
<span class="mdl-list__item-secondary-content">
	{{#if is_add}}
		<button class="js-add-button mdl-button mdl-js-button mdl-button--icon">
			<i class="material-icons">add</i>
		</button>
	{{/if}}
	{{#if is_remove}}
		<button class="js-remove-button mdl-button mdl-js-button mdl-button--icon">
			<i class="material-icons">clear</i>
		</button>
	{{/if}}
</span>
