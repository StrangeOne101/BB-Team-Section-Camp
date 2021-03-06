<?php
/**
 * Created by PhpStorm.
 * Author: StrangeOne101 (Toby Strange)
 */

//Make it be unable to be opened by a browser
if (!(isset($open) && $open)) {
    header("HTTP/1.1 403 Forbidden");
    exit;
}

/**
 * Returns a query to get all registration data in the database
 * @return string The query
 */
function getRegistrationQuery() {
    global $TABLE_REGISTRATIONS, $TABLE_COMPANIES, $TABLE_TYPES;
    return "SELECT $TABLE_REGISTRATIONS.ID, $TABLE_REGISTRATIONS.FirstName, $TABLE_REGISTRATIONS.LastName, $TABLE_COMPANIES.CompanyName AS Company, " .
		"$TABLE_TYPES.TypeName AS Type, $TABLE_REGISTRATIONS.Email, $TABLE_REGISTRATIONS.DOB, $TABLE_REGISTRATIONS.Address, $TABLE_REGISTRATIONS.Phone, " .
		"$TABLE_REGISTRATIONS.MobilePhone, $TABLE_REGISTRATIONS.ContactName, $TABLE_REGISTRATIONS.ContactPhone, $TABLE_REGISTRATIONS.MedicalDetails, " .
		"$TABLE_REGISTRATIONS.FoodDetails, $TABLE_REGISTRATIONS.CadetID, $TABLE_REGISTRATIONS.DateRegistered, IF ($TABLE_REGISTRATIONS.DatePaid IS NULL, \"Not Yet Received\", DatePaid) AS DatePaid, $TABLE_REGISTRATIONS.RefNo, IF($TABLE_REGISTRATIONS.PhotoPerm=1,'Yes','No') AS PhotoPerm " .
 		"FROM $TABLE_REGISTRATIONS INNER JOIN $TABLE_COMPANIES ON $TABLE_REGISTRATIONS.CompanyUnit = $TABLE_COMPANIES.CompanyID INNER JOIN $TABLE_TYPES ON " .
 		"$TABLE_REGISTRATIONS.RegisteeType = $TABLE_TYPES.TypeID ORDER BY ID DESC";
}

/**
 * Returns a query to get all recent registrations (all ones within the last week). Same as
 * getRegistrationQuery() but with less fields
 * @return string
 */
function getRecentRegistrations() {
	global $TABLE_REGISTRATIONS, $TABLE_COMPANIES, $TABLE_TYPES;
	return "SELECT $TABLE_REGISTRATIONS.FirstName, $TABLE_REGISTRATIONS.LastName, $TABLE_COMPANIES.CompanyName AS Company, " .
		"$TABLE_TYPES.TypeName AS Type, $TABLE_REGISTRATIONS.Email, $TABLE_REGISTRATIONS.DOB, $TABLE_REGISTRATIONS.Address, $TABLE_REGISTRATIONS.MedicalDetails, " .
		"$TABLE_REGISTRATIONS.FoodDetails, $TABLE_REGISTRATIONS.DateRegistered, $TABLE_REGISTRATIONS.RefNo, IF($TABLE_REGISTRATIONS.PhotoPerm=1,'Yes','No') AS PhotoPerm " .
		"FROM $TABLE_REGISTRATIONS INNER JOIN $TABLE_COMPANIES ON $TABLE_REGISTRATIONS.CompanyUnit = $TABLE_COMPANIES.CompanyID INNER JOIN $TABLE_TYPES ON " .
		"$TABLE_REGISTRATIONS.RegisteeType = $TABLE_TYPES.TypeID WHERE $TABLE_REGISTRATIONS.DateRegistered > (NOW() - INTERVAL 7 DAY) ORDER BY ID DESC";
}

/**
 * Gets a query for all registration data in the database from a certain company
 * @param int $companyID The ID of the company
 * @return string The query
 */
