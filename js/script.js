function fenOpen(aCacher) {
  aCacher1 = document.querySelector("." + aCacher);
  aCacher1.style.display = "block";
  aCacher1.classList.toggle('fenButtonOn');
  aCacher1.classList.remove('fenButtonOff');
  var elements = document.querySelectorAll( "body > *:not(.aCacher)" );
  Array.from( elements ).forEach( s => s.style.filter = "grayscale(50%) blur(3px)");
}

function fenClose(aCacher) {
  aCacher1 = document.querySelector("." + aCacher);
  aCacher1.classList.toggle('fenButtonOn');
  aCacher1.classList.add('fenButtonOff');
  var elements = document.querySelectorAll( "body > *:not(.aCacher)" );
  Array.from( elements ).forEach( s => s.style.filter = "grayscale(0%)  blur(0px)");
  setTimeout(function(){
      aCacher1.style.display = "none";
  }, 600);
}

function deCache(div) {
  aCacher = document.querySelector("." + div);
  if(aCacher.classList.contains('transparent')) {
      aCacher.classList.remove('transparent');
  } 
}