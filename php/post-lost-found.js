window.onload = function() {
  var submit = document.getElementById('submit');
  submit.addEventListener('click', ajaxRequest, true);
}

function ajaxRequest(event) {


  event.preventDefault()
  var title= document.getElementById('title').value;
  var zipcode= document.getElementById('zipcode').value;  
  var species= document.getElementById('species').value;  
  var picture_url= document.getElementById('picture_url').value;  
  var email= document.getElementById('email').value;  
  var tel= document.getElementById('tel').value;  
  var description= document.getElementById('description').value;

  var lostfound = null;
  if (document.getElementById('lost').checked == true) {
    lostfound = 'lost';
  } else if (document.getElementById('found').checked == true) {
    lostfound = 'found';
  }
  
  var httpRequest = new XMLHttpRequest();
  
  httpRequest.onreadystatechange = function() {
    if (httpRequest.readyState === 4 && httpRequest.status === 200) {
      alert(httpRequest.responseText);

      if (httpRequest.responseText == 'Success!') {
        document.getElementById('title').value = '';
        document.getElementById('zipcode').value = '';
        document.getElementById('species').value = '';
        document.getElementById('picture_url').value = '';
        document.getElementById('email').value = '';
        document.getElementById('tel').value = '';
        document.getElementById('description').value = '';
        
      }
    } 
  }
  
  var params = '?title=' + title;
  params = params + '&zipcode=' + zipcode;
  params = params + '&species=' + species;
  params = params + '&picture_url=' + picture_url;
  params = params + '&email=' + email;
  params = params + '&tel=' + tel;
  params = params + '&description=' + description;
  params = params + '&lostfound=' + lostfound;
  params = params + '&rand=' + Math.random();

//alert ('yep yep');

// for testing 
// alert(params);

  httpRequest.open('GET', 'post-lost-found-backend.php' + params, true);
  httpRequest.send();    
}