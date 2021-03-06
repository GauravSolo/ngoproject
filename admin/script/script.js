
var update = document.querySelector('button.submitupdate');

//update data through ajax
update.addEventListener('click',(e)=>{
    
    e.preventDefault();
	document.querySelector(".submitupdate").innerHTML = `
          <div class="spinner-border" style="width:24px;height:24px;" role="status">
          <span class="visually-hidden" >Loading...</span>
          </div>
          <div class="ms-2" style="font-size:20px;">Saving...</div>
          `;
    // var uimage = document.querySelector("input[name='profilepic']").value;
    var uname = document.querySelector("input[name='uname']").value;
    var umail = document.querySelector("input[name='mail']").value;
    var upass = document.querySelector("input[name='password']").value;
    var id = document.querySelector("input[name='mail']").getAttribute("data-ctd");
    var sm = document.getElementById("sm");

    if(!uname || !umail || !upass)
    {
        sm.innerHTML="<div class='alert alert-warning' role='alert'>Please fill all input!</div>";
        return;
    }


    const xhr = new XMLHttpRequest();

    xhr.open('POST','update.php',true);
    // xhr.setRequestHeader('Content-Type','multipart/formdata');
    xhr.responseType = 'json';
    xhr.onload = ()=>{
        if(xhr.status === 200)
        {
            var res = xhr.response;

            if(res.int == '1')
            {	
                sm.innerHTML="<div class='alert alert-success' role='alert'>Your data has been successfully updated!</div>";
                setTimeout(()=>{sm.innerHTML=""},1500);
               document.querySelector(".submitupdate").innerHTML="Save Changes";
          
                if(res.same === '1'){
              
                    if(res.name !== '')
                    {
                        document.getElementById('pic').src = "../upload/"+res.name;
                        document.getElementById('chimg').src = "../upload/"+res.name;
                    }
                    if(res.username != '')
                    {
                        document.getElementById('usr').innerText = res.username;
                    }

                    if(res.mail != '')
                    {
                        document.getElementById('usrmail').innerText = res.mail;
                    }
                }else
                {
                    document.getElementById('chimg').src = "../upload/"+res.name;
                }

            }
            else{
                sm.innerHTML="<div class='alert alert-warning' role='alert'>Coulnt update data!</div>";
                setTimeout(()=>{sm.innerHTML=""},1500);
            }
        }
        else{
            sm.innerHTML="<div class='alert alert-danger' role='alert'>Something went wrong!</div>";
            setTimeout(()=>{sm.innerHTML=""},1500);
        }
    };
    const form = document.getElementById('form');
    const formdata = new FormData(form);
    formdata.append('ctd',id);

    xhr.send(formdata);

});

var updatevalues = document.querySelectorAll("input[name='uname'],input[name='password'],input[name='mail'],input[name='city'],input[name='money']");

var editbutton = document.querySelectorAll('.userstbody .edit');

editbutton.forEach((element)=> {
    element.addEventListener('click',()=>{
        var id = element.getAttribute('data-id');
        var values = document.querySelectorAll(`.userstbody td[data-id='${id}']:not(.edit,.delete)`);
        var index = 0;
         for ( index = 0; index < updatevalues.length; index++) {
            updatevalues[index].value = values[index].innerText;
         }
         document.getElementById('chimg').src  = '../upload/'+values[index].innerText;
         document.getElementById('home-tab').classList.remove('active');
         document.getElementById('home-tab').setAttribute('aria-selected','false');
         document.getElementById('update-tab').setAttribute('aria-selected','true');
         document.getElementById('update-tab').classList.add('active');

         document.getElementById('home').classList.remove('active','show');
         document.getElementById('update').classList.add('active','show');

         document.querySelector("input[name='mail']").setAttribute('data-ctd',`${id}`);


    });
    
});

var deletebutton = document.querySelectorAll('.userstbody .delete');

deletebutton.forEach((element)=> {
    element.addEventListener('click',()=>{
        var id = element.getAttribute('data-id');

        const xhr = new XMLHttpRequest();

        xhr.open('POST','delete.php',true);
        // xhr.setRequestHeader('Content-Type','multipart/formdata');
        xhr.responseType = 'json';
        xhr.onload = ()=>{
            if(xhr.status === 200)
            {
                var res = xhr.response;
                // console.log(res);

            }
        };
    
        const formdata = new FormData();
        formdata.append('ctd',id);

        xhr.send(formdata);
        });
    
});






document.querySelectorAll("#videotbody .edit").forEach((element)=>{
    element.onclick = (e)=>{
        var  dataid = e.target.getAttribute('data-id');

        var [videoid,viddo] = [...document.querySelectorAll(`#videotbody td[data-id='${dataid}']:not(.edit,.delete)`)];
    
        [document.querySelector("input[name='videoid']").value,document.querySelector("input[name='editvideo']").value] = [videoid.innerText,viddo.innerText];
        
    }

});
document.querySelectorAll("#videotbody .delete").forEach((element)=>{
    element.onclick = (e)=>{
        var  dataid = e.target.getAttribute('data-id');

        const xhr = new XMLHttpRequest();
        xhr.open('POST','deletevideo.php',true);
        // xhr.setRequestHeader('Content-Type','multipart/formdata');
        xhr.responseType = 'json';
        xhr.onload = ()=>{
            if(xhr.status === 200)
            {
                var res = xhr.response;
                // console.log(res);

            }
        };
    
        const formdata = new FormData();
        formdata.append('ctd',dataid);

        xhr.send(formdata);
    }

});




