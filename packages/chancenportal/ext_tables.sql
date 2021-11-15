#
# Table structure for table 'tx_chancenportal_domain_model_provider'
#
CREATE TABLE tx_chancenportal_domain_model_provider (

	name varchar(255) DEFAULT '' NOT NULL,
	slug varchar(255) DEFAULT '' NOT NULL,
	subline varchar(255) DEFAULT '' NOT NULL,
	short_description text,
	long_description text,
	number_of_employees int(11) DEFAULT '0' NOT NULL,
	participation smallint(5) unsigned DEFAULT '0' NOT NULL,
	content_image int(11) unsigned DEFAULT '0' NOT NULL,
	logo int(11) unsigned DEFAULT '0' NOT NULL,
	street varchar(255) DEFAULT '' NOT NULL,
	city varchar(255) DEFAULT '' NOT NULL,
	email varchar(255) DEFAULT '' NOT NULL,
	website varchar(255) DEFAULT '' NOT NULL,
	contact_salutation int(11) DEFAULT '0' NOT NULL,
	contact_name varchar(255) DEFAULT '' NOT NULL,
	contact_jurisdiction varchar(255) DEFAULT '' NOT NULL,
	contact_phone varchar(255) DEFAULT '' NOT NULL,
	contact_email varchar(255) DEFAULT '' NOT NULL,
	contact_image int(11) unsigned DEFAULT '0' NOT NULL,
	phone varchar(255) DEFAULT '' NOT NULL,
	phone2 varchar(255) DEFAULT '' NOT NULL,
	opening_hours text,
	active smallint(5) unsigned DEFAULT '0' NOT NULL,
	zip varchar(255) DEFAULT '' NOT NULL,
	address varchar(255) DEFAULT '' NOT NULL,
	lat varchar(255) DEFAULT '' NOT NULL,
	lng varchar(255) DEFAULT '' NOT NULL,
	approved smallint(5) unsigned DEFAULT '0' NOT NULL,
	reminder_email_send smallint(5) unsigned DEFAULT '0' NOT NULL,
	content_image_copyright varchar(255) DEFAULT '' NOT NULL,
	labels int(11) unsigned DEFAULT '0' NOT NULL,
	offers int(11) unsigned DEFAULT '0' NOT NULL,
	owner_group int(11) unsigned DEFAULT '0',
	carrier int(11) unsigned DEFAULT '0',
	categories int(11) unsigned DEFAULT '0' NOT NULL,
	creator int(11) unsigned DEFAULT '0',
	author int(11) unsigned DEFAULT '0',

);

#
# Table structure for table 'tx_chancenportal_domain_model_offer'
#
CREATE TABLE tx_chancenportal_domain_model_offer (

	provider int(11) unsigned DEFAULT '0' NOT NULL,

	name varchar(255) DEFAULT '' NOT NULL,
	slug varchar(255) DEFAULT '' NOT NULL,
	address_type int(11) DEFAULT '0' NOT NULL,
	address varchar(255) DEFAULT '' NOT NULL,
	lat varchar(255) DEFAULT '' NOT NULL,
	lng varchar(255) DEFAULT '' NOT NULL,
	info varchar(255) DEFAULT '' NOT NULL,
	short_description text,
	long_description text,
	speaker varchar(255) DEFAULT '' NOT NULL,
	images int(11) unsigned DEFAULT '0' NOT NULL,
	youtube varchar(255) DEFAULT '' NOT NULL,
	conditions_of_participation text,
	course_number varchar(255) DEFAULT '' NOT NULL,
	allowed_participants varchar(255) DEFAULT '' NOT NULL,
	costs varchar(255) DEFAULT '' NOT NULL,
	all_ages smallint(5) unsigned DEFAULT '0' NOT NULL,
	access int(11) DEFAULT '0' NOT NULL,
	accessibility int(11) DEFAULT '0' NOT NULL,
	participate varchar(255) DEFAULT '' NOT NULL,
	donate varchar(255) DEFAULT '' NOT NULL,
	provider_cooperation varchar(255) DEFAULT '' NOT NULL,
	format varchar(255) DEFAULT '' NOT NULL,
	no_costs smallint(5) unsigned DEFAULT '0' NOT NULL,
	parent_school smallint(5) unsigned DEFAULT '0' NOT NULL,
	contact_salutation int(11) DEFAULT '0' NOT NULL,
	contact_name varchar(255) DEFAULT '' NOT NULL,
	contact_jurisdiction varchar(255) DEFAULT '' NOT NULL,
	contact_phone varchar(255) DEFAULT '' NOT NULL,
	contact_email varchar(255) DEFAULT '' NOT NULL,
	contact_image int(11) unsigned DEFAULT '0' NOT NULL,
	active smallint(5) unsigned DEFAULT '0' NOT NULL,
	content_image int(11) unsigned DEFAULT '0' NOT NULL,
	active_date datetime DEFAULT NULL,
	zip text,
	city text,
	street text,
	approved smallint(5) unsigned DEFAULT '0' NOT NULL,
	date_type int(11) DEFAULT '0' NOT NULL,
	start_date date DEFAULT NULL,
	end_date date DEFAULT NULL,
	reminder_email_send smallint(5) unsigned DEFAULT '0' NOT NULL,
	images_copyright varchar(255) DEFAULT '' NOT NULL,
	content_image_copyright varchar(255) DEFAULT '' NOT NULL,
	participation smallint(5) unsigned DEFAULT '0' NOT NULL,
	opening_hours text,
	next_calculated_date datetime DEFAULT NULL,
	moddate datetime DEFAULT NULL,
	dates int(11) unsigned DEFAULT '0' NOT NULL,
	target_groups int(11) unsigned DEFAULT '0' NOT NULL,
	categories int(11) unsigned DEFAULT '0' NOT NULL,
	district int(11) unsigned DEFAULT '0',
	creator int(11) unsigned DEFAULT '0',
	last_editor int(11) unsigned DEFAULT '0',

);

