<div class="action-sheet__loader">
	{{> loading }}
</div>
<header class="action-sheet__header">
	<div class="header__icon js-close-button">
		<i class="material-icons">close</i>
	</div>
	<div class="header__title">
		{{title}}
	</div>
</header>
<main class="action-sheet__body"></main>
{{#if has_footer}}
	<footer class="action-sheet__footer">
		{{#primary_action}}
			<button tabindex="3" class="js-primary-action footer__button--positive mdl-button mdl-button--accent mdl-js-button mdl-js-ripple-effect">{{label}}</button>
		{{/primary_action}}
		{{#secondary_action}}
			<button tabindex="4" class="js-secondary-action footer__button--negative mdl-button mdl-js-button mdl-js-ripple-effect">{{label}}</button>
		{{/secondary_action}}
	</footer>
{{/if}}
