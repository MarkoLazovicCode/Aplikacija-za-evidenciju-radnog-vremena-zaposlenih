<?php
return [
    App\Core\Route ::get( '|^$|'                ,'Main'       ,'home'),
    App\Core\Route ::post( '|^$|'               ,'Main'     ,'postRecord'),
    App\Core\Route::get('|^admin/profile/logOut/$|'     ,'Main'     ,'getLogout'),
    App\Core\Route ::get( '|^admin?$|'          ,'Admin'     ,'getlogin'),
    App\Core\Route ::post('|^admin?$|'          ,'Admin'     ,'postLogin'),
    App\Core\Route ::get('|^admin/profile/?$|'  ,'AdminDashboard'     ,'index'),
    App\Core\Route ::POST('|^admin/profile/?$|'  ,'AdminDashboard'     ,'index'),
    App\Core\Route ::get('|^admin/profile/employees/?$|'  ,'AdminDashboard'     ,'getEmployees'),
    App\Core\Route ::get('|^admin/profile/employees/([0-9]+)/?$|'  ,'AdminDashboard'     ,'getEmployee'),

    App\Core\Route ::get('|^admin/profile/employees/add?$|'  ,'AdminDashboard'     ,'getAddEmployee'),
    App\Core\Route ::post('|^admin/profile/employees/add?$|'  ,'AdminDashboard'     ,'postAddEmployee'),

    App\Core\Route ::get('|^admin/profile/employees/edit/([0-9]+)/?$|'  ,'AdminDashboard'     ,'getEditEmployee'),
    App\Core\Route ::post('|^admin/profile/employees/edit/([0-9]+)/?$|'  ,'AdminDashboard'     ,'postEditEmployee'),
    App\Core\Route ::get('|^admin/profile/employees/archive/([0-9]+)/?$|'  ,'AdminDashboard'     ,'getArchiveEmployee'),
    App\Core\Route ::post('|^admin/profile/employees/archive/([0-9]+)/?$|'  ,'AdminDashboard'     ,'postArchiveEmployee'),

    App\Core\Route ::get('|^admin/profile/employees/ArchivedEmployees/?$|'  ,'AdminDashboard'     ,'getArchivedEmployees'),

    App\Core\Route ::get('|^admin/profile/employees/record/([0-9]+)/?$|'  , 'AdminDashboard'     ,'getAllRecords'),

    App\Core\Route ::get('|^admin/profile/employees/record/edit/([0-9]+)/?$|'  , 'AdminDashboard'     ,'getEditRecord'),
    App\Core\Route ::post('|^admin/profile/employees/record/edit/([0-9]+)/?$|'  , 'AdminDashboard'     ,'postEditRecord'),

    # Api rute:
    App\Core\Route ::get( '|api/profile/(([0-9]{4}\-[0-9]{2}\-[0-9]{2})=([0-9]{4}\-[0-9]{2}\-[0-9]{2}))/?$|'                ,'ApiDashboard'       ,'show'),
    App\Core\Route ::get( '|api/employee/(([0-9]+)=([0-9]{4}\-[0-9]{2}\-[0-9]{2})=([0-9]{4}\-[0-9]{2}\-[0-9]{2}))/?$|'                ,'ApiDashboard'       ,'getTotalTimeByDateRange')


];