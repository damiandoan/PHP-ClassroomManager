src = "https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"
src ="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"
src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"


function reset_password_popup(){
    window.open('reset_password.php','popup','width=600,height=600')
}



function send_delete_student_request( student_ID, first_name, last_name) {
        var button = document.getElementById('delete-button');
        button.value = student_ID;
        var alert = document.getElementById('student-delete-name');
        alert.innerHTML = first_name +' '+ last_name
}


function hint(keyword, email){
    console.log(keyword);
    let cards = document.getElementsByClassName("col-md-4 classroom-card");
    Array.from(cards).forEach( card =>{
        
        card.style.display= "inline";
    
});
    
    
    //send request to server
    const xhr = new XMLHttpRequest();
    xhr.addEventListener('load', e =>{
        if(xhr.readyState ==4 && xhr.status ==200){
            let receive = JSON.parse(xhr.responseText)
            console.log(receive)
            

          
            console.log(cards)
            Array.from(cards).forEach( card =>{
                if( receive.indexOf(card.id)){
                    card.style.display= "none"
                }
            });

            if(receive.length == 0){
                Array.from(cards).forEach( card =>{
        
                    card.style.display= "inline";
                
            });
            }
        }
    })
    xhr.open('GET','searching.php?keyword='+encodeURIComponent(keyword)+'&email='+encodeURIComponent(email), true)
    xhr.send();
}
