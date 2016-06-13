# BTHSdb :: ver. 1.0.0

**IMPORTANT**: 

Branches:

*legacy* is for the previous attempts at the database, and has little use except for documentation.

*master* is for complete --SAFE-- builds that the webhost will use.

*develop* is for... development builds, and has **DEBUG = True** and 
**ALLOWED_HOSTS is empty** for local use. **This is the branch you should be working on, not the master branch.** 
Once you feel like you can ship a new version, go to settings.py and set the above DEBUG = False and fill ALLOWED_HOSTS with whatever webhost name you decide on. Then **merge with the master branch.**


**RUNNING LOCALLY**:

Setup:

1. Make sure python3 and pip are installed.
2. In the command prompt (on Windows) run: 

        pip install Django

Running Server:

1. Open the command prompt in BTHSdb/bthsdb and run:

        python manage.py runserver
  
  This assumes python is a global command.
  
  Django automatically detects changes to files so there's no need to ctrl+s every time you make a change in a local file.

  Go to /admin for the admin control panel.
  
  Go to /database for the database (user login required.)

**DOCUMENTATION**:

* [Django tutorial](https://docs.djangoproject.com/en/1.9/intro/tutorial01/)
* [Django API](https://docs.djangoproject.com/en/1.9/)
* BTHSDB API coming soon...


Current Features:
-----------------
* Users
  - Log in menu
* Equipment database
  - Subjects
  - Rooms
  - Shelves
  - Nullable: 
    - Take out time
    - Take out user


Todo:
-----------------
* Change admin password(!) 
* Make table columns sortable
* Better equipment details 
* Better admin control panel
* User sign up system
* Redirect to /database/
* Upload to webhost (free hosting at heroku [https://bthsdb.herokuapp.com/]?)
