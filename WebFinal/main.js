// src = "https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"
// src ="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"
// src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"


function reset_password_popup(){
    window.open('reset_password.php','popup','width=600,height=600')
}



function send_delete_student_request( student_ID,classroom_name, first_name, last_name, teacher_email) {
    // $('#confirm-delete-student').modal('show')
        var button = document.getElementById('delete-button');
        button.style = '';
        var alert = document.getElementById('student-delete-name');
        alert.innerHTML = 'Do you really want to delete '+first_name +' '+ last_name
        $('#confirm-delete-student').modal('show')
        $('#delete-button').off('click').click( function(){
            let form = document.getElementById('delete-student-form')
            fd = new FormData(form);
            fd.append('delete-student', student_ID);
            fd.append('from-classroom', classroom_name);
            //console.log(student_ID, classroom_name)
            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if(xhttp.readyState ==4 && xhttp.status ==200){
                    // get_classroom(teacher_email);
                    //console.log(xhttp.responseText)
                    receive = JSON.parse(xhttp.responseText)
                    if (receive == 'success'){
                        load_students(teacher_email, classroom_name)
                        alert.innerHTML = 'delete ' + first_name +' '+ last_name + ' successfully'
                        button.style.display = 'none'
                    }
                    
                }
            };
            xhttp.open("POST","database.php", true);
            xhttp.send(fd);

        })
       
        
}


function hint(keyword, email){
    //console.log(keyword);
    let cards = document.getElementsByClassName("col-md-4");
    Array.from(cards).forEach( card =>{
        
        card.style.display ='';
        card.style.transform = ''
        
    
});
    
    
    //send request to server
    const xhr = new XMLHttpRequest();
    xhr.addEventListener('load', e =>{
        if(xhr.readyState ==4 && xhr.status ==200){
            let receive = JSON.parse(xhr.responseText)
            // console.log(receive)
            

          
            //console.log(cards)
            if(receive.length > 0){
                    Array.from(cards).forEach( card =>{
                        founded = false
                        properties = card.id.split(' ')
                        
                        properties.forEach( property=>{
                            if( receive.indexOf(property)>=0){
                                founded = true
                            }
                        })

                        if(founded == false){
                            card.style.display= "none"
                        }
                        else{
                        card.style.display= "inline"
                        card.style.transform = 'scale(1.05)'
                        }
                    });

                    // if(receive.length == 0){
                    //     Array.from(cards).forEach( card =>{
                    //         card.style.display= "inline";
                        
                    // });
            }
           
        }
    })
    xhr.open('GET','searching.php?keyword='+encodeURIComponent(keyword)+'&email='+encodeURIComponent(email), true)
    xhr.send();
}


function check_attendance(lesson_ID){
    //console.log('kes:' + lesson_ID)
    $("#check-attendance").modal("show")
    var checker = document.getElementsByClassName('check-input')
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if(xhr.readyState ==4 && xhr.status ==200){
            let receive = JSON.parse(xhr.responseText)
            //console.log(receive)
            Array.from(checker).forEach( checkbox =>{
                    
                if( receive.indexOf(checkbox.value)>=0){
                    checkbox.checked = true;
                    //console.log('oke');
                }
            });
        }
    }
    xhr.open('GET','attendance.php?attendance_view='+encodeURIComponent(lesson_ID), true)
    xhr.send();

   
$(document).ready(function(){
    $('#check-all').off('click').click(function(){
        Array.from(checker).forEach( checkbox =>{
            checkbox.checked = true;
    });
    });
  });

  $(document).ready(function(){
    $('#apply-checking').off('click').click(function(){
        //console.log('lesson: '+lesson_ID)
        Array.from(checker).forEach( checkbox =>{
                //console.log('oke: lesson:', lesson_ID)
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                   
                };
                xhttp.open("POST", "attendance.php", true);
                xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;");
                if(checkbox.checked == true){
                xhttp.send("student_ID="+encodeURIComponent(checkbox.value)+"&lesson_ID="+encodeURIComponent(lesson_ID), true);
                }
                else if(checkbox.checked == false){
                    xhttp.send("un_student_ID="+encodeURIComponent(checkbox.value)+"&lesson_ID="+encodeURIComponent(lesson_ID), true);
                }
                
    });
    return
    });
  });

  Array.from(checker).forEach( checkbox =>{
                    
    checkbox.checked = false;
    
});

} 



