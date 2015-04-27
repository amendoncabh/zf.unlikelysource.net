#! /bin/sh
# create-zf-project.sh
# Create a Zend Framework Skeleton Project
# Usage: create-zf-project.sh projectName
# make this executable by issuing at the prompt: chmod -R u+x create-zf-project.sh 

# Require a project name be given
if test -z ${1}
then
    echo Usage: create-zf-project.sh projectName
    exit
fi

# specify whatever path is desired
TARGET_BASE_DIR=/home/zenduser

# The target directory has to exist, if we are to create a project within it.
if !(test -d ${TARGET_BASE_DIR})
then
    echo Directory ${TARGET_BASE_DIR} does not exist!
    exit
fi

# Ensure we do not already have an existing project at this location.
if test -d ${TARGET_BASE_DIR}/${1}
then
    echo Project ${TARGET_BASE_DIR}/${1} already exists!
    exit
fi

# Initialize script variables
# ZF_USER_GROUP is used in a chown command later in the script
ZF_USER_GROUP=zenduser:www-data

DBNAME=wikiapp.sqlite

# If you have more than one module in your application, you could reset this
# as needed in the script.  You will very likely have more than one controller!
MODULE=wiki
CONTROLLER=User

cd ${TARGET_BASE_DIR}

zf create project ${1}
cd ${1}

# Create the data hierarchy
mkdir data
mkdir data/cache
mkdir data/db
mkdir data/indexes
mkdir data/logs
mkdir data/session
mkdir data/uploads
mkdir temp

####
# Students, this is just for demonstrating the zf tool dbtable.from-database provider!
cp /workspace/wikiapp.work/data/db/${DBNAME} data/db
####

# Use layouts
zf enable layout

# Set up a module
zf create module ${MODULE}

# Students, PlEASE NOTE: you should edit the application.ini file and change
# the db path name to read: APPLICATION_PATH "/../data/db/wikiapp.sqlite"
zf configure dbadapter "adapter=Pdo_Sqlite&dbname=${TARGET_BASE_DIR}/${1}/data/db/${DBNAME}"

# Note that you'll get all DbTable models created in the wiki module this way,
# which may not be what you want (see application/models/DbTable/User.php and
# application/modules/models/DbTable/User.php in wikiapp.work, for example)
zf create dbtable.from-database ${MODULE}

# Create Application Domain Models
zf create model User
zf create model CurrentUser

# Create Wiki Module Domain Models
zf create model Article wiki
zf create model User wiki
zf create model AccessControl wiki

# Students: if the dbtable.from-database had not been used above, the commands
# below would need to be uncommented and run.  Note that specifying the
# module only when appropriate leads to the models being created in the
# appropriate directories.

# Create Application and Wiki Module DbTable Models (See Students: if the ... above)
#zf create db-table User user
#zf create db-table User wiki_user wiki
#zf create db-table Article wiki_article wiki

# Creation of Service Layer Classes for Application and Wiki Module
zf create model AuthenticationService
zf create model UserService
zf create model UserService wiki
zf create model ArticleService wiki

# set up application controllers/actions/views
zf create controller ${CONTROLLER}
zf create action login ${CONTROLLER}
zf create action logout ${CONTROLLER}
# can also specify controller this way:
zf create action view --controller-name=${CONTROLLER}

# Set up module controllers/actions/views
CONTROLLER=Article
zf create controller ${CONTROLLER} --module=${MODULE}
zf create action view --controller-name=${CONTROLLER} --module=${MODULE}
# can also specify controller and module this way (the '1' says to include a view):
# if you don't use --module=, then you must include the '1'
zf create action edit ${CONTROLLER} 1 ${MODULE}
zf create action history ${CONTROLLER} 1 ${MODULE}

CONTROLLER=Help
zf create controller ${CONTROLLER} --module=${MODULE}

CONTROLLER=RecentChanges
zf create controller ${CONTROLLER} --module=${MODULE}

# Create application forms (none here)

# Create module forms
zf create form Article ${MODULE}
zf create form Search ${MODULE}

# Ensure that web server can write to directories/files, as appropriate.
# At the sudo prompt, enter "password" (without the quotes)
echo Setting permissions in ${TARGET_BASE_DIR}
sudo chown -R ${ZF_USER_GROUP} data/cache data/db data/indexes data/logs \
    data/session data/uploads temp

chmod -R g+rw data/cache data/db data/indexes data/logs \
    data/session data/uploads temp
