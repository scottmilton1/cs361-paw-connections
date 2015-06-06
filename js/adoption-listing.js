var where_clause = "";

window.onload = function () {
	document.getElementById('dog').addEventListener('click', filter);
	document.getElementById('cat').addEventListener('click', filter);
	document.getElementById('bird').addEventListener('click', filter);
	document.getElementById('zip').addEventListener('click', filter);
	document.getElementById('distance').addEventListener('change', filter);
	filter();
}

function request(statement) {
	var xmlhttp;
	var url = "php/adoption-listing.php";
	if( window.XMLHttpRequest) {
		xmlhttp = new XMLHttpRequest();
	}
	else {
		xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
	}
	xmlhttp.onreadystatechange = function ()
	{
		if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			var response = xmlhttp.responseText;
			document.getElementById('listings').innerHTML = response;
			distanceCalc();
		}
	}
	xmlhttp.open('GET', url + statement, true);
	xmlhttp.send();
}


function filter() {
	validateZip();
	var statement = "?filter=true";
	var dog_filter = document.getElementById('dog').checked;
	var cat_filter = document.getElementById('cat').checked;
	var bird_filter = document.getElementById('bird').checked;
	var zip_filter = document.getElementById('zip').checked;

	if (!dog_filter && !cat_filter && !bird_filter) {
		statement += "&dog_filter=true";
		statement += "&cat_filter=true";
		statement += "&bird_filter=true";
	} else {

		if (dog_filter) {
			statement += "&dog_filter=true";
		}
		if (cat_filter) {
			statement += "&cat_filter=true";
		}
		if (bird_filter) {
			statement += "&bird_filter=true";
		}
	}
	//if (zip_filter) {
	zipFilter(statement);
	//}
	//request(statement);
}

function zipFilter(filters) {
	//gets the zip code from the html
	var zip = document.getElementById('zipCode').value;
	//build part of the request to find the lat and lng of the zip code
	var statement = '/info.json/' + zip + '/degrees/';
	//call the AJAX request function
	requestZip(statement, filters);
}

function requestZip(statement, filters) {
	var xmlhttp;
	//key needed to access the API
	var key = 'js-bqjXIp0ZfvQPDDly8hL0rQ0V3Dkho0FAqZx9py9F3ZuHDPfM71MySNuVrOcPPSpg';
	//build the url to make AJAX request by adding the key to base url
	var url = "https://www.zipcodeapi.com/rest/" + key;
	if( window.XMLHttpRequest) {
		xmlhttp = new XMLHttpRequest();
	}
	else {
		xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
	}
	xmlhttp.onreadystatechange = function ()
	{
	//this function has two parts
	//Part 1: handles the lat and lng request and then
	//recursively calls intself after building a new request statement
	//in order to have the API build us our WHERE clause
	//Part 2: handles the response to the WHERE clause request
		if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			var response = xmlhttp.responseText;
			var temp = JSON.parse(response);
			//this will evaluate true if the response includes a lat element
			//which
			if(typeof temp['lat'] != 'undefined') {
				var lat = temp['lat'];
				var lng = temp['lng'];
				var distance = document.getElementById('distance').value;
				statement = '/radius-sql.json/' + lat + '/' + lng +'/degrees/' + distance + '/mile/lat/lng/1';
				requestZip(statement, filters);
			} else if (typeof temp['where_clause']) {
				var zipChecked = document.getElementById('zip').checked;
				if(zipChecked)	{
					console.log('inside zip=true');
					request(filters + '&zip_filter=' + temp['where_clause']);
				} else {
					request(filters);
				}
			}
		}
	}
	//add the statement to the url and send request
	xmlhttp.open('GET', url + statement, true);
	xmlhttp.send();
}

function validateZip() {
	var zip = document.getElementById('zipCode').value;
	if(zip == null || zip == '') {
		zip = prompt('Please Enter a Zipcode:');
		document.getElementById('zipCode').value = zip;
	}
}

/*
	REQUEST TO GET DISTANCE BETWEEN 2 ZIP CODES
*/
function distanceCalc() {
	var zipcode_user = document.getElementById('zipCode').value;
	var zipcodes_pet = document.getElementsByClassName('zip_code');
	var links_pet = document.getElementsByClassName('detail_link');
	for (var i=0; i < zipcodes_pet.length; i++) {
		var zipcode_pet = zipcodes_pet[i].textContent;
		var statement = zipcode_user + '/' + zipcode_pet + '/mile';
		var pet_id = links_pet[i].getAttribute('id');
		requestDistance(statement, pet_id);
	}
}

function requestDistance(statement, id) {
	var xmlhttp;
	//key needed to access the API
	var key = 'js-bqjXIp0ZfvQPDDly8hL0rQ0V3Dkho0FAqZx9py9F3ZuHDPfM71MySNuVrOcPPSpg';
	//build the url to make AJAX request by adding the key to base url
	var url = 'https://www.zipcodeapi.com/rest/' + key + '/distance.json/';

	if( window.XMLHttpRequest) {
		xmlhttp = new XMLHttpRequest();
	}
	else {
		xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
	}
	xmlhttp.onreadystatechange = function ()
	{
		if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			var response = xmlhttp.responseText;
			var json = JSON.parse(response);
			var distance = json['distance'];
			var link = document.getElementById(id).getAttribute('href');
			link += '&distance=' + distance;
			document.getElementById(id).setAttribute('href', link);
		}
	}
	xmlhttp.open('GET', url + statement, true);
	xmlhttp.send();
}
