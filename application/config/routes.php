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
$route['substitute'] = 'homeController/substituteProfessor';

// 03-20-2020 - S
$route['submit-request'] = 'homeController/submitRequest';
// 03-20-2020 - E

$route['account-management'] = 'homeController/accountmanagement';
$route['view-request'] = 'homeController/viewRequest'; //annthonite

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
$route['ajax/login'] = 'globalController/validatelogin';
$route['ajax/update-password'] = 'customController/updatepassword';
$route['ajax/update-report-status'] = 'customController/updatereportstatus';
$route['ajax/fetch-report-records'] = 'customController/getreportrecords';
$route['ajax/check-incoming-rfid'] = 'customController/checkincomingrfid';
$route['ajax/get-courses'] = 'customController/getCourses';
$route['ajax/get-sections'] = 'customController/getSections';
$route['ajax/get-rooms'] = 'customController/getrooms';
$route['ajax/get-rfid'] = 'customController/getrfid';
$route['ajax/get-all-archive-reports'] = 'customController/getallarchivereports';
$route['ajax/add-new-request'] = 'customController/addnewrequest';
$route['logout'] = 'homeController/logout';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['category/(:any)'] = 'homeController/homecategories/$1';
$route['ajax/get-filter-time-logs'] = 'customController/getFilteredTimeLogs'; //annthonite
$route['ajax/update-logs'] = 'customController/updateLogs'; //annthonite
$route['ajax/update-logs-remarks'] = 'customController/updateLogsRemarks'; //annthonite
$route['ajax/get-schedules'] = 'customController/getOpenSchedules';
$route['ajax/get-requests'] = 'customController/getRequests'; //annthonite
$route['ajax/update-request-status'] = 'customController/updateRequestStatus'; //annthonite

$route['ajax/get-all-approved-schedules'] = 'customController/getAllApprovedSchedules';

$route['ajax/delete-requests'] = 'customController/deleteRequests'; //annthonite
$route['ajax/get-all-approved-schedules'] = 'customController/getAllApprovedSchedules';
$route['ajax/update-schedule-substitute'] = 'customController/updateScheduleSubstitute'; //annthonite

// test rfid from processing
$route['rfid_http_test'] = 'customController/getRfidFromHttpPost';
$route['ajax/compare-rfid-counter'] = 'customController/checkRFIDTableDifference';
$route['ajax/check-request-date'] = 'customController/checkRequestDate';
$route['ajax/check-grace-period'] = 'customController/checkGracePeriod';

$route['ajax/get-all-schedule'] = 'customController/getAllSchedule';