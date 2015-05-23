<?php

// create unit tests for phpunit
class LostFoundTest extends PHPUnit_Framework_TestCase
{
	public function testValidateEmailFormat()
	{
		$this->assertEquals(true, validate_email(‘test@mailinator.com’));
		$this->assertEquals(false, validate_email(‘aldksjfa@@asdfoma’));
	}

	public function testPhoneFormat()
	{
		$this->assertEquals(true, validate_phone(‘8888888888’));
		$this->assertEquals(false, validate_phone(‘1-i98pp--098324324));
	}

	public function testZipCode()
	{
		$this->assertEquals(true, validate_zip(‘98105’));
		$this->assertEquals(false, validate_zip(‘illegal666pwnd!!!’));
	}

	public function testUrlToPhoto()
	{
		$this->assertEquals(true, validate_photo_url(‘photosite.com:8080/path/to/photo’));
		$this->assertEquals(false, validate_photo_url(‘photositecom/asdflkj’));
	}

	public function testPostToDB_succeed()
	{
		$_POST[‘title’] = ‘cute puppy’;
		$_POST[‘zipcode’] = ‘12345’;
		$_POST[‘lat’] = ‘123.45’;
		$_POST[‘lng’] = ‘678.90’;
		$_POST[‘text_body’] = ‘Lovable lil’ guy wants to go home’;
		$_POST[‘species’] = ‘dog’;
		$_POST[‘email’] = ‘email@emailman.com’;
		$_POST[‘tel’] = ‘1234567890’;
		$_POST[‘picture_url’] = ‘photosite.com/pic’;

		$this->assertEquals(true, send_to_db());
	}

	public function testPostToDB_fail() 
	{
		$_POST[‘title’] = ‘cute puppy’;
		$_POST[‘zipcode’] = ‘12345’;

		$this->assertEquals(false, send_to_db());
	}

} // end class

?>
