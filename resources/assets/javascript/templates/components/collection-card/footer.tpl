{{#if pagination.end}}
	<span class="pagination__stats"><strong>{{pagination.start}}-{{pagination.end}}</strong> of {{pagination.total}}</span>
{{/if}}
<a href="#" class="pagination__arrow js-page-prev {{#unless pagination.enable_prev}}pagination__arrow--disabled{{/unless}}">
	<i class="material-icons">chevron_left</i>
</a>
<a href="#" class="pagination__arrow js-page-next {{#unless pagination.enable_next}}pagination__arrow--disabled{{/unless}}">
	<i class="material-icons">chevron_right</i>
</a>