function review_miss_over_20(classroom_name, teacher_email){
    
    //setup first
    var tbody = document.getElementById('review-table-body')
    tbody.innerHTML ='';
    
    var xhttp = new XMLHttpRequest();
    // //console.log(classroom_name, teacher_email)
    xhttp.onreadystatechange = function() {
        if(xhttp.readyState ==4 && xhttp.status ==200){
            let receive = JSON.parse(xhttp.responseText)
            

            //put result in modal
            
            let i = 0
            if(receive!=null){
                    receive.forEach(student=>{
                        //console.log(student)
                        let tr = document.createElement('tr')
                        tr.innerHTML=`<td scope="row">${i}<td>${student['first_name']}<td >${student['last_name']}<td>${student['student_ID']}<td>`
                        tbody.appendChild(tr)
                        i++
                    })
            }
            $('#review-miss-modal').modal('show')

        }
        
    };
    xhttp.open("GET", "attendance.php?review20name="+encodeURIComponent(classroom_name)+"&review20email="+encodeURIComponent(teacher_email), true);
    xhttp.send();
    
     //show later             
}

function request_inspect_user(teacher_email){
   
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if(xhttp.readyState ==4 && xhttp.status ==200){
             //console.log(xhttp.responseText);
        }
        
    };
    xhttp.open("GET", "database.php?inspect="+encodeURIComponent(teacher_email), true);
    xhttp.send();
    window.open('homepage.php','_blank');
}

function get_user(){

        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if(xhttp.readyState ==4 && xhttp.status ==200){
                let receive = JSON.parse(xhttp.responseText)
                //put result in modal
                //console.log(xhttp.responseText)
                let row = document.getElementById('admin-page')
                row.innerHTML =''
                let i = 0
                if(receive!=null){
                        receive.forEach(user=>{
                            //console.log(user)
                            
                            
                            let card = document.createElement('div')
                            card.className = 'card account-view'
                            card.style.width = '18rem'
                            card.innerHTML = `
                            <div class="card-body">
                                <h5 class="card-title">${user['fullname']}</h5>
                                <h6 class="card-subtitle mb-2 text-muted">Account: ${user['email']}</h6>
                                <p class="card-text">Department: ${user['department_name']}</p>
                                <p class="card-text">tel: ${user['tel']}</p>
                                <h5 > role : ${user['role']}</h5>
                                    
                                    <button  onclick = "request_inspect_user('${user['email']}')" class="btn btn-outline-primary">View account</button>
                                    <button  onclick = "change_role('${user['email']}', '${user['role']}')" class="btn btn-danger">Change role</button>

                            </div>
                          `
                          row.appendChild(card)
                        })
                        
                }
            }
            
        };
        xhttp.open("GET", "database.php?adminview=true", true);
        xhttp.send();
    
}



