import {extend} from 'flarum/extend';
import PermissionGrid from 'flarum/components/PermissionGrid';

export default function () {
    extend(PermissionGrid.prototype, 'viewItems', items => {
        items.add('ithauaz-pages-restricted', {
            icon: 'fas fa-file-alt',
            label: app.translator.trans('ithauaz-pages.admin.permissions.restricted'),
            permission: 'ithauaz-pages.viewRestricted',
        });
    });
}
