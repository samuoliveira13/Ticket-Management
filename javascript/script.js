let editTicketButton = document.getElementById("edit_ticket");
let postCommentForm = document.getElementById("post_comment");
let postFaqForm = document.getElementById("post_faq");
let assignButton = document.getElementById("assignButton");

function sendRequest(method, url, data, successCallback, errorCallback) {
  let xhr = new XMLHttpRequest();
  xhr.open(method, url, true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4) {
      if (xhr.status === 200) {
        if (typeof successCallback === "function") {
          successCallback(xhr.responseText);
         
        }
      } else {
        if (typeof errorCallback === "function") {
          errorCallback(xhr.status);
        }
      }
    }
  };
  xhr.send(data);
}

editTicketButton.addEventListener("click", function(event) {
  event.stopPropagation();

  console.log("clicaste");  
  
  editTicketButton.style.display = "none";
  status_select_display();
 
  department_select_display();

  hashtags_select_display();
  


});

postCommentForm.addEventListener("submit",function(event){
    event.stopPropagation();
    event.preventDefault();//previne o form html de fazer post

    let post_comment_text = document.getElementById("post_comment_text").value;
    let comment_user_id = document.getElementById("comment_user_id").value;
    let ticket_id = document.querySelector("#ticket_info li:nth-child(1) span:last-child").innerHTML;

    sendRequest("POST","../actions/action.postcomment.php",
    "&comment_text=" + encodeURIComponent(post_comment_text) + 
    "&user_id=" + comment_user_id + 
    "&ticket_id=" + ticket_id,
    function(responseText){
            
  
        let comment_object = JSON.parse(responseText);
          
        let post_comment_div =document.getElementById("post_comment");

        let comment=document.createElement('div');
        comment.id='comment';


        comment.innerHTML ='<div id="comment">'+
                             ' <div id="user_info"> '+
                                  '<img id="user_image"src="/images/userimage.jpg" alt="user image">'+
                                  '<p id="username">'+ comment_object[1] +'</p>'+
                                  '<p id="date">'+ comment_object[2] +'</p>'+
                              '</div>'+
                              '<p>'+ comment_object[0] + '</p>' +
                            '</div>';
  
         
        post_comment_div.insertAdjacentHTML('afterend',comment.innerHTML);
          
          let post_comment=document.getElementById("post_comment_text");
           post_comment.value='';


      });

});

function submitTicketChanges() {

   addTicketChanges();

    let status = document.getElementById("status").value;
    let department = document.getElementById("department").value;

    sendRequest(
      "POST",
      "../classes/class.ticket.php",
      "action=UpdateTicket" +
        "&ticket_id=" +
        document.querySelector("#ticket_info li:nth-child(1) span:last-child").innerHTML +
        "&status=" +
        encodeURIComponent(status) +
        "&department_name=" +
        encodeURIComponent(department),
      function(responseText) {
        
     
      }
    )

    let statusSpan = document.querySelector("#ticket_info li:nth-child(4) span:last-child");
    statusSpan.textContent = status;
    let departmentSpan = document.querySelector("#ticket_info li:nth-child(6) span:last-child");
    departmentSpan.textContent=department;

    editTicketButton.style.display="block";
    
    let hashtags_input = document.getElementById("hashtags_input");
    hashtags_input.style.display="none";

    let hashtagsSpans = document.querySelectorAll("#ticket_info li:nth-child(7) span.info");
    hashtagsSpans.forEach(hashtag => {
      hashtag.classList.remove("removable");
      
      hashtag.removeEventListener("click",function(){
        remove_Ticket_Hashtag(hashtag);
      });
      
    });
}

function hashtags_select_display(){

    let lasthashtagSpan = document.querySelector("#ticket_info li:nth-child(7) span");
    
    let hashtagsSpans = document.querySelectorAll("#ticket_info li:nth-child(7) span.info");
    if(hashtagsSpans!=null){
        hashtagsSpans.forEach(hashtag => {
            hashtag.classList.add("removable");
            

            hashtag.addEventListener("click",function(){
              remove_Ticket_Hashtag(hashtag);
            });
            
        });
    }
    
    const input = document.createElement('input');
    input.type = 'text';
    input.id = 'hashtags_input';
    input.name = 'hashtags';
    input.placeholder = 'Add hashtags...';
    input.setAttribute('list', 'hashtags-list');
    lasthashtagSpan.insertAdjacentElement('afterend', input);

    lasthashtagSpan.insertAdjacentHTML('afterend','<datalist id="hashtags-list">'+'</datalist>');
    
    const hashtagsInput = document.getElementById("hashtags_input");
    const hashtagsList = document.getElementById("hashtags-list");
  
   let option;

   hashtagsInput.addEventListener("input", function() {
    const value = this.value;
    sendRequest("GET", "../api/hashtags.php", null, function(responseText){

      let hashtags = JSON.parse(responseText);
      hashtagsList.innerHTML = "";
      hashtags.forEach(hashtag=>{
        
        option = document.createElement("option");
        option.value = hashtag.name;
       
        option.id=hashtag.hashtag_id;
       
        hashtagsList.appendChild(option);
      });


    });
  });

  hashtagsInput.addEventListener("change",function(){
    const hashtag_to_add = hashtagsInput.value;

    const hashtag_id = hashtagsInput.id;
  
    hashtagsInput.value = "";
    
    const newDiv = document.createElement("span");
    newDiv.classList.add("hashtag");
    newDiv.classList.add("info");
    newDiv.textContent = hashtag_to_add;
    let spanbr=document.querySelector("#ticket_info li:nth-child(7)"); 
    spanbr.appendChild(newDiv);
   
    sendRequest(
      "POST",
      "/classes/class.ticket.php",
      "action=Hashtag_exists" +
      "&hashtag_name=" +
      hashtag_to_add,
      function(responseText) {
        console.log("response text: "+responseText);
        
        
        
        if(responseText=="truetrue"){
          console.log("ticket exists");
          sendRequest(
              "POST",
              "/classes/class.ticket.php",
              "action=AddTicketHashtag" +
              "&ticket_id=" +
              document.querySelector("#ticket_info li:nth-child(1) span:last-child").innerHTML +
              "&hashtag_name=" +
              hashtag_to_add,
              function(responseText) {
                  console.log(responseText); 
              }
          );
      
        }

        else{
          console.log("ticket doesnt exist");
          add_new_Hashtag(hashtag_to_add);

          sendRequest(
            "POST",
            "/classes/class.ticket.php",
            "action=AddTicketHashtag" +
            "&ticket_id=" +document.querySelector("#ticket_info li:nth-child(1) span:last-child").innerHTML +
            "&hashtag_name=" +hashtag_to_add,
            function(responseText) {
                console.log(responseText); 
            }
        );
    
        }
        
      }
      
    );

    submitTicketChanges();
});


  


}

