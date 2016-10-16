<div class="confirm__wrapper">
	<div class="confirm__content">
		{{#if title}}
			<h3 class="confirm__title">{{title}}</h3>
		{{/if}}
		{{#if body}}
			<p class="confirm__body">{{{body}}}</p>
		{{/if}}
	</div>
	<div class="confirm__actions">
		<button class="js-primary-action mdl-button--colored mdl-button mdl-js-button mdl-js-ripple-effect">{{primaryAction}}</button>
		<button class="js-secondary-action mdl-button mdl-js-button mdl-js-ripple-effect">{{secondaryAction}}</button>
	</div>
</div>
