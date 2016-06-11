<div class="shift-item {{#if paused}}shift-item--paused{{/if}}">
	<div class="shift-item__icon"><i class="material-icons">
		{{#if paused}}
			assignment_late
		{{else}}
			assignment
		{{/if}}
	</i></div>
	<div class="shift-item__content">
		<span class="shift-item__content-line-one">#{{job.number}}</span>
		<span class="shift-item__content-line-two">{{job.name}}</span>
		<span class="shift-item__content-line-three">Started {{start_date}}</span>
	</div>
	<div class="shift-item__actions">
		{{#if paused}}
			<button class="js-resume-shift mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--accent">
				Resume
			</button>
		{{else}}
			<button class="js-pause-shift mdl-button mdl-js-button mdl-js-ripple-effect">
				Pause
			</button>
			<button class="js-end-shift mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--accent">
				End
			</button>
		{{/if}}
	</div>
</div>