function status_select_display(){
   let statusSpan = document.querySelector("#ticket_info li:nth-child(4) span:last-child");
   let previousStatus = statusSpan.textContent;
   statusSpan.textContent = "";
   let select_status = document.createElement("select");
   select_status.name = "status";
   select_status.id = "status";
   statusSpan.appendChild(select_status);
   
   sendRequest("GET", "../api/status.php", null, function(responseText) {
     let status = JSON.parse(responseText);
 
     for (let i = 0; i < status.length; i++) {
 
       let option = document.createElement("option");
 
       console.log("previous Status: " + previousStatus + " == status[" + i + "]: " + (previousStatus == status[i].status));
 
 
 
       option.innerHTML ='<option value=' + status[i].status +" >" +status[i].status +" </option>";
       
       if (previousStatus == status[i].status) {
         option.setAttribute("selected", "selected");
       }
 
       select_status.appendChild(option);
     }
     statusSpan.appendChild(select_status);
 
     let statusSelect = document.getElementById("status");
     statusSelect.addEventListener("change", function() {
       submitTicketChanges();
     });
   });
}

function department_select_display(){
    let departmentSpan = document.querySelector("#ticket_info li:nth-child(6) span:last-child");
    let previousDepartment = departmentSpan.textContent;
    departmentSpan.innerHTML = "";
    let select = document.createElement("select");
    select.name = "department";
    select.id = "department";
    departmentSpan.appendChild(select);
  
    sendRequest("GET", "../api/departments.php", null, function(responseText) {
      let departments = JSON.parse(responseText);
     
      for (let i = 0; i < departments.length; i++) {
        let option = document.createElement("option");
  
        option.innerHTML = '<option value=' +departments[i].department_name +">" +departments[i].department_name +" </option>";
  
        if (previousDepartment == departments[i].department_name) {
          option.setAttribute("selected", "selected");
        }
  
  
        select.appendChild(option);
      }
      departmentSpan.appendChild(select);
  
      let departmentSelect = document.getElementById("department");
  
      departmentSelect.addEventListener("change", function() {
        submitTicketChanges();
      });
    });
  
}

function remove_Ticket_Hashtag(hashtag){


            
    sendRequest("POST", "../classes/class.ticket.php","action=RemoveTicketHashtag" +
    "&ticket_id=" +  document.querySelector("#ticket_info li:nth-child(1) span:last-child").innerHTML   +
    "&hashtag_id=" +
    hashtag.id , function(responseText){
      
    hashtag.classList.add("remove");
    });
    


}

function add_new_Hashtag(hashtag){

  sendRequest("POST", "../classes/class.ticket.php","action=add_new_Hashtag" +
  "&hashtag_name=" +  hashtag,
   function(responseText){
    
 
  });
  
}


postFaqForm.addEventListener("submit", function(event) {
  event.preventDefault();
  console.log("postfaqform js!!!!");
  let post_faq_question = document.getElementById("post_faq_question").value;
  let post_faq_answer = document.getElementById("post_faq_answer").value;

  console.log("post_faq_question no js:"+post_faq_question);
  console.log("post_faq_answer no js:"+post_faq_answer);
  
    sendRequest("POST","../actions/action.postfaq.php",
    "&faq_question="+post_faq_question + 
    "&faq_answer="+post_faq_answer ,
    function(responseText){

      console.log("response text"+responseText);
    
    });

});

function addTicketChanges(){
      
  sendRequest(
    "POST",
    "../classes/class.ticket.php",
    "action=getTicketforTicketChanges" +
      "&ticket_id=" + parseInt(document.querySelector("#ticket_info li:nth-child(1) span:last-child").innerHTML),
      
      

    function(responseText) {
      console.log("response text: " + JSON.stringify(responseText));
      let ticket=JSON.parse(responseText);
      console.log("ticket department id in js "+ticket.department_id)
  
   let currentTime = new Date();
      
      sendRequest(
        "POST",
        "../classes/class.ticket.php",
        "action=addTicketChanges" +
          "&ticket_id=" + ticket.ticket_id +
          "&change_date=" + currentTime +
          "&title=" + ticket.title +
          "&description=" + ticket.description +
          "&date=" + ticket.date +
          "&status=" + ticket.status +
          "&priority=" + ticket.priority +
          "&assigned_to=" + ticket.assigned_to +
          "&department_id=" + ticket.department_id,
      )
    }
  )

  
}

assignButton.addEventListener("click",function(event){
  event.stopPropagation();
  addTicketChanges();
});
