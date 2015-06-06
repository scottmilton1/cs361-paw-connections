window.onload = function() {
  var submit = document.getElementById('submit');
  submit.addEventListener('click', ajaxRequest, true);
}



function ajaxRequest(event) {


  event.preventDefault()
   var title= document.getElementById('title').value;
   var species= document.getElementById('species').value; 
   var gender= document.getElementById('gender').value;
   var size= document.getElementById('size').value;
   var name= document.getElementById('name').value;  
   var breed= document.getElementById('breed').value;  
   var age= document.getElementById('age').value;  
   var description= document.getElementById('description').value;
   var adoption_fee= document.getElementById('adoption_fee').value;
   var pictureurl= document.getElementById('pictureurl').value;
   var facility_name= document.getElementById('facility_name').value; 
   var address= document.getElementById('address').value;  
   var city= document.getElementById('city').value;
   var zipcode= document.getElementById('zipcode').value;  
   var state= document.getElementById('state').value;
   var facility_url= document.getElementById('facility_url').value;  
   var email= document.getElementById('email').value;  
   var tel= document.getElementById('tel').value;  

    var httpRequest = new XMLHttpRequest();
  
  httpRequest.onreadystatechange = function() {
    if (httpRequest.readyState === 4 && httpRequest.status === 200) {
      alert(httpRequest.responseText);

      if (httpRequest.responseText == 'Success!') {
        document.getElementById('title').value = '';
	document.getElementById('species').value = ''; 
   	document.getElementById('gender').value ='';
 	document.getElementById('size').value ='';
	document.getElementById('name').value ='';  
        document.getElementById('breed').value ='';  
  	document.getElementById('age').value ='';  
 	document.getElementById('description').value ='';
  	document.getElementById('adoption_fee').value ='';
  	document.getElementById('pictureurl').value ='';
	document.getElementById('facility_name').value =''; 
   	document.getElementById('address').value ='';  
	document.getElementById('city').value ='';
   	document.getElementById('zipcode').value ='';  
  	document.getElementById('state').value ='';
 	document.getElementById('facility_url').value ='';  
  	document.getElementById('email').value ='';  
   	document.getElementById('tel').value =''; 
        
      }
    } 
  }
  
  
   var params = '?title=' + title;
   	params = params + '&breed=' + breed;
    params = params + '&species=' + species;
    params = params + '&gender=' + gender;
    params = params + '&species=' + species;
    params = params + '&size=' + size;
    params = params + '&name=' + name;
    params = params + '&age=' + age;
    params = params + '&description=' + description;
    params = params + '&adoption_fee=' + adoption_fee;
    params = params + '&pictureurl=' + pictureurl;
    params = params + '&facility_name=' + facility_name;
    params = params + '&address=' + address;
    params = params + '&city=' + city;
    params = params + '&zipcode=' + zipcode;
    params = params + '&state=' + state;
    params = params + '&facility_url=' + facility_url;
    params = params + '&email=' + email;
    params = params + '&tel=' + tel; 	
    params = params + '&rand=' + Math.random();

  httpRequest.open('GET', '../php/post_adoption_backend.php' + params, true);
  httpRequest.send();    
  
  
}  