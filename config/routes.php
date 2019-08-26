<?php
	return [

		/*Root path*/
		'GET /' => 'trainer-dashboard/index',

		/*User page*/
		'GET /registration' => 'registration/register',
		'POST /registration' => 'registration/register-submit',
		'GET /useractivation' => 'registration/user-activation',
		'GET /login' => 'auth/login',
		'GET /logout' => 'auth/logout',
		'GET /reset_password' => 'auth/reset-user-password',
		'POST /reset_password' => 'auth/send-to-user-verification',
		'GET /new_password' => 'auth/new-user-password',

		/*Profile*/
		'GET /profile' => 'user/index',
		'GET /profile/edit' => 'user/edit',
		'POST /profile/edit' => 'user/save',

		/*Users*/
		'GET /clients' => 'users/index',
		'GET /clients/new' => 'users/new',
		'POST /clients/new' => 'users/add-user',
		'GET /clients/send_email' => 'users/send-user-email',
		'POST /clients/send_email' => 'users/submit-user-email',
		'GET /clients/delete-client' => 'users/delete-client',

		/*Trenings*/
		'GET /trainings' => 'trainings/show',
		'GET /trainings/new' => 'trainings/new',
		'POST /trainings/new' => 'trainings/save',
		// 'GET /trainings/edit' => 'trainings/edit',
		'POST /trainings/edit' => 'trainings/update',
		'POST /trainings/delete' => 'trainings/delete',
		'GET /trainings/new_note' => 'trainings/new-note',
		'POST /trainings/new_note' => 'trainings/new-note-save',
		'GET /trainings/tasks' => 'trainings/trainings-calendar',
		'POST /trainings/calendar_record' => 'trainings/get-record-by-id',
		'POST /trainings/get-user-tasks' => 'trainings/get-user-tasks',

		/*User-tasks*/
		'GET /trainings/show-tasks-list' => 'user-tasks/show-tasks-list',

		/*Trainings-Notes*/
		'GET /trainings_notes/show_note' => 'trainings-notes/show',
		'GET /trainings_notes/new' => 'trainings-notes/new',
		'POST /trainings_notes/new' => 'trainings-notes/save',
		'GET /trainings_notes/edit' => 'trainings-notes/edit',
		'POST /trainings_notes/edit' => 'trainings-notes/update',
		'GET /trainings_notes/delete' => 'trainings-notes/delete',

		/*Gallery*/
		'GET /gallery/' => 'users-images/index',
		'GET /gallery/new' => 'users-images/add-files',
		'POST /gallery/new' => 'users-images/save',
		'POST /gallery/delete_images' => 'users-images/delete-images',

		/*Trainer Dashboard*/
		'GET /trainer/dashboard' => 'trainer-dashboard/index',

		// Trainer Colendar
		'GET /trainer/calendar' => 'trainer-calendar/index',
		'POST /trainer-calendar/change-event' => 'trainer-calendar/update-event',
		'POST /trainer-calendar/delete-event' => 'trainer-calendar/delete-event',
		'POST /trainer-calendar/calendar-add-event' => 'trainer-calendar/calendar-add-event',
];
