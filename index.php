
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="./style.css">

</head>
<body>

   <h1>Ajax request And upload file with progress bar</h1>
   
   <form id="myForm">

       <p class="success_message" style="color:green"></p>
   
       <div class="form-group">
           <label for="firstname">Firstname:</label>
           <input type="text" class="form-control" id="firstname" name="firstname" placeholder="enter your firstname">
           <span class="error_message error_firstname"></span>
       </div>


       <div class="form-group">
           <label for="lastname">Lastname:</label>
           <input type="text" class="form-control" id="lastname" name="lastname" placeholder="enter your lastname">
           <span class="error_message error_lastname"></span>
       </div>

       <div class="form-group">
           <label for="email">Email:</label>
          <input type="text" class="form-control" id="email" name="email" placeholder="enter your email">
          <span class="error_message error_email"></span>
       </div>

       <div class="form-group">
           <label for="password">Password:</label>
          <input type="text" class="form-control" id="password" name="Password" placeholder="enter your password">
          <span class="error_message error_password"></span>
       </div>


       <div class="form-group">
           <label for="file">File:</label>
           <input type="file" class="form-control" id="file" name="file">
           <span class="error_message error_file"></span>
                <div class="progress-bar" id="progressBar">
                    <div class="progress-bar-fill">
                        <span class="progress-bar-text">0%</span>
                    </div>
                </div>
       </div>

       <!-- <input type="submit" class="submit_btn" name="submit" value="submit"> -->
       <a href="javascript:void(0)" class="submit_btn">Submit</a>

   </form>

    


   <script>
     
         let myForm = document.getElementById('myForm'); 
         let btn = document.querySelector('.submit_btn');
         let firstname = document.getElementById('firstname');
         let lastname  = document.getElementById('lastname');
         let email     = document.getElementById('email');
         let password  = document.getElementById('password');
         let file      = document.getElementById('file');

         let success_message = document.querySelector('.success_message');
         const progressBarFill = document.querySelector('.progress-bar-fill');
         const progressBarText = document.querySelector('.progress-bar-text');


        ////// javascript part file information (you can also change only profile image)
        //  file.addEventListener('change',function(){
        //     console.log('changed');
        //     console.log(file.files.length);
        //     console.log(file.files[0]);
        //  })


         btn.addEventListener('click', function(e) {

            //// reset error messages each time you click submit button
            document.querySelectorAll('.error_message').forEach(item => {
                 item.innerHTML = '';
            });
             
                     var ajax = new XMLHttpRequest();

                     ajax.addEventListener('readystatechange', function(){
                     if(ajax.readyState == 4){
                        if(ajax.status == 200){

                            let data = JSON.parse(ajax.responseText);

                            if(data.error_log == true){
                                // console.log(data[0]);
                                for(key in data[0]){
                                    console.log(data[0][key]);

                                    let error_placeholder = document.querySelector('.error_' + key);
                                    error_placeholder.style.display = 'block';
                                    error_placeholder.innerHTML = data[0][key];

                                    // setTimeout(function(){
                                    //     error_placeholder.innerHTML = '';
                                    //     error_placeholder.style.display = 'none';
                                    // }, 3000);
                                    
                                }
                            }else{

                                success_message.style.display = 'block';
                                success_message.innerHTML = data.success;
                                myForm.reset();
                                
                            }
 

                        }else{
                              alert('an error occured');
                        }
                     }
                   });


            //progress bar process
                ajax.upload.addEventListener("progress", e => {
                  const percent = e.lengthComputable ? (e.loaded / e.total) * 100 : 0;

                  progressBarFill.style.width = percent.toFixed(2) + "%";
                  progressBarText.textContent = percent.toFixed(2) + "%";
             });




                const data = {
                     firstname: firstname.value,
                     lastname: lastname.value,
                     email: email.value,
                     password: password.value,
                     action:'add'
                  }

                  var form = new FormData();

                  for(key in data){
                    form.append(key,data[key]);
                  }

                  if(file.files.length > 0){
                     form.append('file',file.files[0]);
                  }
                 
                  ajax.open('POST','api.php',true);
                  ajax.send(form);

         });


   </script>


    
</body>
</html>