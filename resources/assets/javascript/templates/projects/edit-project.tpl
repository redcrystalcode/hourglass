{{#if is_new}}
	<p>Fill out the details below to create a edit this project.</p>
{{/if}}
<form>
	<div class="mdl-textfield mdl-textfield--floating-label mdl-textfield--full-width mdl-js-textfield">
		<input class="mdl-textfield__input" type="text" id="name" name="name" value="{{name}}" tabindex="1">
		<label class="mdl-textfield__label" for="name">Project Name</label>
	</div>
	<div class="mdl-textfield mdl-textfield--floating-label mdl-textfield--full-width mdl-textfield--no-resize mdl-js-textfield">
		<textarea class="mdl-textfield__input" type="text" rows= "4" id="note" name="note" tabindex="2">{{note}}</textarea>
		<label class="mdl-textfield__label" for="note">Note</label>
	</div>
</form>
