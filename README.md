MOBILE APPLICATION SUBSCRIPTION MANAGEMENT API / CALLBACK / WORKER

GitHub Repository : https://github.com/bilalaliofficial/mobilesubscription.git

First you need to Login from their Google or IOS account. For now I have done it by following way:

http://localhost/mobile-apis/api/login

Parameters

API [MEDIUM]

1- ) Register

http://localhost/mobile-apis/api/register
 
Headers Bearer token will be passed which received from Login.

2- ) Purchase

http://localhost/mobile-apis/api/purchase

If the last character of the receipt string value is an odd number it must return true otherwise false. 

If verification success.
 

3-) Check Subscription

http://localhost/mobile-apis/api/check_subscription

Header is same as above register API


WORKER [MEDIUM]

Command for cron job which checks id if any subscription expired but not canceled so changing its status to canceled.

	 php artisan subscription:expired
Or
	 php artisan schedule:run

TECHNICAL REQUIREMENTS

•	It must support PHP 7.3 or higher.
