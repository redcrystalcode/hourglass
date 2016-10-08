import {Collection} from 'backbone';
import {LayoutView, CollectionView, CompositeView, ItemView} from 'backbone.marionette';
import moment from 'moment';
import EmployeeTimesheetReportView from 'views/reports/detail/EmployeeTimesheetReportView';
import template from 'templates/reports/detail/agency/report.tpl';
import employeeSummaryItemTemplate from 'templates/reports/detail/agency/employee-summary-item.tpl';
import employeeSummaryTemplate from 'templates/reports/detail/agency/employee-summary.tpl';

const EmployeeReportsCollectionView = CollectionView.extend({
    childView: EmployeeTimesheetReportView,
    childViewOptions: {
        hideMetaHeader: true,
    },
});

const EmployeeSummaryCollectionView = CompositeView.extend({
    template: employeeSummaryTemplate,
    childView: ItemView.extend({
        tagName: 'tr',
        template: employeeSummaryItemTemplate,
        templateHelpers() {
            let model = this.model;
            return {
                total_time() {
                    let total = model.get('total_time_minutes');
                    let hours = Math.floor(total / 60);
                    let minutes = total % 60;

                    return `${hours}h ${minutes}m`;
                }
            };
        }
    }),
    childViewContainer: 'tbody',
});

const AgencyTimesheetsReportCollectionView = LayoutView.extend({
    template,
    regions: {
        reports: '.js-reports-container',
        summary: '.js-summary-container',
    },
    templateHelpers() {
        return {
            start: moment(this.model.get('start')).format('M/DD/YY'),
            end: moment(this.model.get('end')).format('M/DD/YY'),
            count: this.model.get('employees').length
        };
    },
    initialize: function() {
        this.collection = new Collection(this.model.get('employees'));
    },
    onBeforeShow() {
        this.showChildView('summary', new EmployeeSummaryCollectionView({
            collection: this.collection,
        }));
        if (!this.model.get('summary_only')) {
            this.showChildView('reports', new EmployeeReportsCollectionView({
                collection: this.collection,
            }));
        }
    },
});

export default AgencyTimesheetsReportCollectionView;
