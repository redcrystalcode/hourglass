{{#if title}}
	<div class="header__title">
		<span>{{title}}</span>
	</div>
{{/if}}

<div class="header__actions">
	{{#if actions}}
		{{#if title}}
			<div class="actions__separator"></div>
		{{/if}}
		{{#if show_sort_button}}
			<div class="actions__action sort-button"></div>
		{{/if}}
	{{/if}}
</div>
{{#if searchable}}
	<div class="header__search">
		<i class="search__icon material-icons">search</i>
		<input type="text" name="search" title="Search this list">
		<i class="search__clear material-icons">clear</i>
	</div>
{{/if}}
