<?php
defined('BASEPATH') or exit('No direct script access allowed');
/* dashboard */
$route['dashboard'] = 'Dashboard/index';
$route['hotel-dashboard'] = 'Dashboard/hotel_dashboard';
$route['vacant-room'] = 'Dashboard/vacant_room';
/* --end-- */

/* for user mamagement */
$route['profile'] = 'User/profile';
$route['logout'] = 'User/logout';
$route['is_login'] = 'User/is_login';
$route['login'] = 'User/login';

/* Master Routes Start */
$route['settings'] = 'App_menu/settings_template';
$route['stock-management'] = 'Master/stock_management_master';
$route['resturent-recepie-master'] = 'Master/resturent_recepie_master';
$route['view-recepie'] = 'Master/resturent_recepie_list_view';
$route['user-master'] = 'Master/user_master';
$route['user-role-master'] = 'Master/user_role_master';
$route['view-room-service-type'] = 'Master/view_room_service_type';
$route['view-user'] = 'Master/user_list_view';
$route['view-user-role'] = 'Master/user_role_view';
$route['supplier-master'] = 'Master/supplier_master_card';
$route['view-supplier'] = 'Master/supplier_list_view';
$route['item-category-master'] = 'Master/item_category_master_card';
$route['view-category-master'] = 'Master/item_category_master_view';
$route['item-master'] = 'Master/item_master_card';
$route['view-item'] = 'Master/item_master_card_view';
$route['bed-type-master'] = 'Master/bed_type_master';
$route['view-bed-type'] = 'Master/bed_type_master_view';
$route['room-category-master'] = 'Master/room_category_master';
$route['view-room-category'] = 'Master/room_category_master_view';
$route['room-master'] = 'Master/room_master';
$route['view-room'] = 'Master/room_master_view';
$route['block-wise-floor-master'] = 'Master/block_wise_floor_master';
$route['view-block-wise-floor'] = 'Master/block_wise_floor_master_view';
$route['agent-master'] = 'Master/agent_master';
$route['view-agent'] = 'Master/agent_master_view';
$route['customer-master'] = 'Master/customer_master_card';
$route['customer-master/(:any)'] = 'Master/customer_master_card/$1';
$route['customer-master/(:any)/(:any)'] = 'Master/customer_master_card/$1/$1';
$route['restaurant-food-master'] = 'Master/restaurant_menu_master';
$route['view-food-master'] = 'Master/restaurant_menu_master_view';
$route['payment-mode-master'] = 'Master/payment_mode_master';
/* Master Routes End */

/* Booking Routes Start */
$route['hotel-room-booking'] = 'Booking/hotel_room_booking';
$route['room-booking'] = 'Booking/room_booking_customer_search';
$route['payment-info'] = 'Booking/room_booking_payment_info';
$route['payment-info/(:any)'] = 'Booking/room_booking_payment_info';
$route['hotel-room-booking-register'] = 'Booking/room_booking_register';
$route['booking-details-view/(:any)'] = 'Booking/booking_details_view/$1/$1';
/* Booking Routes End */

/* Checkin Routes Start */
$route['room-vacancy-details/(:any)'] = 'Checkin/vacant_room/$1';
$route['planned-check-in/(:any)/(:any)'] = 'Checkin/planned_checkin_checkout/$1/$1';
$route['planned-check-out/(:any)/(:any)'] = 'Checkin/planned_checkin_checkout/$1/$1';
$route['planned-stay-period/(:any)'] = 'Checkin/planned_checkin_checkout/$1';
$route['edit-room-booking'] = 'Checkin/initiate_check_in';
$route['current-guest'] = 'Checkin/current_guest';
/* Checkin Routes End */

/* --- */
$route['default_controller'] = 'User/login';
$route['404_override'] = 'Template/Errors_page/index';
$route['access-denied'] = 'Template/Errors_page/access_denied';
$route['translate_uri_dashes'] = FALSE;
$route['create-user'] = 'User/user_master';
$route['user-list'] = 'User/view_user_master';
$route['create-role'] = 'User/create_role';
$route['role-list-view'] = 'User/view_role';