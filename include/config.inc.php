<?php

# Welcome to the Daedalus Configuration File.
# Configuration options follow this syntax:
# 	$variable = "<value>";
# It is important that you put the double-quotes around the value.
# If you should need to insert a double-quote as the value its self,
#  escape it out by using a backslash (\").  For example:
#	$variable = "The dog said, \"I like beans.\"  Then he ate some.";
# Comments are marked with a hash, #, character as the first symbol.  
#
# Enjoy!
#

$daedalus_build = "04-01-2014";

# Sections:
# 1 - Installation and Graphic Options
# 2 - Database Configuration
# 3 - LDAP Configuration

# Section 1: Installation and Graphic Options
# -------------------------------------------

# PREFIX: The installed location of Daedalus, from the web-browsers point of view.
# Syntax: $PREFIX = "<path, i.e. /helpdesk/daedalus, /daedalus, /~joeuser/daedalus>";
# Default: $PREFIX = "/daedalus";

$PREFIX = "/daedalus";  // Should pull from $_SERVER

# USERPREFIX: The location of the "users" directory relative to the installed
# location of Daedalus. This should never need to be changed,  unless you move the 
# "users" directory to another location.
# Syntax: $USERPREFIX = "$PREFIX/users_path"
# Default: $USERPREFIX = "$PREFIX/users"

$USERPREFIX = "$PREFIX/users"; 

# UPREFIX: The installed location of Daedalus including access protocol and server,
# 		from the web-browsers point of view.
# Syntax: $UPREFIX = "http<s>://your.webserver.com/<path, i.e. /helpdesk/daedalus,
#		/daedalus, /~joeuser/daedalus>";
# Default: $UPREFIX = "http://your.server.com/daedalus";

$UPREFIX = "https://ebony.ndc.nasa.gov/daedalus";

# AUTHSOURCE: The source of authentication information.  Note, even if LDAP is
#               selected, permissions and preferences will be stored in
#               the database.
#       
# Syntax: $AUTHSOURCE = "<DB|LDAP>";
# Default: $AUTHSOURCE = "DB";

$AUTHSOURCE = "DB";


# Section 2: Database Configuration
# ---------------------------------
# Currently, Daedalus only supports MySQL. If there is interest, a pgSQL or MSSQL
# version can be run off.

# cfg_dbname: The database server and port.
# Syntax: $cfg_dbname = "<server>";
# Default: $cfg_dbname = "localhost";

$cfg_dbname = "localhost"; 

# cfg_dbuser: The database user
# Syntax: $cfg_dbuser = "<db-user>";
# Default: $cfg_dbuser = "admin";

$cfg_dbuser = "root"; 

# cfg_dbpasswd: The dbuser's password.
# Syntax: $cfg_dbpasswd = "<password>";
# Default: $cfg_dbpasswd = "";
$cfg_dbpasswd = "el0ret_kts";

# cfg_dbtype: Database type
# Syntax: $cfg_dbtype = "<database type>";
# Default: $cfg_dbtype = "mysql";

$cfg_dbtype = "mysql";


# Section 3: LDAP Configuration 
# ---------------------------------
# Use this section if you selected "LDAP" for the "$AUTHSOURCE" variable.
# Here you will specify all the options needed to bind to an ldap source.
# NOTE: We currently only bind to ldap servers anonymously.  In the future
# we will support authenticated binds.

# cfg_ldapserver: Hostname of the LDAP server
# Syntax: $cfg_ldapserver = "host";
# Default: $cfg_ldapserver = "ldap.host.com";
$cfg_ldapserver = "ldap.host.com";

# cfg_serverroot: Hostname of the LDAP server
# Syntax: $cfg_serverroot = "<root string>";
# Default: $cfg_serverroot = "o=host.com";
$cfg_serverroot = "o=host.com";

# cfg_ldapfullname: The identifier that we should use to determine a
# Full Name "First Name Last Name" style from the LDAP database.
# Make sure you do NOT add the "=" at the end.
# Syntax: $cfg_ldapfullname = "<fullname identifier string>";
# Default: $cfg_ldapfullname = "gecos";
$cfg_ldapfullname = "gecos";

# cfg_ldapemail: The identifier that we should use to determine an
# email address from the LDAP database.
# Make sure you do NOT add the "=" at the end.
# Syntax: $cfg_ldapemail = "<email identifier string>";
# Default: $cfg_ldapemail = "mail";
$cfg_ldapemail = "mail";

# cfg_ldaplocation: The identifier that we should use to determine a
# location from the LDAP database.
# Make sure you do NOT add the "=" at the end.
# Syntax: $cfg_ldaplocation = "<location identifier string>";
# Default: $cfg_ldaplocation = "officelocation";
$cfg_ldaplocation = "officelocation";

# cfg_ldapphone: The identifier that we should use to determine a
# phone number from the LDAP database.
# Make sure you do NOT add the "=" at the end.
# Syntax: $cfg_ldapphone = "<phone number identifier string>";
# Default: $cfg_ldapphone = "officephonenumber";
$cfg_ldapphone = "officephonenumber";
?>