//  function get_role(email){
//     xhttp = new XMLHttpRequest();
//     xhttp.onreadystatechange = function() {
//         if(xhttp.readyState ==4 && xhttp.status ==200){
//              //console.log(xhttp.responseText);
//              receive = JSON.parse(xhttp.responseText)
//              //console.log(receive)
//         }
//         else{
//         }
//     };
//     xhttp.open("GET", "database.php?get_role="+encodeURIComponent(email), true);
//     xhttp.send();
//  }
 function change_role(email,role){
 
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if(xhttp.readyState ==4 && xhttp.status ==200){
            get_user();
        }
        
    };
    xhttp.open("POST","database.php", true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;");
    xhttp.send("email_role="+encodeURIComponent(email), true);
    
 }


 function get_classroom(teacher_email){
      
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if(xhttp.readyState ==4 && xhttp.status ==200){
            //console.log(xhttp.responseText);
            let receive = JSON.parse(xhttp.responseText)
                //put result in modal
                // //console.log(xhttp.responseText)
                let row = document.getElementById('classrooms-view')
                row.innerHTML =''
                let i = 0
                if(receive!=null){
                    receive.forEach(classroom=>{
                        if(classroom['image']== 'database/classroom_images/'){
                            classroom['image'] ='images/default_classroom.png';
                        }
                        let card = document.createElement('div')
                        card.className='card col-md-4'
                        
                        card.id = classroom['classroom_name']+' '+classroom['subject']+' '+classroom['room_ID']
                        card.innerHTML = `
                        <div class="card-header" id ='header'>
                        
                                            <div class = 'row'>
                                                <div class = 'col-md-8'> <h5>${classroom['classroom_name']}</h4></div>
                                                <div class = 'col-md-1'> <div class="dropdown">
                                                <button type="button" class="btn btn-outline-primary dropdown-toggle" data-toggle="dropdown">
                                                  Edit
                                                </button>
                                                <div class="dropdown-menu">
                                                <button type="submit"  onclick = "delete_classroom('${classroom['teacher_email']}','${classroom['classroom_name']}')" class="dropdown-item"> Delete</button>
                                                <button type="submit" form = 'edit-class' onclick="edit_classroom('${classroom['teacher_email']}','${classroom['classroom_name']}','${classroom['subject']}', '${classroom['room_ID']}','${classroom['course_length'] }')" class="dropdown-item">Edit</button>
                                                </div>
                                             </div> 
                                            
                                    </div>
                                    </div>
                                    </div>
                                   
                                    <div class="card-body">
                                              <img class="card-img-top" id ='img-class' src="${classroom['image']}" alt="" >
                                              <p class="card-text"><strong>Subject: </strong> ${classroom['subject']}</h4>
                                              <p class="card-text"><strong>Length: </strong>${classroom['course_length'] } Lessons</p>
                                              <p class="card-text"><strong>room: </strong>${classroom['room_ID']}</h4>
                                              <div>
                                    <button  class = 'btn btn-success' type ='submit' form ='go-to-classroom' name  = 'go-to-classroom' value ='${classroom['teacher_email']}<*>${classroom['classroom_name']}' >Open classroom</button>

                                    </div>
                                    </div>
                                    

                      `
                      row.appendChild(card)

                    })

                    

                }
        }
    };
    xhttp.open("GET","database.php?classrooms_load="+encodeURIComponent(teacher_email),true);
    // xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;");
    xhttp.send();
 }
 

 function  edit_classroom(teacher_email, classroom_name, subject, room_ID, course_length){
      
      document.getElementById('modal-label-classroom').innerHTML= `Edit ${classroom_name} information`;
      var modal = document.getElementById('input-field')
      modal.innerHTML = `<form action="database.php" method="post" class="form-horizontal" role="form" id = 'update-classroom-form' enctype="multipart/form-data">


      <div class="form-group">
          <label for="name" class="col-sm-3 control-label">Class name</label>
          <div class="col-sm-9">
          <input type="text" class="form-control" name="new_classroom_name" id="classroom_name"  value =${classroom_name}>
          </div>
      </div> <!-- form-group // -->

      <div class="form-group">
          <label for="name" class="col-sm-3 control-label">Subject</label>
          <div class="col-sm-9">
          <input type="text" class="form-control" name ='subject' id="subject"  value =${subject}>
          </div>
      </div> <!-- form-group // -->
      <div class="form-group">
          <label for="name" class="col-sm-3 control-label">Room</label>
          <div class="col-sm-9">
          <input type="text" class="form-control" name = 'room_ID' id="room_ID"  value =${room_ID}>
          </div>
      </div> <!-- form-group // -->

      <div class="form-group">
          <label for="name" class="col-sm-3 control-label">Course length</label>
          <div class="col-sm-9">
          <input type="number" class="form-control" name ='course_length' id="course_length" value =${course_length}>
          </div>
      </div> <!-- form-group // -->

      

    
      <label for="img">Upload your classroom avatar (Optional):</label>
      <input type="file"  name="classroom_image"  accept="image/*">
      </form>`
      $('#classroom-modal').modal('show')

      $(document).ready(function(){

        $('#classroom-button').off('click').click(function(){
            
            // classroom_name = document.getElementById('classroom_name').value
            // subject = document.getElementById('subject').value
            // room_ID = document.getElementById('room_ID').value
            // course_length = document.getElementById('course_length').value
            // //console.log(classroom_name,subject, room_ID, course_length)
            

            form = document.getElementById('update-classroom-form')
            
            fd = new FormData(form);
            fd.append('classroom_name', classroom_name);
            fd.append('edit', true);
            
            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if(xhttp.readyState ==4 && xhttp.status ==200){
                    // get_classroom(teacher_email);
                    //console.log(xhttp.responseText)
                    receive = JSON.parse(xhttp.responseText)
                    if (receive['status'] == 'success'){
                    
                        get_classroom(teacher_email)
                    }
                    
                    
                }
            };
            xhttp.open("POST","database.php", true);
            // xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;");
            xhttp.send(fd);

        })

      })
      
 }

