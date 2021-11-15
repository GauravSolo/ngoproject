
var confetti = new ConfettiGenerator();

// confetti.render();
// //
// setTimeout(()=>confetti.clear(),5000);



$(document).ready(function() {
    $('.minus').click(function () {
      var $input = $(this).parent().find('input');
      var count = parseInt($input.val()) - 10;
      count = count < 10 ? 10 : count;
      $input.val(count);
      $input.change();
      return false;
    });
    $('.plus').click(function () {
      var $input = $(this).parent().find('input');
      $input.val(parseInt($input.val()) + 10);
      $input.change();
      return false;
    });
  });


document.getElementById('rzp-button1').onclick = function(e){
    
    e.preventDefault();
    var name = document.querySelector("input[name='username']").value;
    var email = document.querySelector("#email").value;
    var phone = document.querySelector("#CUST_ID").value;
    var amount = document.querySelector("input[title='TXN_AMOUNT']").value;
    var ss = document.querySelector("input[name='ss']").value;

    function validateEmail(email) { //Validates the email address
        var emailRegex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return emailRegex.test(email);
    }
    
    function validatePhone(phone) { //Validates the phone number
        var phoneRegex = /^(\+91-|\+91|0)?\d{10}$/; // Change this regex based on requirement
        return phoneRegex.test(phone);
    }
    
    if(!validateEmail(email) || !validatePhone(phone))
    {
      document.querySelector("#sm").innerHTML = "<div class='alert alert-warning mt-4 text-center p-0' style='font-size:20px;background-color:yellow;' role='alert'>Please enter valid email and phone!</div>";
      setTimeout(()=>{document.querySelector("#sm").innerHTML = "";},2000);
      return false;
    }

    var options = {
      "key": "rzp_test_XbZeljHYPVwHVJ", // Enter the Key ID generated from the Dashboard
      "amount": amount*100, // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
      "currency": "INR",
      "name": "Freengo",
      "description": "Test Transaction",
      "image": "https://freengo.ml/images/ngo.png",
      "handler": function (response){
        
          console.log(response);
          
          const xhr = new XMLHttpRequest();

          xhr.open('POST','proccess.php',true);
          // xhr.setRequestHeader('Content-Type','multipart/formdata');
          // xhr.responseType = 'json';
          xhr.onload = ()=>{
              if(xhr.status === 200)
              {
                if(ss == 'no')
                {
                    var sm = document.querySelector('#sm');
                    var canva = document.querySelector('#confetti-holder')
                    canva.classList.remove('canva');
                    sm.innerHTML = "<div class='alert alert-success' style='font-size: 20px;height: 100%;display: flex;align-items: center;justify-content: center;border-radius: 15px;' role='alert'>You've successfully donated! Check status in forum panel by signup!</div>";
                    confetti.render();

                    setTimeout(()=>{confetti.clear();canva.classList.add('canva');},5000);
                    
                }else if(ss == 'yes')
                {
                  window.location.href = "http://localhost/ngoajax/admin/index.php?status=1";
                }

              }
          };
          
          const formdata = new FormData();
          formdata.append('payid',response.razorpay_payment_id);
          formdata.append('name',name);
          formdata.append('email',email);
          formdata.append('phone',phone);
          formdata.append('amount',amount);
          formdata.append('ss',ss);
          xhr.send(formdata);

      },
      "prefill": {
          "name": name,
          "email": email,
          "contact": phone
      },
      "notes": {
          "address": "Razorpay Corporate Office"
      },
      "theme": {
          "color": "#3399cc"
      }
  };
  
  var rzp1 = new Razorpay(options);
  rzp1.on('payment.failed', function (response){
          alert(response.error.code);
          alert(response.error.description);
          alert(response.error.source);
          alert(response.error.step);
          alert(response.error.reason);
          alert(response.error.metadata.order_id);
          alert(response.error.metadata.payment_id);
  });
  rzp1.open();
}