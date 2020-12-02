# Magento 2 healthcheck

 This module reads folder var/report, builds groups of similar reports and counts how often they occur.
 
## Installation

*composer require khomenko/healthcheck*

After installation run command

*php bin/magento healthcheck:initreports*

It will collect statistic for latest 10 days


## Usage

To see report groups and statistic fo to System->Tools->View Reports
