<p>
	To invite a new member to your account, enter their details below. The member will receive an email with a link to
	sign up for Furnish Cloud. This member will automatically be associated with your account on sign up.
</p>
<form>
	<div class="mdl-textfield mdl-textfield--floating-label mdl-textfield--full-width mdl-js-textfield">
		<input class="mdl-textfield__input" type="text" id="name" name="name" tabindex="1">
		<label class="mdl-textfield__label" for="name">Name</label>
	</div>
	<div class="mdl-textfield mdl-textfield--floating-label mdl-textfield--full-width mdl-js-textfield">
		<input class="mdl-textfield__input" type="email" id="email" name="email" tabindex="2">
		<label class="mdl-textfield__label" for="email">Email</label>
	</div>
	<div class="mdl-radio-group">
		<span class="mdl-radio-group__label">Role</span>
		<div class="mdl-radio-group__options">
			<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="role-admin">
				<input checked class="mdl-radio__button" id="role-admin" name="role" type="radio" value="admin">
				<span class="mdl-radio__label">
					Admin
					<i class="material-icons" id="role-admin-tt">info_outline</i>
				</span>
				<span class="mdl-tooltip mdl-tooltip--large" for="role-admin-tt">
					An <strong>Admin</strong> has full access to everything you do.
					They can create, edit, delete anything you can, and can even add or remove members.
				</span>
			</label>
			<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="role-editor">
				<input class="mdl-radio__button" id="role-editor" name="role" type="radio" value="editor">
				<span class="mdl-radio__label">
					Editor
					<i class="material-icons" id="role-editor-tt">info_outline</i>
				</span>
				<span class="mdl-tooltip mdl-tooltip--large" for="role-editor-tt">
					An <strong>Editor</strong> can view, create, edit, and delete anything in the account. They
					can't change any of your account settings, though.
				</span>
			</label>
			<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="Viewer">
				<input class="mdl-radio__button" id="Viewer" name="role" type="radio" value="viewer">
				<span class="mdl-radio__label">
					Viewer
					<i class="material-icons" id="role-viewer-tt">info_outline</i>
				</span>
				<span class="mdl-tooltip mdl-tooltip--large" for="role-viewer-tt">
					A <strong>Viewer</strong> can only view projects and project data.
				</span>
			</label>
		</div>
	</div>
</form>
