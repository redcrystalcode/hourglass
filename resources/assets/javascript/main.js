import 'plugins';
import Backbone from 'backbone';
import Radio from 'backbone.radio';
import $ from 'jquery';

import Application from 'core/Application';
import ApplicationView from 'views/ApplicationView';
import api from 'core/Api';

import DefaultRouter from 'routing/DefaultRouter';
import AccountRouter from 'routing/AccountRouter';
import ReportsRouter from 'routing/ReportsRouter';
import TerminalRouter from 'routing/TerminalRouter';
import EmployeesRouter from 'routing/EmployeesRouter';
import SettingsRouter from 'routing/SettingsRouter';
import JobsRouter from 'routing/JobsRouter';

import HeaderService from 'services/HeaderService';
import ApplicationService from 'services/ApplicationService';
import LoadingService from 'services/LoadingService';
import TerminalService from 'services/TerminalService';

import UserManager from 'managers/UserManager';

import UserModel from 'models/UserModel';

const config = window.bootstrap();
const app = new Application();

// TODO - remove this when production-ready
window.app = app;

app.user = new UserModel(config.user);

app.on('start', () => {
    app.layout = new ApplicationView();
    app.layout.render();

    HeaderService.setup({
        container: app.layout.header,
        user: app.user,
    });

    ApplicationService.setup({
        app: app,
    });

    LoadingService.setup({
        container: app.layout.content,
    });

    TerminalService.setup({
        container: app.layout.content,
    });

    UserManager.setUser(app.user);

    app.api = api;
    app.routers = {
        main: new DefaultRouter(),
        terminal: new TerminalRouter({
            container: app.layout.content
        }),
        jobs: new JobsRouter({
            container: app.layout.content
        }),
        employees: new EmployeesRouter({
            container: app.layout.content
        }),
        reports: new ReportsRouter({
            container: app.layout.content
        }),
        account: new AccountRouter({
            container: app.layout.content
        }),
        // settings: new SettingsRouter({
        //     container: app.layout.content
        // }),
    };
    app.router = app.routers.main;

    Radio.channel('auth').on('login', (user) => {
        app.user.clear({silent: true}).set(user);
    });
    Radio.channel('auth').on('logout', () => {
        app.user.clear();
        app.router.go('login');
    });

    // debugger;
    Backbone.history.start({
        pushState: true,
        root: '/app/'
    });
});

// Get the user, then start the app.
app.start();

// Route all anchor tags with [data-internal] attribute.
$(document).on('click', 'a', function(e) {
    let href = $(this).attr('href');
    if (href.substring(0, 4) === '/app') {
        e.preventDefault();
        Backbone.history.navigate(href.substring(4), true);
    }
});
