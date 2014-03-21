#!/usr/bin/perl

use IO::Scalar;
use CGI::Pretty;
use Spreadsheet::WriteExcel;
use Date::Calendar::Profiles qw( $Profiles &Previous_Friday &Next_Monday );
use Date::Calendar;
use Date::Calc qw(:all);
