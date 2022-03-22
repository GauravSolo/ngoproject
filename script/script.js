var swiper = new Swiper(".mySwiper", {
    slidesPerView:1.2,
    spaceBetween:0,
    breakpoints:{
    480:{
      slidesPerView: 2,
      spaceBetween: 10,
    },
    640:{
      slidesPerView: 3,
      spaceBetween:30,
    }
  },
  freeMode: true,
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },

    });

    function getoffsetTop(carditem){
      let offsettop = 0;
      while(carditem){
       offsettop += carditem.offsetTop;
       carditem = carditem.offsetParent;
      }
      return offsettop;
    }
    var card = document.querySelector("#ourteam");
    var carditems = document.querySelectorAll(".carditem");
    window.onscroll = () =>{
     carditems.forEach((carditem)=>{
      //  console.log(window.scrollY,getoffsetTop(carditem));
       if(getoffsetTop(carditem) - 253 - (window.innerHeight*3)/4 < window.scrollY)
       {
         carditem.classList.add('animcard');
         carditem.style="top:0px";
        }else{
            carditem.classList.remove('animcard');
            carditem.style= 'top:150px';
        }
      });
    }

  var scrollableheight = document.querySelector('body').scrollHeight;
 document.querySelector('.outerdiv').style = `height:${scrollableheight}px;`;


 var [signupmodal, loginmodal, forgotmodal] = [...document.querySelectorAll('.outerdiv')];
 var [login, signup] = [...document.querySelectorAll('.logbutton')];

 let forgotbtn = document.querySelector('.forgotbtn');
 let forgotlogin = document.querySelector('.forgotlogin');
 
 forgotbtn.addEventListener('click', ()=>{
  loginmodal.classList.remove('modal');
  forgotmodal.classList.add('modal');
})
 forgotlogin.addEventListener('click', ()=>{
  loginmodal.classList.add('modal');
  forgotmodal.classList.remove('modal');
})
 login.addEventListener('click',()=>{

    loginmodal.classList.add('modal');
    signupmodal.classList.remove('modal');
 });

 signup.addEventListener('click',()=>{

    loginmodal.classList.remove('modal');
    signupmodal.classList.add('modal');
 });


 document.getElementById('sign').onclick = ()=>{
   signupmodal.classList.add('modal');
 };

 document.querySelectorAll('.btn-close').forEach((element)=>{

   element.addEventListener('click',()=>{

     element.parentElement.parentElement.parentElement.parentElement.classList.remove('modal');
   });
 });
var i = 0;
 document.querySelectorAll('.eyes i').forEach((element)=>{
   element.addEventListener('click',()=>{
     document.querySelectorAll('.eyes i')[0].classList.toggle('visible');
     document.querySelectorAll('.eyes i')[1].classList.toggle('visible');
     document.querySelectorAll('.eyes i')[2].classList.toggle('visible');
     document.querySelectorAll('.eyes i')[3].classList.toggle('visible');
    
     if(i > 1)
        i = 0;
     if(i == 0)
     {
          document.getElementById('inputuserpassword').setAttribute('type','text');
          document.getElementById('inputpassword').setAttribute('type','text');
     }else{ 
          document.getElementById('inputuserpassword').setAttribute('type','password');       
          document.getElementById('inputpassword').setAttribute('type','password');
     }
     i++;
     
     
     
    
   });
 });




