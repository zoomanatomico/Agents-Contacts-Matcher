<?php 

namespace App\Readers;

interface ContactsReader
{
	// In order to keep the code consistence all the readers must implement this method
	public function fetchContacts();
}