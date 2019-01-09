# TASKS

## New Features
Admin user
Only give “Delete” and “Deliver” button actions
Add “Archive order” button
Add table to store “Archived”(Delivered) orders
Non-Admin user
Add inventory for non-admin users
Inventory functions: Eat/Chuck/sell for half price?
Add cancel button function
Hide “Update order”/all button when an order is canceled
Disable and grey-out all buttons
Add “Collect” button to collect order and add items to inventory
Add money for user to be able to order products
	


## Front-End Tweaking
Table columns spacing
Table custom width
Horizontally align multiple buttons in cell
Keep position of current datatable page when refreshing table
Add mouse-over popup on order_num to view products in order



## Bugs
Datatable’s second page’s buttons not disabling when an order’s status is “Canceled”
https://www.gyrocode.com/articles/jquery-datatables-custom-control-does-not-work-on-second-page/
Resolution
on table refresh, set button html markup to empty string if status is canceled.
