com.aghstrategies.publicmailings
================================
This extension creates archive list of public mailings in CiviCRM. You will need to enable the "CiviMail: view public CiviMail content" permission. This only pulls completed mailings that have the "Public Pages" set for the visibility.

### Modifiers

You can pass modifiers through the url to filter the list of mailings. These can also be used in combination with one another.

##### Template Id
If you want only public mailings that use a specific mailing template: "civicrm/public_mailings_list?reset=1&tid=22"

##### Dates
Dates are based upon the scheduled date of the mailing.

--Year--   
If you want to display all the public mailings within a specific year: "civicrm/public_mailings_list?reset=1&year=2013"

--Month--  
If you want to display all the public mailings within a specific month, Note: If a month is provided but a year is not provided then the current year will be used. A month and year should be used together. Month should be in number format with no leading zero. "civicrm/public_mailings_list?reset=1&month=4&year=2013"

---Custom Date Range---  
If you have a custom range you want to use, then you use date1 and date2. The format should be YYYY-M-D. date1 is the start date. date2 is in the end date. If you only include date1 then you would have all mailings after date1 and if you only did date2 you would have all mailings before date2. "civicrm/public_mailings_list?reset=1&date1=2013-5-3&date2=2013-6-16"
