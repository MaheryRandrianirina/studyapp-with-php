<?php
require dirname(__DIR__) . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";
use App\Router;

$router = new Router();
$router->get("/", "home", "App\\Controllers\\HomeController@index", "homepage")
       ->get("/revisionContent", "revision", "App\\Controllers\\HomeController@revision", "revisionContent")
       ->get("/calendarContent", "calendar", "App\\Controllers\\HomeController@calendar", "calendarContent")
       ->get("/tasksContent", "tasks", "App\\Controllers\\HomeController@tasks", "tasksContent")
       ->get("/helpContent", "help", "App\\Controllers\\HomeController@help", "helpContent")
       ->get("/login", "loginPage", "App\\Controllers\\LoginController@loginPage", "loginpage")
       ->get("/register", "registerPage", "App\\Controllers\\RegisterController@registerPage", "registerpage")
       ->get("/logout", "logout", "App\\Controllers\\LogoutController@logout", "logout")
       ->get("/array-calendar-content", "array-content", "App\\Controllers\\HomeController@ArrayCalendarContent", "array.calendar.content")
       ->get("/editProfilePhoto", "profile-photo", "App\\Controllers\\HomeController@EditProfilePhoto", "profile.photo.edit")
       ->get("/drop-calendar", "drop-calendar", "App\\Controllers\\CalendarController@dropCalendar", "calendar.drop")
       ->post("/registerAction", "registerAction", "App\\Controllers\\RegisterController@register", "postRegisterAction")
       ->post("/profilePhotoAction", "profilePhoto", "App\\Controllers\\ProfilePhotoController@action", "profilePhotoAction")
       ->post("/loginAction", "loginAction", "App\\Controllers\\LoginController@loginAction", "postLoginAction")
       ->post("/create-calendar", "createCalendar", "App\\Controllers\\UserController@calendar", "postCalendarAction")
       ->post("/stop-revision", "stopRevision", "App\\Controllers\\HomeController@stopRevision", "revision.stop")
       ->post("/save-revision-for-another-time", "saveRevision", "App\\Controllers\\HomeController@saveRevisionForAnotherTime", "revision.save")
       ->run();
       