function getRegistrationsByCompanyQuery($companyID) {
	global $TABLE_REGISTRATIONS, $TABLE_COMPANIES, $TABLE_TYPES;
	return "SELECT $TABLE_REGISTRATIONS.FirstName, $TABLE_REGISTRATIONS.LastName, $TABLE_TYPES.TypeName AS Type, $TABLE_REGISTRATIONS.Email, $TABLE_REGISTRATIONS.DOB, $TABLE_REGISTRATIONS.Address, $TABLE_REGISTRATIONS.Phone, " .
	"$TABLE_REGISTRATIONS.MobilePhone, $TABLE_REGISTRATIONS.ContactName, $TABLE_REGISTRATIONS.ContactPhone, $TABLE_REGISTRATIONS.MedicalDetails, " .
	"$TABLE_REGISTRATIONS.FoodDetails, $TABLE_REGISTRATIONS.CadetID, $TABLE_REGISTRATIONS.DateRegistered, $TABLE_REGISTRATIONS.RefNo, IF ($TABLE_REGISTRATIONS.DatePaid IS NULL, \"Not Yet Received\", DatePaid) AS DatePaid, IF($TABLE_REGISTRATIONS.PhotoPerm=1,'Yes','No') AS PhotoPerm " .
	"FROM $TABLE_REGISTRATIONS INNER JOIN $TABLE_COMPANIES ON $TABLE_REGISTRATIONS.CompanyUnit = $TABLE_COMPANIES.CompanyID INNER JOIN $TABLE_TYPES ON " .
	"$TABLE_REGISTRATIONS.RegisteeType = $TABLE_TYPES.TypeID WHERE $TABLE_REGISTRATIONS.CompanyUnit = $companyID ORDER BY ID DESC";
}

/**
 * Gets a query for all registrations that have dietary requirements
 * @return string
 */
function getDietaryRegistrations() {
	global $TABLE_REGISTRATIONS, $TABLE_COMPANIES, $TABLE_TYPES;
	return "SELECT $TABLE_REGISTRATIONS.FirstName, $TABLE_REGISTRATIONS.LastName, $TABLE_COMPANIES.CompanyName AS Company, " .
		"$TABLE_TYPES.TypeName AS Type, " . "$TABLE_REGISTRATIONS.FoodDetails " . "FROM $TABLE_REGISTRATIONS INNER JOIN $TABLE_COMPANIES ON $TABLE_REGISTRATIONS.CompanyUnit = $TABLE_COMPANIES.CompanyID INNER JOIN $TABLE_TYPES ON " .
		"$TABLE_REGISTRATIONS.RegisteeType = $TABLE_TYPES.TypeID WHERE $TABLE_REGISTRATIONS.FoodDetails != \"\" ORDER BY TypeID, Company, LastName, FirstName";
}

/**
 * Gets a query for all registrations that have medical conditions
 * @return string
 */
function getMedicalRegistrations() {
	global $TABLE_REGISTRATIONS, $TABLE_COMPANIES, $TABLE_TYPES;
	return "SELECT $TABLE_REGISTRATIONS.FirstName, $TABLE_REGISTRATIONS.LastName, $TABLE_COMPANIES.CompanyName AS Company, " .
		"$TABLE_TYPES.TypeName AS Type, " . "$TABLE_REGISTRATIONS.MedicalDetails " . "FROM $TABLE_REGISTRATIONS INNER JOIN $TABLE_COMPANIES ON $TABLE_REGISTRATIONS.CompanyUnit = $TABLE_COMPANIES.CompanyID INNER JOIN $TABLE_TYPES ON " .
		"$TABLE_REGISTRATIONS.RegisteeType = $TABLE_TYPES.TypeID WHERE $TABLE_REGISTRATIONS.MedicalDetails != \"\" ORDER BY TypeID, Company, LastName, FirstName";
}

/**
 * Gets a query to get all company data. DO NOT DELETE. Required for things that fetch the companies. E.g. The Registration Form
 * @return string The query
 */
function getCompanies() {
	global $TABLE_COMPANIES;
	return "SELECT * FROM $TABLE_COMPANIES";
}

?>