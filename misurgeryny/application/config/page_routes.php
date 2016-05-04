<?php
// Test Page
$route["patient-support/testpage"] = "default/page/view";
 
// Online Seminar
$route["getting-started/online-seminar"] = "default/online_seminars";

// Search
$route["search"] = "default/search";
 $route["search/result"] = "default/search/result";
 $route["search/construct"] = "default/search/construct";
 $route["search/construct/(:any)"] = "default/search/construct/$1";
 $route["search/result/index/([a-z0-9]+)"] = "default/search/result/$1";
 $route["search/result/index/([a-z0-9]+)/([0-9]+)"] = "default/search/result/$1/$2";
 $route["search/index"] = "default/search/index/";
 $route["search/index/(:any)"] = "default/search/index/$1";
 $route["search/index/(:any)/([0-9]+)"] = "default/search/index/$1/$2";
 
// Test
$route["test"] = "default/page/view";
 
// Privacy
$route["privacy"] = "default/page/view";
 
// Weight Loss Procedures
$route["weight-loss-procedures"] = "default/page/view";
 
// HIPAA
$route["hipaa"] = "default/page/view";
 
// Terms and Conditions
$route["terms-and-conditions"] = "default/page/view";
 
// Maps and Directions
$route["contact-us/maps-and-directions"] = "default/page/view";
 
// Forms
$route["patient-resources/forms"] = "default/page/view";
 
// Helpful Links
$route["patient-resources/helpful-links"] = "default/page/view";
 
// Frequently Asked Questions
$route["patient-resources/faq"] = "default/faq";
$route["patient-resources/faq/category/([0-9]+)"] = "default/faq/category/$1";

// Insurance & Financial Options
$route["patient-resources/insurance-financial-options"] = "default/affordability_calc";
$route["patient-resources/insurance-financial-options/compute"] = "default/affordability_calc/compute";

// News & Events
$route["news-and-events"] = "default/news";
$route["news-and-events/view/(:any)"] = "default/news/view/$1";
$route["news-and-events/([a-z0-9]+)"] = "default/news/$1";
$route["news-and-events/([a-z0-9]+)/(:num)"] = "default/news/$1/$2";
 
// Am I a Candidate?
$route["getting-started/am-i-a-candidate"] = "default/bmi_calc";
$route["getting-started/am-i-a-candidate/compute"] = "default/bmi_calc/compute";

// About Obesity
$route["getting-started/about-obesity"] = "default/page/view";
 
// SILS
$route["bariatric-surgery/sils"] = "default/page/view";
 
// Revisions
$route["bariatric-surgery/revisions"] = "default/page/view";
 
// Duodenal Switch
$route["bariatric-surgery/duodenal-switch"] = "default/page/view";
 
// Biliopancreatic Diversion
$route["bariatric-surgery/biliopancreatic-diversion"] = "default/page/view";
 
// Gastric Sleeve
$route["bariatric-surgery/gastric-sleeve"] = "default/page/view";
 
// Gastric Bypass
$route["bariatric-surgery/gastric-bypass"] = "default/page/view";
 
// LAP-BAND<sup>&reg;</sup>
$route["bariatric-surgery/lap-band"] = "default/page/view";
 
// Hernia
$route["general-surgery/hernia"] = "default/page/view";
 
// Heartburn
$route["general-surgery/heartburn"] = "default/page/view";
 
// Patient Support
$route["patient-support"] = "default/calendar";
$route["patient-support/(:num)"] = "default/calendar/dayevents/$1";
$route["patient-support/([a-z0-9]+)"] = "default/calendar/$1";
$route["patient-support/([a-z0-9]+)/(:num)"] = "default/calendar/$1/$2";
$route["patient-support/([a-z0-9]+)/(:any)"] = "default/calendar/$1/$2";

// Patient Resources
$route["patient-resources"] = "default/page/view";
 
// Getting Started
$route["getting-started"] = "default/page/view";
 
// Diabetes Surgery
$route["diabetes-surgery"] = "default/page/view";
 
// Bariatric Surgery
$route["bariatric-surgery"] = "default/page/view";
 
// General Surgery
$route["general-surgery"] = "default/page/view";
 
// Meet Dr. Teixeira
$route["meet-dr-teixeira"] = "default/page/view";
 
// Welcome to Our Website
$route["home"] = "default/page";
 
// Download Files
$route["download-page"] = "default/page/view";
 
// Newsletter
$route["newsletter"] = "default/newsletter";
 $route["newsletter/subscribe"] = "default/newsletter/subscribe";
 $route["newsletter/subscribe/([a-z0-9]+)"] = "default/newsletter/subscribe/$1";
 $route["newsletter/unsubscribe"] = "default/newsletter/unsubscribe";
 $route["newsletter/unsubscribe-form"] = "default/newsletter/unsubscribe_form";
 $route["newsletter/unsubscribe/([a-z0-9]+)"] = "default/newsletter/unsubscribe/$1";
 $route["newsletter/view/([a-z0-9]+)"] = "default/newsletter/view/$1";
 $route["newsletter/success"] = "default/newsletter/success";
 $route["newsletter/subscriber_exists"] = "default/newsletter/subscriber_exists";
 
// Ooops! We couldn't find the page you were looking for...
$route["404"] = "default/page/view";
 
// Contact Us
$route["contact-us"] = "default/contact_us";
 $route["contact-us/send"] = "default/contact_us/send";

// About Our Practice
$route["about-our-practice"] = "default/page/view";
 
