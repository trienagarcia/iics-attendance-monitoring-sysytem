<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'homeController';
$route['room-schedule'] = 'homeController/roomSchedule';
$route['edit_report'] = 'homeController/editReport';
$route['submitted-requests'] = 'homeController/submittedRequests';
$route['home'] = 'homeController/home';
$route['login'] = 'homeController/login';
$route['change-password'] = 'homeController/changepassword';
$route['time-logs'] = 'homeController/timelogs';
$route['time-logs-user'] = 'homeController/timelogsuser';
$route['compiled-reports'] = 'homeController/compiledreports';
$route['report/(:any)'] = 'homeController/getspecificreport/$1';
$route['add-request'] = 'homeController/addRequests';

$route['account-management'] = 'homeController/accountmanagement';
$route['insert'] = 'homeController/insert';
$route['reject-reason'] = 'homeController/rejectreason';

// Third party controller
$route['thirdpartycontroller'] = 'thirdPartyController';
$route['individualreportcontroller'] = 'individualreportcontroller';
$route['export'] = 'thirdpartycontroller/report';
$route['individual-export'] = 'individualreportcontroller/index';

$route['compiled-reports/export/(:any)/(:any)'] = 'thirdPartyController/index/$1';
$route['report/export/(:any)'] = 'individualReportController/index/$1';

// Create Announcements
$route['announcement/(:any)'] = 'homeController/createannouncement/$1';
$route['ajax/get-announcement'] = 'customController/getannouncement';
$route['ajax/get-specific-announcement'] = 'customController/getspecificannouncement';
$route['ajax/update-announcement'] = 'customController/updateannouncement';
$route['ajax/delete-announcement'] = 'customController/deleteannouncement';

// Ajax

$route['ajax/get-all-users'] = 'customController/getallaccounts';
$route['ajax/get-new-password'] = 'customController/getnewpassword';
$route['ajax/add-new-account'] = 'customController/addAccount';
$route['ajax/delete-account'] = 'customController/deleteAccount';
$route['ajax/add-new-announcement'] = 'customController/addAnnouncement';
$route['ajax/get-time-logs'] = 'customController/gettimelogs';
$route['ajax/get-user-time-logs'] = 'customController/getusertimelogs';
$route['ajax/get-user-compiled-reports'] = 'customController/getusercompiledreports';
$route['ajax/get-user-submitted-requests'] = 'customController/getusersubmittedrequests';
$route['ajax/get-schedules/(:any)'] = 'customController/getOpenSchedules/$1';

$route['ajax/login'] = 'globalController/validatelogin';
$route['ajax/update-password'] = 'customController/updatepassword';
$route['ajax/update-report-status'] = 'customController/updatereportstatus';
$route['ajax/fetch-report-records'] = 'customController/getreportrecords';
$route['ajax/check-incoming-rfid'] = 'customController/checkincomingrfid';
$route['ajax/get-courses'] = 'customController/getcourses';
$route['ajax/get-sections'] = 'customController/getsections';
$route['ajax/get-rooms'] = 'customController/getrooms';
$route['ajax/get-rfid'] = 'customController/getrfid';
$route['ajax/get-all-archive-reports'] = 'customController/getallarchivereports';
$route['ajax/add-new-request'] = 'customController/addnewrequest';
$route['logout'] = 'homeController/logout';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['category/(:any)'] = 'homeController/homecategories/$1';
$route['ajax/get-filter-time-logs'] = 'customController/getFilteredTimeLogs';
// $route['custom/(:any)'] = 'customController/$1';
// $route['accounts/(:any)'] = 'accountscontroller/$1';

