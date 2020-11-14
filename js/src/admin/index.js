import Page from '../common/models/Page';
import addPagesPane from './addPagesPane';
import addPageHomePageOption from './addPageHomePageOption';
import addPermissions from './addPermissions';

app.initializers.add('ithauaz-pages', app => {
    app.store.models.pages = Page;

    addPagesPane();
    addPageHomePageOption();
    addPermissions();
});
