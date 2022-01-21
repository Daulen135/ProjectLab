[![pipeline status](http://192.168.10.22/yii2/projectlab-yii2-1421/badges/master/pipeline.svg)](http://192.168.10.22/yii2/projectlab-yii2-1421/commits/master)

#### About 
This project is ProjectLab

## INSTALLATION

* Go to ***htdocs*** or ***html*** folder.
* Open your terminal by ***ctrl+alt+t*** , navigate to *htdocs* or *html* folder.
* Type ***bash scripts/setup.sh***  in terminal. Wait till installation complete.
* Change you folder permission. Then checkout dev branch by ***git checkout dev***
* Again type ***bash ./scripts/git-sync-all.sh*** 
* 
* If in case database not uploaded completely run this command ***php console.php installer/install database*** . Remember if you run this command, your previuos data will format completely. I recommend you to never run this comman on live server.
* 
* If you face database credentials permission error, then run command ***php console.php installer/install/database -du admin -dp admin@123*** in my case **admin** is my database username and **admin@123** is my databse password.
* 
* Install default data using : ***php console.php clear/default*** 

#### # RUN PROJECT
1. Goto url http://localhost/
1. Create an admin account. I recommend you to use email as **admin@toxsl.in** and password as **admin@123**

### CheckList

> NOTE: Refer the [CheckList](http://192.168.10.22/yii2/projectlab-yii2-1421/blob/master/docs/checklist.md) for details on all the security concerns and other important parameters of the project before its actual releasing.

### Coding Guidelines

> NOTE: Refer the [Coding Guidelines](http://192.168.10.22/yii2/projectlab-yii2-1421/blob/master/docs/coding-guidelines.md) for details on all the security concerns and other important parameters of the project before its actual releasing.

### To Run TestCase

> 1st - copy .gitlab-ci.yml and paste in root

> 2nd - upadte composer.json with

> 3rd - Run this command     ./vendor/bin/codecept run -g guest -v