function delete_classroom(teacher_email, classroom_name){
    var modal = document.getElementById('confirm-delete-classroom')
    modal.innerHTML =`<div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Delete entire classroom</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p> Do you really want to delete <strong> ${classroom_name} </strong></p>
        
      </div>
      <div class="modal-footer">
      <button type = 'submit' id = 'delete-classroom-button' class="btn btn-outline-danger">Delete</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div>  
    </div>
  </div>`
    $('#confirm-delete-classroom').modal('show')
    $('#delete-classroom-button').off('click').click( function(){
            
            fd = new FormData();
            fd.append('d_classroom_name', classroom_name);
            fd.append('d_teacher_email', teacher_email);
            //console.log(fd)
            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if(xhttp.readyState ==4 && xhttp.status ==200){
                    // get_classroom(teacher_email);
                    //console.log(xhttp.responseText)
                    receive = JSON.parse(xhttp.responseText)
                    if (receive['status'] == 'success'){
                    
                        get_classroom(teacher_email)
                        $('#confirm-delete-classroom').modal('hide')
                    }
                    
                }
            };
            xhttp.open("POST","database.php", true);
            xhttp.send(fd);
    })
    
}


function add_classroom(teacher_email){
        
    document.getElementById('modal-label-classroom').innerHTML= `Create a classroom`;
    var modal = document.getElementById('input-field')
    modal.innerHTML = `<form action="database.php" method="post" class="form-horizontal" role="form" id = 'update-classroom-form' enctype="multipart/form-data">


    <div class="form-group">
        <label for="name" class="col-sm-3 control-label">Class name</label>
        <div class="col-sm-9">
        <input type="text" class="form-control" name="classroom_name" id="classroom_name" }>
        <p id = "add-alert" class = 'text-danger'> </p>
        </div>
    </div> <!-- form-group // -->

    <div class="form-group">
        <label for="name" class="col-sm-3 control-label">Subject</label>
        <div class="col-sm-9">
        <input type="text" class="form-control" name ='subject' id="subject" }>
        </div>
    </div> <!-- form-group // -->
    <div class="form-group">
        <label for="name" class="col-sm-3 control-label">Room</label>
        <div class="col-sm-9">
        <input type="text" class="form-control" name = 'room_ID' id="room_ID" }>
        </div>
    </div> <!-- form-group // -->

    <div class="form-group">
        <label for="name" class="col-sm-3 control-label">Course length</label>
        <div class="col-sm-9">
        <input type="number" class="form-control" name ='course_length' id="course_length"}>
        </div>
    </div> <!-- form-group // -->

    

  
    <label for="img">Upload your classroom avatar (Optional):</label>
    <input type="file"  name="classroom_image"  accept="image/*">
    </form>`
    $('#classroom-modal').modal('show')

    $(document).ready(function(){

      $('#classroom-button').off('click').click(function(){
          

          form = document.getElementById('update-classroom-form')
          
          fd = new FormData(form);
          fd.append('create_classroom', true);
          //console.log(fd)
          xhttp = new XMLHttpRequest();
          xhttp.onreadystatechange = function() {
              if(xhttp.readyState ==4 && xhttp.status ==200){
                  // get_classroom(teacher_email);
                  receive = JSON.parse(xhttp.responseText)
                  if(receive['status'] != 'success'){
                    let alert = document.getElementById('add-alert')
                    alert.innerHTML = receive['status']
                  }
                  else{   
                        get_classroom(teacher_email)
                        $('#classroom-modal').modal('hide')
                  }
                  
              }
          };
          xhttp.open("POST","database.php", true);
          // xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;");
          xhttp.send(fd);
      })

    })
}


