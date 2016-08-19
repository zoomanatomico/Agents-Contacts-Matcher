<?php 

namespace App\Readers;

use League\Csv\Reader;
	
/**
 * Right now this class only loads the predefined CSV so it could seem a little to much but in real projects 
 * we would need to delegate the retrieving logic into a specific class following the Single Responsability Principle.
 */	
class CSV implements ContactsReader
{
	/**
	 *
	 * Read the CSV file from disk and return the content as an array of data. 
	 *
	 * @returns array
	 */
	public function fetchContacts() 
	{
		$csv = Reader::createFromPath('csv/contacts.csv');
		return $csv->setOffset(1)->fetchAll();
	}	
}