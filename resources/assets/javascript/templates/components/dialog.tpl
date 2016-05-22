<div class="dialog__wrapper">
	<div class="dialog__content">
		{{#if title}}
			<h3 class="dialog__title">{{title}}</h3>
		{{/if}}
		{{#if body}}
			<p class="dialog__body">{{{body}}}</p>
		{{/if}}
	</div>
	<div class="dialog__actions">
		<button class="js-primary-action mdl-button mdl-js-button mdl-js-ripple-effect">{{primaryAction}}</button>
		<button class="js-secondary-action mdl-button mdl-js-button mdl-js-ripple-effect">{{secondaryAction}}</button>
	</div>
</div>
