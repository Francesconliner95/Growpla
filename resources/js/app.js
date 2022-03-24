require('./bootstrap');

///////GUEST//////
//ACCOUNT
if (document.getElementById('guest-home')) {
    require('./guest/home.js');
}

if (document.getElementById('guest-prehome')) {
    require('./guest/prehome.js');
}

if (document.getElementById('cookie-policy')) {
    require('./guest/cookiePolicy.js');
}

if (document.getElementById('register')) {
    require('./guest/register.js');
}

///////SEARCH///////

if (document.getElementById('search')) {
    require('./admin/search.js');
}

if (document.getElementById('found')) {
    require('./admin/found.js');
}


//USERS
if (document.getElementById('user-create')) {
    require('./admin/users/create.js');
}

if (document.getElementById('user-edit')) {
    require('./admin/users/edit.js');
}

if (document.getElementById('user-show')) {
    require('./admin/users/show.js');
}

if (document.getElementById('edit-user-image')) {
    require('./admin/users/edit-image.js');
}

if (document.getElementById('user-sectors')) {
    require('./admin/users/sectors.js');
}

//PAGES
if (document.getElementById('page-edit')) {
    require('./admin/pages/edit.js');
}

if (document.getElementById('page-show')) {
    require('./admin/pages/show.js');
}

if (document.getElementById('edit-page-image')) {
    require('./admin/pages/edit-image.js');
}

if (document.getElementById('page-settings')) {
    require('./admin/pages/settings.js');
}

if (document.getElementById('page-sectors')) {
    require('./admin/pages/sectors.js');
}

//ACCOUNT
if (document.getElementById('nav-bar')) {
    require('./admin/nav-bar.js');
}

//ACCOUNT
if (document.getElementById('account-index')) {
    require('./admin/accounts/index.js');
}

if (document.getElementById('account-show')) {
    require('./admin/accounts/show.js');
}

if (document.getElementById('account-edit')) {
    require('./admin/accounts/edit.js');
}

if (document.getElementById('image-editor')) {
    require('./admin/accounts/image-editor.js');
}

if (document.getElementById('cover-image-editor')) {
    require('./admin/accounts/cover-image-editor.js');
}

//TEAM
if (document.getElementById('team-create')) {
    require('./admin/teams/create.js');
}

if (document.getElementById('team-edit')) {
    require('./admin/teams/edit.js');
}

//COMPANY
if (document.getElementById('company-create')) {
    require('./admin/companies/create.js');
}

if (document.getElementById('company-edit')) {
    require('./admin/companies/edit.js');
}

//COLLABORATION
if (document.getElementById('collaboration-create')) {
    require('./admin/collaborations/create.js');
}

//SKILL
if (document.getElementById('skill-edit')) {
    require('./admin/skills/edit.js');
}

//SERVICE
if (document.getElementById('service-edit')) {
    require('./admin/services/edit.js');
}

//OTHER
if (document.getElementById('other-create')) {
    require('./admin/others/create.js');
}

if (document.getElementById('other-edit')) {
    require('./admin/others/edit.js');
}

//LIFECYCLE
if (document.getElementById('lifecycle-edit')) {
    require('./admin/lifecycles/edit.js');
}

//PAGE-USERTYPE
if (document.getElementById('page-usertypes-edit')) {
    require('./admin/have-page-usertypes/edit.js');
}

//CHAT
if (document.getElementById('chat-index')) {
    require('./admin/chats/index.js');
}

if (document.getElementById('chat-show')) {
    require('./admin/chats/show.js');
}

//FOLLOW
if (document.getElementById('follows-index')) {
    require('./admin/follows/index.js');
}

//NOTIFICATIONS
if (document.getElementById('notification-index')) {
    require('./admin/notifications/index.js');
}

//NOTIFICATIONS
if (document.getElementById('nomination-startup')) {
    require('./admin/nominations/startup.js');
}

//SETTINGS
if (document.getElementById('settings-index')) {
    require('./admin/settings/index.js');
}

//SUPPORTS
if (document.getElementById('support-create')) {
    require('./admin/supports/create.js');
}
if (document.getElementById('support-index')) {
    require('./admin/supports/index.js');
}
if (document.getElementById('support-show')) {
    require('./admin/supports/show.js');
}