var sm = document.getElementById('sm');
var frame = document.querySelector('.src');

    document.querySelector("button[name='signupsubmit']").onclick = (e)=>{
          // frame.classList.add('frame');
          e.preventDefault();
           document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
      document.querySelector("button[name='signupsubmit']").innerHTML = `
          <div class="spinner-border" style="width:24px;height:24px;" role="status">
          <span class="visually-hidden" >Loading...</span>
          </div>
          <div class="ms-3" style="font-size:20px;">Loading...</div>
          `;
          // setTimeout(()=>{frame.classList.remove('frame')},2000);
          
          var uname = document.querySelector("input[name='inputusername']").value;
          var umail = document.querySelector("input[name='inputemail']").value;
          var upass = document.querySelector("input[name='inputpassword']").value;
          if(!umail || !upass || !uname)
          {
              sm.innerHTML="<div class='alert alert-warning m-0' role='alert'>Please fill require input!</div>";
              setTimeout(()=>{sm.innerHTML=""},1500);

            return;
          }

          const xhr = new XMLHttpRequest();

          xhr.open('POST','signup.php',true);
          // xhr.setRequestHeader('Content-Type','multipart/formdata');
          xhr.responseType = 'json';
          xhr.onload = ()=>{
              if(xhr.status === 200)
              {
                  var res = xhr.response;
                  // console.log(res);
                  sm.innerHTML = res.res;
                  setTimeout(()=>{sm.innerHTML=""},5000);
  				  document.querySelector("button[name='signupsubmit']").innerHTML="Submit";
                  document.querySelector("input[name='inputusername']").value = "";
                  document.querySelector("input[name='inputemail']").value = "";
                  document.querySelector("input[name='inputpassword']").value = "";
              }
          };
          
          const form = document.getElementById('ff');
          const formdata = new FormData(form);
         
          xhr.send(formdata);

    }          

    var lm = document.getElementById('lm');
      document.querySelector("button[name='loginsubmit']").onclick = (e)=>{
                    e.preventDefault();
        		document.querySelector("button[name='loginsubmit']").innerHTML = `
                       <div class="spinner-border" style="width:24px;height:24px;" role="status">
                      <span class="visually-hidden" >Loading...</span>
                      </div>
                      <div class="ms-3" style="font-size:20px;">Loading...</div>
                      `;
                  var umail = document.querySelector("input[name='inputnameemail']").value;
                  var upass = document.querySelector("input[name='inputuserpassword']").value;
                  if(!umail || !upass)
                  {
                      lm.innerHTML="<div class='alert alert-warning m-0' role='alert'>Please fill all input!</div>";
                      setTimeout(()=>{lm.innerHTML=""},1500);
                  }

                      const xhr = new XMLHttpRequest();

                      xhr.open('POST','login.php',true);
                      // xhr.setRequestHeader('Content-Type','multipart/formdata');
                      xhr.responseType = 'json';
                      xhr.onload = ()=>{
                          if(xhr.status === 200)
                          {
                              var res = xhr.response;
                              lm.innerHTML = res.res;
                              setTimeout(()=>{
                                lm.innerHTML=""
                                if(res.ok == '1')
                                  window.location.href = 'admin/index.php';
                              },1000);
                            

                          }
                      };
                      
                      const form = document.getElementById('ll');
                      const formdata = new FormData(form);
                      xhr.send(formdata);

    }



    
      document.querySelector('#targetparent').onclick = ()=>{
        var money = prompt("Enter amount");
        document.querySelector('#target').innerText = money;
        setTimeout(percentage(),1000);
      };

      (function percentage(){
        var raised = parseInt(document.querySelector('.percentage').innerText);
        var target = parseInt(document.querySelector('#target').innerText);
        document.querySelector('.progress-bar').style = `width:`+((raised*100)/target)+`%;`;
      })();

    



      var myCarousel = document.querySelector('#myCarousel');
      var carousel = new bootstrap.Carousel(myCarousel, {
        interval: 1000,
        wrap: true
      });


      let scrollToBottom = document.querySelector("#about");
      let pageBottom = document.querySelector("#footabout");

      scrollToBottom.addEventListener("click", function() {
        pageBottom.scrollIntoView()
      });

console.log('clicked');
let fp = document.querySelector('#fp');
let forgototp = document.querySelector('#sendotp');
forgototp.addEventListener('click',(e)=>{
  e.preventDefault();
  console.log('clicked');

  
        var umail = document.querySelector("input[name='forgotemail']").value;

        if(umail === '')
        {
            fp.innerHTML="<div class='alert alert-warning m-0' role='alert'>Please Enter Email!</div>";
            setTimeout(()=>{fp.innerHTML=""},1500);
            return;
        }
        forgototp.innerHTML = `
        <div class="spinner-border" style="width:24px;height:24px; white-space:nowrap;" role="status">
       <span class="visually-hidden" >Loading...</span>
       </div>
       <div class="ms-3" style="font-size:20px;">Loading...</div>
       `;
            const xhr = new XMLHttpRequest();

            xhr.open('POST','forgotpassword.php',true);
            xhr.responseType = 'json';
            xhr.onload = ()=>{
                if(xhr.status === 200)
                {
                    var res = xhr.response;
                    fp.innerHTML = res.res;
                    setTimeout(()=>{
                      fp.innerHTML=""
                      // if(res.ok == '1')
                      //   window.location.href = 'admin/index.php';
                    },1000);

                    if(res.error == '0'){
                      console.log(res.error, res.res);
                    }else if(res.error == '1'){
                      console.log(res.error, res.res);
                    }else if(res.error == '2'){
                      console.log(res.error, res.res);
                    }
                    forgototp.innerHTML = `Send OTP`;
                }
            };
            
            // const form = document.getElementById('fpwd');
            const formdata = new FormData();
            formdata.append('forgotemail',umail);
            xhr.send(formdata);
});