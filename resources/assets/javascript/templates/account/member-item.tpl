<span class="mdl-list__item-primary-content">
	<i class="material-icons mdl-list__item-avatar">person</i>
	<span>{{name}} {{#if is_self}}<span class="badge badge--accent">You</span>{{/if}}</span>
	<span class="mdl-list__item-sub-title">{{email}} &bull; {{role}}</span>
</span>
<span class="mdl-list__item-secondary-content">
	{{#if is_invitation}}
		<button class="js-revoke-invitation mdl-button mdl-button--accent mdl-js-button mdl-js-ripple-effect">Revoke</button>
	{{else}}
		<span class="mdl-list__item-secondary-action menu-container"></span>
	{{/if}}
</span>
