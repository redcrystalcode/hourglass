<p>
	Fill out the fields below to create a new job.
</p>
<form>
	<div class="mdl-textfield mdl-textfield--floating-label mdl-textfield--full-width mdl-js-textfield">
		<input class="mdl-textfield__input" type="text" id="name" name="name" value="{{name}}" tabindex="10">
		<label class="mdl-textfield__label" for="name">Job Name</label>
	</div>
	<div class="mdl-textfield mdl-textfield--floating-label mdl-textfield--full-width mdl-js-textfield">
		<input class="mdl-textfield__input" type="text" id="number" name="number" value="{{number}}" tabindex="11">
		<label class="mdl-textfield__label" for="number">Job Number</label>
	</div>
	<div class="mdl-textfield mdl-textfield--floating-label mdl-textfield--full-width mdl-js-textfield">
		<input class="mdl-textfield__input" type="text" id="customer" name="customer" value="{{customer}}" tabindex="12">
		<label class="mdl-textfield__label" for="customer">Customer</label>
	</div>
	<div class="mdl-textfield mdl-textfield--floating-label mdl-textfield--full-width mdl-js-textfield">
		<textarea class="mdl-textfield__input" type="text" rows="3" id="description" name="description" tabindex="13">{{description}}</textarea>
		<label class="mdl-textfield__label" for="description">Description</label>
	</div>
	<h4 class="action-sheet__form-header">Location</h4>
	<div class="form-validation-error" data-validation-error-for="location_id"></div>
	<p>Choose the location this job will primarily be worked in.</p>
	<div class="location-chooser-region">

	</div>
	<h4 class="action-sheet__form-header">Productivity</h4>
	<div class="form-validation-error" data-validation-error-for="productivity.type"></div>
	<p>Choose how productivity for this job is calculated.</p>
	<div class="mdl-radio-group">
		<div class="mdl-radio-group__options">
			<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="productivity-type-quantity">
				<input checked class="mdl-radio__button" id="productivity-type-quantity" name="productivity.type" type="radio" value="quantity">
				<span class="mdl-radio__label">Quantity Per Man-Hour</span>
			</label>
			<!--<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="productivity-none">
				<input class="mdl-radio__button" id="productivity-none" name="productivity.type" type="radio" value="none">
				<span class="mdl-radio__label">None</span>
			</label>-->
		</div>
	</div>
	<div class="mdl-textfield mdl-textfield--floating-label mdl-textfield--full-width mdl-js-textfield">
		<input class="mdl-textfield__input" type="text" id="productivity.quantity" name="productivity.quantity" value="{{productivity.quantity}}" tabindex="21">
		<label class="mdl-textfield__label" for="productivity.quantity">Projected Quantity Per Hour</label>
	</div>
	<div class="mdl-textfield mdl-textfield--floating-label mdl-textfield--full-width mdl-js-textfield">
		<input class="mdl-textfield__input" type="text" id="productivity.employees" name="productivity.employees" value="{{productivity.employees}}" tabindex="22">
		<label class="mdl-textfield__label" for="productivity.employees">Number of Employees Required</label>
	</div>
</form>