#
# Table structure for table 'tx_chancenportal_domain_model_label'
#
CREATE TABLE tx_chancenportal_domain_model_label (

	provider int(11) unsigned DEFAULT '0' NOT NULL,

	name varchar(255) DEFAULT '' NOT NULL,
	text text,

);

#
# Table structure for table 'tx_chancenportal_domain_model_date'
#
CREATE TABLE tx_chancenportal_domain_model_date (

	offer int(11) unsigned DEFAULT '0' NOT NULL,

	start_date date DEFAULT NULL,
	start_time varchar(255) DEFAULT '' NOT NULL,
	end_date date DEFAULT NULL,
	end_time varchar(255) DEFAULT '' NOT NULL,
	active smallint(5) unsigned DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'fe_users'
#
CREATE TABLE fe_users (

	password_reset_hash varchar(255) DEFAULT '' NOT NULL,
	confirmation_send smallint(5) unsigned DEFAULT '0' NOT NULL,
	terms_and_conditions_date datetime DEFAULT NULL,

	tx_extbase_type varchar(255) DEFAULT '' NOT NULL,

);

#
# Table structure for table 'fe_groups'
#
CREATE TABLE fe_groups (

	tx_extbase_type varchar(255) DEFAULT '' NOT NULL,

);

#
# Table structure for table 'tx_chancenportal_domain_model_carrier'
#
CREATE TABLE tx_chancenportal_domain_model_carrier (

	name varchar(255) DEFAULT '' NOT NULL,

);

#
# Table structure for table 'tx_chancenportal_domain_model_category'
#
CREATE TABLE tx_chancenportal_domain_model_category (

	category1 int(11) unsigned DEFAULT '0' NOT NULL,

	name varchar(255) DEFAULT '' NOT NULL,
	images int(11) unsigned DEFAULT '0' NOT NULL,
	color varchar(255) DEFAULT '' NOT NULL,
	children int(11) unsigned DEFAULT '0' NOT NULL,
	parent int(11) unsigned DEFAULT '0',

);

#
# Table structure for table 'tx_chancenportal_domain_model_targetgroup'
#
CREATE TABLE tx_chancenportal_domain_model_targetgroup (

	name varchar(255) DEFAULT '' NOT NULL,

);

#
# Table structure for table 'tx_chancenportal_domain_model_district'
#
CREATE TABLE tx_chancenportal_domain_model_district (

	name varchar(255) DEFAULT '' NOT NULL,

);

#
# Table structure for table 'tx_chancenportal_domain_model_log'
#
CREATE TABLE tx_chancenportal_domain_model_log (

	date datetime DEFAULT NULL,
	term text,
	category int(11) unsigned DEFAULT '0',
	offer int(11) unsigned DEFAULT '0',

);

#
# Table structure for table 'tx_chancenportal_domain_model_label'
#
CREATE TABLE tx_chancenportal_domain_model_label (

	provider int(11) unsigned DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_chancenportal_domain_model_offer'
#
CREATE TABLE tx_chancenportal_domain_model_offer (

	provider int(11) unsigned DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_chancenportal_provider_category_mm'
#
CREATE TABLE tx_chancenportal_provider_category_mm (
	uid_local int(11) unsigned DEFAULT '0' NOT NULL,
	uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,
	sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid_local,uid_foreign),
	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);

#
# Table structure for table 'tx_chancenportal_domain_model_date'
#
CREATE TABLE tx_chancenportal_domain_model_date (

	offer int(11) unsigned DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_chancenportal_offer_targetgroup_mm'
#
CREATE TABLE tx_chancenportal_offer_targetgroup_mm (
	uid_local int(11) unsigned DEFAULT '0' NOT NULL,
	uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,
	sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid_local,uid_foreign),
	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);

#
# Table structure for table 'tx_chancenportal_offer_category_mm'
#
CREATE TABLE tx_chancenportal_offer_category_mm (
	uid_local int(11) unsigned DEFAULT '0' NOT NULL,
	uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,
	sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid_local,uid_foreign),
	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);

#
# Table structure for table 'tx_chancenportal_domain_model_category'
#
CREATE TABLE tx_chancenportal_domain_model_category (

	category1 int(11) unsigned DEFAULT '0' NOT NULL,

);

## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder

ALTER TABLE tx_chancenportal_domain_model_date MODIFY active smallint(5) unsigned DEFAULT '1' NOT NULL;

ALTER TABLE tx_chancenportal_domain_model_offer MODIFY address_type int(11) DEFAULT '1' NOT NULL;