function load_students(teacher_email, classroom_name){
         


    
    

          xhttp = new XMLHttpRequest();
          xhttp.onreadystatechange = function() {
              if(xhttp.readyState ==4 && xhttp.status ==200){
                  //console.log(xhttp.responseText);
                  let receive = JSON.parse(xhttp.responseText)
                      //put result in tbody
                      
                      let tbody = document.getElementById('student-list')
                      let check_list = document.getElementById('check-list')
                      tbody.innerHTML = '';
                      check_list.innerHTML = '';
                      let i = 0
                      if(receive!=null){
                          receive.forEach( student=>{
                            let row = document.createElement('tr')
                            row.className = 'student-row'
                            row.innerHTML =`<td>${i}</td><td>${student['first_name']}</td><td>${student['last_name']}</td><td>${student['student_ID']}</td><td>${student['email']}</td>
                            <td><button type="submit"  class="btn btn-secondary"  onclick = "view_activity('${student['student_ID']}','${student['first_name']}','${student['last_name']}', '${classroom_name}')">view absents</button></td>
                            <td><button type="submit"  class="btn btn-danger"  onclick = "send_delete_student_request('${student['student_ID']}','${classroom_name}','${student['first_name']}','${student['last_name']}','${teacher_email}')">Delete</button></td>`
                            tbody.appendChild(row)

                            let l_row = document.createElement('tr')
                            l_row.innerHTML =`<td>${i}</td><td>${student['first_name']}</td><td>${student['last_name']}</td><td>${student['student_ID']}</td>
                            <td class = 'align-middle'><input class="check-input" type="checkbox"  value="${student['student_ID']}"></td>`
                            check_list.appendChild(l_row)
                            i++
                          })
                          


                          //<td class = 'align-middle'><input class="check-input" type="checkbox"  value="<?=$row['student_ID']?>"></td>
                          
      
                      }
              }
          };
          xhttp.open("GET","database.php?stload_email="+encodeURIComponent(teacher_email)+"&stload_classroom_name="+encodeURIComponent(classroom_name),true);
          // xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;");
          xhttp.send();
}

function view_activity(student_ID, first_name, last_name, classroom_name){
    
    let tbody = document.getElementById('view-student')
    xhttp = new XMLHttpRequest();
          xhttp.onreadystatechange = function() {
              if(xhttp.readyState ==4 && xhttp.status ==200){
                  //console.log(xhttp.responseText);
                  let receive = JSON.parse(xhttp.responseText)
                      //put result in tbody
                      tbody.innerHTML = '';
                      let i = 0
                      if(receive!=null){
                          receive.forEach( lesson=>{
                            let row = document.createElement('tr')
                            row.innerHTML =`<td>${i}</td><td>${lesson['date']}</td><td>${lesson['shift']}</td>`
                            tbody.appendChild(row)
                            i++
                          })

                      }
              }
          };
          xhttp.open("GET","database.php?view_SID="+encodeURIComponent(student_ID)+"&view_classroom_name="+encodeURIComponent(classroom_name),true);
          // xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;");
          xhttp.send();
    $('#view-student-modal').modal('show')
}



function sign_up(){

    let form = document.getElementById('sign-up-form');      
          fd = new FormData(form);
          //console.log(fd)
          xhttp = new XMLHttpRequest();
          xhttp.onreadystatechange = function() {
              if(xhttp.readyState ==4 && xhttp.status ==200){
                  
                  receive = JSON.parse(xhttp.responseText)
                  if(receive != 'success'){
                  document.getElementById('sign-up-alert').innerHTML = receive;    
                  }
                  else{
                      $('#go-login').modal('show')
                  }
                  
              }
          };
          xhttp.open("POST","validate.php", true);
          // xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;");
          xhttp.send(fd);

}

// function check_status(){
//     //console.log('oke')
// }


function sign_in(){
    let form = document.getElementById('sign-in-form');      
          fd = new FormData(form);
          
          xhttp = new XMLHttpRequest();
          xhttp.onreadystatechange = function() {
              if(xhttp.readyState ==4 && xhttp.status ==200){
                //console.log(xhttp.responseText)
                  
                  receive = JSON.parse(xhttp.responseText)
                  if(receive == 'success'){
                   
                  window.location.href = 'index.php'; 
                  }
                  else{
                    document.getElementById('sign-in-alert').innerHTML = receive;  
                  }
                  
              }
          };
          xhttp.open("POST","validate.php", true);
          // xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;");
          xhttp.send(fd);
}


function delete_student(){
       
    
}