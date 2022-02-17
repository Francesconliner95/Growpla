require('./bootstrap');

///////GUEST//////
//ACCOUNT
if (document.getElementById('guest-home')) {
    require('./guest/home.js');
}

if (document.getElementById('cookie-policy')) {
    require('./guest/cookiePolicy.js');
}

if (document.getElementById('register')) {
    require('./guest/register.js');
}

///////ADMIN///////
//ACCOUNT
if (document.getElementById('nav-bar')) {
    require('./admin/nav-bar.js');
}

//ACCOUNT
if (document.getElementById('account-index')) {
    require('./admin/accounts/index.js');
}

if (document.getElementById('account-create')) {
    require('./admin/accounts/create.js');
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

//OTHER
if (document.getElementById('other-create')) {
    require('./admin/others/create.js');
}

if (document.getElementById('other-edit')) {
    require('./admin/others/edit.js');
}

//NEED
if (document.getElementById('need-edit')) {
    require('./admin/needs/edit.js');
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
