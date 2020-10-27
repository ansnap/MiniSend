## MiniSend - Laravel + Vue.js app

The application allows sending emails via Vue.js frontend. It also allows to view the list of sent emails and to filter them by sender, recipient and subject.

The backend of this app is Laravel API which accepts Vue.js requests, handles the data and sends emails.

##### Installation comments

The app installs as a usual Laravel application. For attachments to work please run the command:

php artisan storage:link
