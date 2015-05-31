window.onload = function() {
  var submit = document.getElementById('submit');
  submit.addEventListener('click', ajaxRequest, true);
}

function ajaxRequest(event) {

//  alert('function working');
//  return;

  event.preventDefault();
  var title= document.getElementById('title').value;
  var zipcode= document.getElementById('zipcode').value;
  var species= document.getElementById('species').value;
  var pictureurl= document.getElementById('pictureurl').value;
  var email= document.getElementById('email').value;
  var tel= document.getElementById('tel').value;
  var textbody= document.getElementById('textbody').value;

  var httpRequest = new XMLHttpRequest();
  
  httpRequest.onreadystatechange = function() {
    if (httpRequest.readyState === 4 && httpRequest.status === 200) {
      alert(httpRequest.responseText);
      document.getElementById('name').value = '';
    } 
  }
  
  var params = '?title=' + title;
  params = params + '&zipcode=' + zipcode;
  params = params + '&species=' + species;
  params = params + '&pictureurl=' + pictureurl;
  params = params + '&email=' + email;
  params = params + '&tel=' + tel;
  params = params + '&textbody=' + textbody;
  

// alert(params);
  
  httpRequest.open('GET', '../php/post-lost-found-backend.php' + params, true);
  httpRequest.send();    
}