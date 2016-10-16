<span class="mdl-list__item-primary-content">
	<i class="material-icons mdl-list__item-avatar">person</i>
	<span><strong>{{name}}</strong>{{#if position}} - {{position}}{{/if}} {{#if archived}}<span class="badge badge--gray">Archived</span>{{/if}}</span>
	<span class="mdl-list__item-sub-title"><strong>Location:</strong> {{location.name}}{{#if agency}} | <strong>Group:</strong> {{agency.name}}{{/if}}</span>
</span>
<span class="mdl-list__item-secondary-content">
	<span class="mdl-list__item-secondary-action menu-container"></span>
</span>