document.querySelectorAll("#carouseltbody .edit").forEach((element)=>{
    element.onclick = (e)=>{
        var  dataid = e.target.getAttribute('data-id');
        
        var [videoid,viddo] = [...document.querySelectorAll(`#carouseltbody td[data-id='${dataid}']:not(.edit,.delete)`)];
    
        [document.querySelector("input[name='carouselid']").value,document.querySelector("input[name='editcarousel']").value] = [videoid.innerText,viddo.innerText];
        
    }

});
document.querySelectorAll("#carouseltbody .delete").forEach((element)=>{
    element.onclick = (e)=>{
        var  dataid = e.target.getAttribute('data-id');

        const xhr = new XMLHttpRequest();
        xhr.open('POST','deletecarousel.php',true);
        // xhr.setRequestHeader('Content-Type','multipart/formdata');
        xhr.responseType = 'json';
        xhr.onload = ()=>{
            if(xhr.status === 200)
            {
                var res = xhr.response;
                // console.log(res);

            }
        };
    
        const formdata = new FormData();
        formdata.append('ctd',dataid);

        xhr.send(formdata);
    }

});


document.querySelector('#sendbutton').onclick = ()=>{
    var sendinput = document.querySelector('#sendinput');
    var text = sendinput.value;

    if(text == "")
        return;

        const xhr = new XMLHttpRequest();
        xhr.open('POST','talk.php',true);
        // xhr.setRequestHeader('Content-Type','multipart/formdata');
        xhr.responseType = 'json';
        xhr.onload = ()=>{
            if(xhr.status === 200)
            {
                var res = xhr.response;
                // console.log(res);

            }
        };
    
        const formdata = new FormData();
        formdata.append('text',text);
        xhr.send(formdata);
        sendinput.value = "";

}

// Get the input field
var input = document.getElementById("sendinput");

// Execute a function when the user releases a key on the keyboard
input.addEventListener("keyup", function(event) {
  // Number 13 is the "Enter" key on the keyboard
  if (event.key === 'Enter') {
    // Cancel the default action, if needed
    event.preventDefault();
    // Trigger the button element with a click
    document.getElementById("sendbutton").click();
  }
});
var mytalk;



function fetchtalk(){
        var tpost = document.querySelectorAll("#chatbox > div").length;
        console.log(tpost);
    
        const xhr = new XMLHttpRequest();
        xhr.open('POST','retrievetalk.php',true);
        // xhr.setRequestHeader('Content-Type','multipart/formdata');
        xhr.responseType = 'json';
        xhr.onload = ()=>{
            if(xhr.status === 200)
            {
                var res = xhr.response;
                // console.log(res,xhr.responseType);
                
                document.querySelector("#chatbox").innerHTML = res.res;
                deleteFunction();
    
                if(res.bottom === '1')
                {
                    // document.querySelector("#chatbox").scrollTo(0,document.body.scrollHeight);
                    scrollSmoothToBottom('chatbox');
                    function scrollSmoothToBottom (id) {
                        var div = document.getElementById(id);
                        $('#' + id).animate({
                           scrollTop: div.scrollHeight - div.clientHeight
                        }, 500);
                     }
                    // console.log("ok");
                }
            }
        };
        var formdata = new FormData();
        formdata.append("tpost",tpost);
        xhr.send(formdata);

}

function starttalk(){
     mytalk =  setInterval(fetchtalk,2500);
                console.log(mytalk);
}
fetchtalk();
starttalk();


document.querySelectorAll('#myTab li').forEach((element)=>{
   element.addEventListener('click',()=>{
       var tab = document.querySelector('#contact-tab');
       if(tab.getAttribute('aria-selected') === 'true')
       {
           starttalk();
       }else if(tab.getAttribute('aria-selected') === 'false'){
           clearInterval(mytalk);
       }
   }) ;
});




    function deleteFunction(){
        document.querySelectorAll('#chatbox button.delete').forEach((element)=>{
            element.addEventListener("click",()=>{
            console.log("clicked");
            var msg_id = element.getAttribute('data-id');
            
            const xhr = new XMLHttpRequest();
            xhr.open('POST','deletetalk.php',true);
            // xhr.setRequestHeader('Content-Type','multipart/formdata');
            xhr.responseType = 'json';
            xhr.onload = ()=>{
                    if(xhr.status === 200)
                    {
                            var res = xhr.response;
                            // console.log(res);
                    
                    }
                    };
                    
                    const formdata = new FormData();
                    formdata.append('ctd',msg_id);
                    xhr.send(formdata);
                    
                });
        });
    }

        






var confetti = new ConfettiGenerator();

function startcanva(){
    var canva = document.querySelector('#confetti-holder');
    canva.classList.remove('canva');
    var canvatext = document.querySelector('#canvatext');
    canvatext.innerHTML = "<div class='alert alert-success' style='font-size: 20px;height: 100%;display: flex;align-items: center;justify-content: center; margin-top:10px;border-radius: 15px;' role='alert'>You've successfully donated! You got a new badge!</div>";
    confetti.render();
    //
    setTimeout(()=>{confetti.clear();canva.classList.add('canva');},5000);
    

}


// document.querySelector('#imgicon').addEventListener('click',popimg());
// document.querySelector('#chimg').addEventListener('click',popimg());

function popimg(){
    console.log("cloicked");
    document.querySelector('#fileinput').click();
}






                