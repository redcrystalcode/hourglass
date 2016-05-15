<div class="mdl-grid">
    <div class="mdl-cell mdl-cell--4-col mdl-cell--middle mdl-cell--1-col-tablet">
	    {{#logged_in}}
		    <div class="navbar__selector {{#if selected.subpath}}navbar__selector--with-back{{/if}}">
	            <div class="selector__selected">
		            {{#if selected.subpath}}
			            <span class="selector__back"><i class="material-icons">arrow_back</i></span>
		            {{/if}}
		            <i class="selected__icon material-icons">{{selected.icon}}</i> <span class="selected__item">{{selected.name}}</span>
	            </div>
		        <div class="selector__carat"><i class="material-icons">arrow_drop_down</i></div>
	            <div class="selector__options">
		            {{#primary_links}}
		                <div class="selector__option {{#active}}selector__option--selected{{/active}}">
				            <a href="/app/{{path}}" data-internal>
					            <i class="option__icon material-icons">{{icon}}</i>
					            <span class="option__label">{{name}}</span>
				            </a>
			            </div>
		            {{/primary_links}}
	                <div class="selector__footer">
	                    <a href="#" class="selector__footer-link">Help</a>
	                </div>
	            </div>
	        </div>
	    {{/logged_in}}
    </div>
    <div class="mdl-cell mdl-cell--4-col mdl-cell--middle mdl-cell--6-col-tablet">
        <div class="navbar__logo">
            <span class="hidden">Hourglass</span>
        </div>
    </div>
    <div class="mdl-cell mdl-cell--4-col mdl-cell--middle mdl-cell--1-col-tablet text-right">
	    {{#if logged_in}}
	        <div class="navbar__selector navbar__selector--dark navbar__selector--right user-selector">
			    <div class="selector__selected">
				    <i class="selected__icon material-icons">person</i> <span class="selected__item">{{user.name}}</span>
			    </div>
			    <div class="selector__carat"><i class="material-icons">arrow_drop_down</i></div>
			    <div class="selector__options">
				    <div class="selector__option selector__option--selected user-selector__profile">
					    <div class="profile__icon"></div>
					    <div class="profile__info">
						    <div class="profile__name">{{user.name}}</div>
						    <div class="profile__email">{{user.email}}</div>
					    </div>
				    </div>
				    <div class="selector__option">
					    <a href="#">
						    <i class="option__icon material-icons">person</i>
						    <span class="option__label">Profile</span>
					    </a>
				    </div>
				    <div class="selector__option">
					    <a href="/logout">
						    <i class="option__icon material-icons">lock</i>
						    <span class="option__label">Log Out</span>
					    </a>
				    </div>
			    </div>
		    </div>
	    {{else}}
		    <ul class="navbar__nav">
			    {{#unauthenticated_links}}
				    <li class="nav__item nav__item--pill">
					    <a href="/app/{{this.path}}" data-internal>{{this.name}}</a>
				    </li>
			    {{/unauthenticated_links}}
		    </ul>
	    {{/if}}
    </div>
</div>
