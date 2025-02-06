<?php
session_start();
if(!isset($_SESSION['id'])){
  header('Location: adminlogin.html');
}
else{
  include './connect.php';
  $id = $_SESSION['id'];
  $password = $_SESSION['password'];
  //queries
  $q1 = mysqli_query($c, "select * from user where email = '$id'");
  $qr1 = mysqli_fetch_assoc($q1);
  $q2 = mysqli_query($c, "select * from message left join user on message.userID = user.userID order by msgID desc");
  $qr2 = mysqli_fetch_All($q2);
  $q3 =mysqli_query($c, "select * from document left join user on document.userID = user.userID ");
  $qr3 = mysqli_fetch_All($q3);
  $q4 =mysqli_query($c, "select * from user");
  $qr4 = mysqli_fetch_All($q4);
  $q5 =mysqli_query($c, "select * from notification order by notID desc");
  $q5e =mysqli_query($c, "select * from notification where status = 0 order by notID desc ");
  $fig = mysqli_num_rows($q5e);

  $qr5 = mysqli_fetch_All($q5);
  $q6 =mysqli_query($c, "select * from user where role = 1 and status = 0");
  $qr6 = mysqli_num_rows($q6);
  $qd6 = mysqli_fetch_all($q6);
  $q7 =mysqli_query($c, "select * from user where role = 0 and status = 0");
  $qr7 =mysqli_num_rows($q7);
  $qd7 = mysqli_fetch_all($q7);
  $qr8 = mysqli_num_rows($q3);
  $q9 = mysqli_query($c, "select DISTINCT month(created) as mon, COUNT(*) as freq from document group by month(created)");
  $at = mysqli_query($c, "select * from user");
  $at = mysqli_fetch_all($at);
  $jan = 0;
  $feb = 0;
  $mar = 0;
  $apr = 0;
  $may = 0;
  $jun = 0;
  $jul = 0;
  $aug = 0;
  $sep = 0;
  $oct = 0;
  $nov = 0;
  $dec = 0;
   while($r = mysqli_fetch_assoc($q9)){
     if($r['mon'] == 8){
       $aug = $r['freq'];
     }
     else if($r['mon'] == 9){
       $sep = $r['freq'];
     }
     else if($r['mon'] == 10){
       $oct = $r['freq'];
     }
     else if($r['mon'] == 11){
       $nov = $r['freq'];
     }
     else if($r['mon'] == 12){
       $dec = $r['freq'];
     }
     else if($r['mon'] == 7){
       $jul = $r['freq'];
     }
     else if($r['mon'] == 6){
       $jun = $r['freq'];
     }
     else if($r['mon'] == 5){
       $may = $r['freq'];
     }
     else if($r['mon'] == 4){
       $apr = $r['freq'];
     }
     else if($r['mon'] == 3){
       $mar = $r['freq'];
     }
     else if($r['mon'] == 2){
       $feb = $r['freq'];
     }
     else if($r['mon'] == 1){
       $jan = $r['freq'];
     }
   } 
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin dashboard</title>
  <link rel = "stylesheet" href ="./style.css">
    <script src="./chart.min.js"></script>
  </head>
  <body>
    <div class="sidebar">
      <div class="top">
        <a href=""><h3>Dashboard</h3></a>
      </div>
      <ul >
      <a href="">  <li>
        <img src="./images/house.svg" alt="" class="">
        <p>Home</p>
      </li></a>
        
        <li onclick="toggle()">
          <img src="./images/blank-file-black-icon.svg" alt="" class="">
          <p>Documents</p>
        </li>
        <li class="no-pad sd">
          <p onclick="alldocs('')">
            Recent File
          </p>
          <p onclick="alldocs('reports')">
            Weekly Reports
          </p>
          <p onclick="alldocs('minutes')">
            Minute Meetings
          </p>
          <p onclick="alldocs('joint')">
            Joint Research
          </p>
          <p onclick="alldocs('innovation')">
            Innovation
          </p>
          <p onclick="alldocs('BPO')">
            BPO
          </p>
        </li>
        <li onclick="toggle2()" style = "display: none">
          <img src="./images/user-role-svgrepo-com.svg" alt="" class="">
          <p>Roles</p>
          <li class="no-pad2 sr">
            <p onclick="users()">User</p>
            <p onclick="admin()">Admin</p>
          </li>
        </li>
        <li onclick="showAdd()" style = "display: none">
          <img src="./images/add-user-svgrepo-com.svg" alt="" class="">
          <p>Add user</p>
        </li>
        <li onclick="getAudit()" style = "display: none">
        <img src="./images/audit.svg" alt="" class="" width = "20px">
            Audit Trail
      </li>
      <li onclick="showForm()">
        <img src="./images/upload1.svg" alt="" class="" width = "20px">
            upload file
      </li>
      
      </ul>
    </div>



    <div class="navbar">
      <img src="./images/Asset 1.svg" alt=""  class="logo"/>
      <div class="last">
        <div class="search">
          <img src="./images/search.svg" alt="" class="icon" />
          <input type="text" placeholder="search for docs" oninput="getSearch()"/>
        </div>
          <div class="notify" onclick ="updateN()" style = "display: none">
          <img src="./images/bell.svg" alt="" class="icon" onclick="getnot()"/>
          <script>
            function updateN(){
              let dat = {
                id: 1
              }
              fetch('notify.php',{
                method: 'post',
                body: JSON.stringify(dat),
                headers: {
                  'Content-type': 'application/json'
                }
              })
            }
          </script>
          <div class="ellipse" style = "background-color: <?php
          if($fig == 0){
            echo '#27adae';
          }
          ?>">
            <small>
              <?php 
              
              if($fig > 0){
                echo $fig;
              }
              else{
                echo mysqli_num_rows($q5);
              }
              ?>
            </small>
          </div>
          </div>
        <div class="rib">
          <div class="img" onclick="showp()">
          <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 33 33"><defs><style>.cls-1{fill:none;}.cls-2{opacity:0.15;}.cls-3{fill:#ced2d8;}.cls-4{clip-path:url(#clip-path);}</style><clipPath id="clip-path"><path class="cls-1" d="M16.18,18.39a7.26,7.26,0,1,0-7.25-7.26A7.25,7.25,0,0,0,16.18,18.39Zm-2.59,2.72a10.1,10.1,0,0,0-10.1,10.1,1.68,1.68,0,0,0,1.68,1.68h22a1.69,1.69,0,0,0,1.69-1.68,10.11,10.11,0,0,0-10.11-10.1Z"/></clipPath></defs><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1"><g class="cls-2"><circle class="cls-3" cx="16.5" cy="16.5" r="16.5"/></g><g class="cls-4"><circle class="cls-3" cx="16.5" cy="16.5" r="16.5"/></g></g></g></svg>
          </div>
        </div>
        <div class="ps">
          <p onclick="showprofile()"><img src="./images/user.svg" alt="" class="icon"> My Profile</p>
          <p onclick="passwordShow()"><img src="./images/change-password-icon.svg" alt="" class="icon">Change password</p>
          <p onclick="Logout()"><img src="./images/log-out.svg" alt="" class="icon">Logout</p>
        </div>
      </div>
    </div>


    <div class="main">
      <canvas id="bar"> </canvas>
    </div>





    <div class="chats">
      <h3 id="chat">Chat Room</h3>
      <div class="messages">
        <?php foreach($qr2 as $message): ?>
        <div class="message">
          <p><?php echo htmlspecialchars($message[5]) ?></p>
          <small><?php echo htmlspecialchars($message[2]) ?></small>
          <h3><?php echo htmlspecialchars($message[1]) ?></h3>
        </div>
        <?php endforeach; ?>
      </div>
      <form class="send" method = "post" action = "./sendmessage.php">
        <input type="text" placeholder="compose message" name = "body"/>
        <img src="./images//XMLID_51_.svg" alt="" />
        </form>
    </div>
    <div class="green left" onclick ="alldocs('')" style = "display: none">
    <p>
      <?php echo htmlspecialchars($qr8) ?>
      </p>
      <small> Documents Uploaded  </small>
      </div>
    <div class="black left" onclick = "admin()" style = "display: none">
      <p><?php echo htmlspecialchars($qr6) ?></p>
      <small>Admin Accounts</small>
    </div>
    <div class="slateblue left" onclick = "users()" style = "display: none">
      <p><?php echo htmlspecialchars($qr7) ?></p>
      <small>User Accounts</small>
    </div>




    <div class="more" style="grid-row: 3/5"> 
      <div class="upload" onclick="showForm()">
        <img src="./images/upload.svg" alt="" />
        <h3>Upload Documents</h3>
        <p>
          Save all your documents to the system 
        </p>
      </div>
      <div class="view" onclick="alldocs('')">
        <img src="./images//file_type_taskfile.svg" alt="" />
        <h3>View uploaded documents</h3>
        <p>
          Get a view of all documents
        </p>
      </div>
    </div>
    <div class="welcome" onclick="showprofile()">
      <p>Welcome to your dashboard,</p>
      <h1><?php echo htmlspecialchars($qr1['fullname']) ?></h1>
      <small>All rights reserved, 2023 to the Ministry of ICT</small>
    </div>
    <div class="msg">

    </div>
    
    <form class="add-doc show-form" onsubmit ="formcheck()"  action = "addDoc.php" method = "post" enctype = "multipart/form-data">
      <img src="./images/Group 12.svg" alt="" class="form-x" onclick="hidedocsForm()">
      <p>Title</p>
      <input type="text" name = "title" id="title" onblur="validate()">
      <p>Category</p>
      <select name="category" id="">
        <option value="reports">Weekly Reports</option>
        <option value="minutes">Meeting Minutes</option>
        <option value="BPO">BPO</option>
        <option value="joint">Joint Research</option>
        <option value="innovation">Innovation</option>
      </select>
      <p>
        Description
      </p>
      <textarea id="description" cols="30" rows="3" name = "description"></textarea>
      <p>Select a document to upload (Acceptable formats PDF, DOC, DOCX, XLS, TXT, PPT)</p>
      <span><input type="file" name="upload" id="upload" class = "file-up" accept=".pdf, .doc, .ppt, .txt, .docx, .xlsx"> <button id="compose" onclick = "fileup()">Compose</button></span> <br>
      <textarea name="compose" id="composer" cols="20" rows="3" class = "comp comphide"></textarea>
      <label style = "display: none"><input type="checkbox" name="status" id=""> Private</label>
      <input type="submit" value="Add a new document" name ="submit">
    </form>
    <form class="adduser show-form" method = "post" action = "adduser.php" onsubmit = "userCheck()">
      <img src="./images/Group 12.svg" alt="" class="user-x" onclick="showAdd()">
      <p>
          Full Name
      </p>
      <input type="text" name = "fullname" id = "name">
      <p>Email</p>
      <input type="email" name = "email" id = "email"> 
      <p>
          Title
      </p>
      <input type="text" name = "title" id ="knife">
      <p>
          Contact
      </p>
      <input type="text" name = "contact" id = "contact">
      <p>
          Random Password
      </p>
      <button onclick="passwordGenerator()">Get Random Password</button> <br>
      <input type="text" id="rand" name = "password">
      <br>
      <input type="submit" value="Add user" name = "submit">
  </form>
  <form class="password" onsubmit="checkpass()" action = "changep.php" method = "post">
    <p >Old password</p>
    <input type="password" name="" id="p0">
    <p>New Password</p>
    <input type="password" name="newpass" id="p1">
    <p>Confirm New Password</p>
    <input type="password" name="" id="p2">
    <input type="submit" value="submit" name = "submit">
</form>

<div class="profile">
        
  <div class="img">
  <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 33 33"><defs><style>.cls-1{fill:none;}.cls-2{opacity:0.15;}.cls-3{fill:#ced2d8;}.cls-4{clip-path:url(#clip-path);}</style><clipPath id="clip-path"><path class="cls-1" d="M16.18,18.39a7.26,7.26,0,1,0-7.25-7.26A7.25,7.25,0,0,0,16.18,18.39Zm-2.59,2.72a10.1,10.1,0,0,0-10.1,10.1,1.68,1.68,0,0,0,1.68,1.68h22a1.69,1.69,0,0,0,1.69-1.68,10.11,10.11,0,0,0-10.11-10.1Z"/></clipPath></defs><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1"><g class="cls-2"><circle class="cls-3" cx="16.5" cy="16.5" r="16.5"/></g><g class="cls-4"><circle class="cls-3" cx="16.5" cy="16.5" r="16.5"/></g></g></g></svg>
  </div>
  <span>
    <h2><?php echo htmlspecialchars($qr1['fullname']) ?></h2>
  <p><?php echo htmlspecialchars($qr1['title']) ?></p>
  <p><?php echo htmlspecialchars($qr1['email']) ?></p>
  <p><?php echo htmlspecialchars($qr1['tel']) ?></p>
  </span>
</div>
<div class = "ta" id="see">

</div>
<img src="./images/bars.svg" alt="" id = "mb" onclick = "a()">
<script>
  const sb = document.querySelector('.sidebar')
  function a(){
    sb.classList.toggle('showside')
  }
</script>
    <script>
      Chart.defaults.scale.gridLines.drawOnChartArea = false
      Chart.defaults.global.defaultFontFamily = "poppins";
      Chart.defaults.global.defaultFontColor = "rgba(255,255,255,.5)";
      const chartDemo = document.getElementById("bar").getContext("2d");
      const myChart = new Chart(chartDemo, {
        type: "bar",
        data: {
          labels: [
            "jan",
            "feb",
            "mar",
            "April",
            "May",
            "June",
            "july",
            "Aug",
            "Sept",
            "Oct",
            "Nov",
            "Dec",
          ],
          datasets: [
            {
              label: "Number of Monthly File Uploads",
              data: [
              <?php echo $jan ?>,
              <?php echo $feb ?>,
              <?php echo $mar ?>,
              <?php echo $apr ?>,
              <?php echo $may ?>,
              <?php echo $jun ?>,
              <?php echo $jul ?>,
              <?php echo $aug ?>,
              <?php echo $sep ?>,
              <?php echo $oct ?>,
              <?php echo $nov ?>,
              <?php echo $dec ?>
            ],
              backgroundColor :"#343965"
            },
          ],
        },
        options: {
          maintainAspectRatio: false,
          /* scales:{
            xAxes:{
              gridLines:{
                drawOnChartArea: false
              }
            },
            yAxes:{
              gridLines:{
                drawOnChartArea: false
              }
            }
          } */
        },
      });
      function alldocs(argument){
        a()
        let category = {
          id: argument
        }
        const main = document.querySelector(".main")
        main.classList.add('no')
        fetch('./getdocs1.php',{
          method : 'POST',
          body: JSON.stringify(category),
          headers: {
            'Content-type': 'application/json'
          }
        })
        .then((res)=>res.json())
        .then((data)=>{
         if(data.length > 0){
          let output = ''
         data.forEach((element) =>{
          output += `
          
          <div class="doc" >
          ${
            (element.path).includes('.doc') ? '<img src = "./images/file-word.svg">' : (element.path).includes('.ppt') ? '<img src = "./images/file-powerpoint.svg">' : (element.path).includes('.xlsx') ? '<img src = "./images/file-excel.svg">' :(element.path).includes('.pdf') ? '<img src = "./images/file-pdf.svg">' : '<img src = "./images/file_type_taskfile.svg">'   
          }
            <p>${element.doct}</p>
            <p>${element.created}</p>
            <p>${element.fullname}</p>
           
            <img src="./images/Group 8.svg" alt="" class = "i-img"  onClick = "docMenu()" id ="${element.path}">
            
        </div>
          `
         })
         main.innerHTML = `
        <div class="docs">
         <div class="doc">
          
            <p>Title</p>
            <p>Date</p>
            <p>Author</p>

          </div>
          ${output}
            
        </div>`
         }
         else{
          main.innerHTML = "<h3 id = 'n-o'>No documents found</h3>"
         }
        })
      }
      // function getAll(){
      //   const main = document.querySelector(".main")
      //   main.style.backgroundColor = 'rgba(0,0,0,0)'
       
      // }
      function docMenu(){
        let id = event.target.id
      const msg = document.querySelector(".msg")
      console.log()
    msg.style.opacity = '1'
    msg.innerHTML = `
    <div class="docMenu">
    <img src="./images/Group 12.svg" alt=""  class="x" onClick = "removedocMenu()">
${
  id.includes('.docx') ? '<a href = "./uploads/opendoc.php?value='+id+'" style = "color: black"><p>  <img src="./images/open-file.svg" alt="" class="ou" width = "20px">Open as PDF</p></a>': id.includes('.pdf') ?  '<a style = "color: black" href = " '+id+ ' "> <a href = "'+id+'" style = "color: black"><p id = ' +id +' onclick = "opdf()">  <img src="./images/open-file.svg" alt="" class="ou" width = "20px">Open as PDF</p></a> </a>' : id.includes('.txt') ? '<a href = "./uploads/opentxt.php?value='+id+'" style = "color: black"><p>  <img src="./images/open-file.svg" alt="" class="ou" width = "20px">Open as PDF</p></a>':''
}

${id.includes(".pdf") ? '<p id = "'+id+'" onclick= "pdf()"><img src="./images/edit.svg" class="ou" width = "20px">Edit</p>' : id.includes(".txt") ? '<p id = "'+id+'" onclick= "gettxt()"><img src="./images/edit.svg" class="ou" width = "20px">Edit</p>' : id.includes(".doc") ? '<p id ='+id+' onclick= "see()"><img src="./images/edit.svg" class="ou" width = "20px">Edit</p>' : ""}

   <a href = "${id}" download style = "color: black">
   <p id = ${id} onClick = "download()">
        <img src="./images/download.svg" alt="" class="ou">
        Download
    </p>
   </a>
    <a href = "deletedoc.php?p=${id}" style = "color: black"><p> 
   <img src="./images/delete.svg" alt="" class="ou" width = "20px">
   Delete</p></a>
</div>
`




}
function opdf(){
  fetch('./uploads/logfunctions/pdf.php',{
    method : 'POST',
    body: JSON.stringify(
      {
        id: event.target.id
      }
    ),
    headers: {
      'Content-type': 'application/json'
    }
   })
}
     function download(){
   fetch('./uploads/logfunctions/delete.php',{
    method : 'POST',
    body: JSON.stringify(
      {
        id: event.target.id
      }
    ),
    headers: {
      'Content-type': 'application/json'
    }
   })
     }

      const getnot = ()=>{
        const main = document.querySelector(".main")
        main.style.backgroundColor = 'rgba(0,0,0,0)'
        main.innerHTML = `
        <div class="docs">
        <div class="doc">
          
            <p>Email</p>
            <p>position</p>
            <p>Full name</p>
            
        </div>
        <?php foreach($qr5 as $n): ?>
        <div class="doc">
          <img src = "./images/circle-user.svg">
            <p style = "overflow-x: scroll ; width : 200px" id = "sce"><?php echo htmlspecialchars($n[3]) ?></p>
            <p><?php echo htmlspecialchars($n[2]) ?></p>
            <p><?php echo htmlspecialchars($n[1]) ?></p>
    
          
            
        </div>
          <?php endforeach ?>
  

     


    </div>
        `
      }
      const getAudit = ()=>{
        const main = document.querySelector(".main")
        main.style.backgroundColor = 'rgba(0,0,0,0)'
        fetch('./upload')
        main.innerHTML = `
        <div class="docs">
        <div class="doc">
          
            <p>Email</p>
            
            
        </div>
        <?php foreach($at as $n): ?>
        <div class="doc">
          <img src = "./images/circle-user.svg">
            <p><?php echo htmlspecialchars($n[2]) ?></p>
            
            <img src="./images/Group 8.svg" alt="" class = "i-img"  onClick = "auditMenu()" id ="<?php echo htmlspecialchars($n[2]) ?>">
          
            
        </div>
          <?php endforeach ?>
        `
      }
     const auditMenu = ()=>{
      let id = event.target.id
        const msg = document.querySelector(".msg")
        msg.style.opacity = '1'
        msg.innerHTML = `
        <div class="docMenu">
        <img src="./images/Group 12.svg" alt="" class="x" onClick = "removedocMenu()">
        <p>
            <a href = "./uploads/logs/${id}.txt" >
            view
            </a>
        </p>
        <p>
            <a href = "./uploads/logs/${id}.txt" download>
            Download
            </a>
        </p>
    </div>
        `
        
     }
      const userMenu =()=>{
        let id= event.target.id
        const msg = document.querySelector(".msg")
        msg.style.opacity = '1'
        msg.innerHTML = `
        <div class="docMenu">
        <img src="./images/Group 12.svg" alt="" class="x" onClick = "removedocMenu()">
        <p>
        <a href = "revoke.php?g=${id}">
            Grant admin rights
            </a>
        </p>
        <p>
        <a href = "revoke.php?d=${id}">
            Deactivate account
            </a>
        </p>
    </div>
        `
        

      
      }
      const adminMenu =()=>{
        let id = event.target.id
        const msg = document.querySelector(".msg")
        msg.style.opacity = '1'
        msg.innerHTML = `
        <div class="docMenu">
        <img src="./images/Group 12.svg" alt="" class="x" onClick = "removedocMenu()">
        <p>
            <a href = "revoke.php?r=${id}" >
            Revoke admin rights
            </a>
        </p>
        <p>
            <a href = "revoke.php?d=${id}" >
            Deactivate account
            </a>
        </p>
    </div>
        `
        

      
      }
      const getSearch = ()=>{
        let mydata = event.target.value
        let category = {
          id: mydata
        }
        fetch('./getsearch1.php',{
          method: 'POST',
          body: JSON.stringify(category),
          headers:{
            'Content-type': 'application/json'
          }
        })
        .then(res =>res.json())
        .then(data =>{
  if(data.length > 0){
    let output = ''
          data.forEach(element =>{
            output += `
            <div class="doc" >
            ${
            (element.path).includes('.doc') ? '<img src = "./images/file-word.svg">' : (element.path).includes('.ppt') ? '<img src = "./images/file-powerpoint.svg">' : (element.path).includes('.xlsx') ? '<img src = "./images/file-excel.svg">' :(element.path).includes('.pdf') ? '<img src = "./images/file-pdf.svg">' : '<img src = "./images/file_type_taskfile.svg">'   
          }
            <p>${element.doct}</p>
            <p>${element.created}</p>
            <p>${element.fullname}</p>
           
            <img src="./images/Group 8.svg" alt="" class = "i-img"  onClick = "docMenu()" id ="${element.path}">
            
        </div>
            `
          })
          const main = document.querySelector(".main")
          main.style.backgroundColor = 'rgba(0,0,0,0)'
          main.innerHTML = `
        <div class="docs">
        <div class="doc">
          
            <p>Title</p>
            <p>Date</p>
            <p>Author</p>
            
        </div>
        

          ${output}

     


    </div>
        `
  }
  else{
    const main = document.querySelector(".main")
    main.style.backgroundColor = 'rgba(0,0,0,0)'
          main.innerHTML = "<h1 id='n-o'>No documents were found</h1>"
    
  }
        })
       
      }
      const users = ()=>{
        const main = document.querySelector(".main")
        main.style.backgroundColor = 'rgba(0,0,0,0)'
        main.innerHTML = `
        <div class="docs">
        <div class="doc">
          
            <p>Name</p>
            <p>Email</p>
            <p>Position</p>
            
            
        </div>
        <?php foreach($qd7 as $admin): ?>  
        <div class="doc"  >
          <img src = "./images/circle-user.svg">
            <p><?php echo htmlspecialchars($admin[1]) ?></p>
            <p><?php echo htmlspecialchars($admin[2]) ?></p>
            <p><?php echo htmlspecialchars($admin[4]) ?></p>
            
            <img src="./images/Group 8.svg" alt="" class = "i-img" id = "<?php echo htmlspecialchars($admin[2]) ?>" onClick = "userMenu()">
            
        </div>
          <?php endforeach ?>

  

     


    </div>
        `
      }
      const admin = ()=>{
        const main = document.querySelector(".main")
        main.style.backgroundColor = 'rgba(0,0,0,0)'
        main.innerHTML = `
        <div class="docs">
        <div class="doc">
          
            <p>Name</p>
            <p>Email</p>
            <p>Position</p>
            
            </div>
            <?php foreach($qd6 as $admin): ?>   
        <div class="doc"  >
          <img src = "./images/circle-user.svg">
            <p><?php echo htmlspecialchars($admin[1]) ?></p>
            <p><?php echo htmlspecialchars($admin[2]) ?></p>
            <p><?php echo htmlspecialchars($admin[4]) ?></p>
            
            <img src="./images/Group 8.svg" alt="" class = "i-img" id = "<?php echo htmlspecialchars($admin[2]) ?>" onClick = "adminMenu()">
            
        </div>
          <?php endforeach ?>
  

     


    </div>
        `
      }
      const showprofile =()=>{
        
        const showp = document.querySelector(".profile")
        
        
        showp.classList.toggle("pscale")
        
      }
      const showForm =()=>{
        const addDoc = document.querySelector(".add-doc")
        addDoc.classList.toggle("show-form")
        a()
      }
      const showAdd =()=>{
        a()
        const addDoc = document.querySelector(".adduser")
        addDoc.classList.toggle("show-form")
      }

const removedocMenu =()=>{
  const msg = document.querySelector(".msg")
  msg.innerHTML = ''
  msg.style.opacity = '0'

}
const passwordShow =()=>{
  showp()
  const password = document.querySelector(".password")
  password.classList.toggle("passwordshow")
}
const toggle = ()=>{
  const nopad = document.querySelector(".no-pad")
  nopad.classList.toggle("sd")
}
const toggle2 = ()=>{
  const nopad = document.querySelector(".no-pad2")
  nopad.classList.toggle("sr")
}
const hidedocsForm = ()=>{
  const addDoc = document.querySelector(".add-doc")
        addDoc.classList.add("show-form")
}
const showp =()=>{
  const ps = document.querySelector(".ps")
  ps.classList.toggle("pss")
}
function passwordGenerator(){
        event.preventDefault()
    const characters = "1234567890qwertyuiopasdfghjklzxcvbnm!@#$%^&*()_+/?|"
    const passwordLength = 14
    let password = ""
const inputEl = document.getElementById("rand")
        for(let i =0; i< passwordLength; i++){
            let randomNumber = Math.floor(Math.random()*characters.length)
            password += characters.charAt(randomNumber)
        }
    inputEl.value = password
}
function checkpass(){

  const p1 = document.getElementById("p1")
  const p0 = document.getElementById("p0")
  const p2 = document.getElementById("p2")
  if(((p1.value).length) < 4 || ((p2.value).length) < 4){
    event.preventDefault()
    alert('You cannot submit empty fields')
  }
  if(p2.value !== p1.value){
    event.preventDefault()
    alert('Please provide a valid password')
  }
  if(p0.value !== '<?php echo htmlspecialchars($password) ?>'){
    event.preventDefault()
    alert('please provide the correct old password')
  }
 
}
function Logout(){
  let a = confirm("Are you sure you want to logout")
  if(a){
    window.location = 'adminlogout.php'
  }
}
function fileup(){
  event.preventDefault()
  const fileup = document.querySelector('.file-up')
  const filecomp = document.querySelector('.comp')
  fileup.classList.toggle('fhide')
  filecomp.classList.toggle('comphide')
}
    </script>
    <script>
 function validate(){
   let title = document.getElementById('title').value
   
  fetch('./getdocs2.php')
  .then((res)=>res.json())
  .then((data)=>{
    let old = []
    data.forEach(element=>{
      old.push(element.doct)

    })
    let a = 0
   for (let index = 0; index < old.length; index++) {
    if(old[index] === title){
      
    a ++
    }
    
   }
   if(!(a == 0)){
    let opt = confirm(`Do you want to replace ${title}`)
    if(!opt){
      document.getElementById('title').value = `${title} ${a}`
      
    }
   }
   
    
    
  })
 }
 
  function savetext(){
    let ta =document.getElementById("ta").value
    let data ={
     id: event.target.id,
      text: ta
    }
    fetch('savetext.php',{
      method: 'post',
      body: JSON.stringify(data),
      headers:{
        'Content-type': 'application/json'
      }
    })
    .then(res => res.text())
    .then(data => {
      alert('File updated');
      alldocs('')
      seeClose()
      removedocMenu()


    })
  }
  function savepdf(){
    let ta =document.getElementById("ta").value
    let data ={
     id: event.target.id,
      text: ta
    }
    fetch('savepdf.php',{
      method: 'post',
      body: JSON.stringify(data),
      headers:{
        'Content-type': 'application/json'
      }
    })
    .then(res => res.text())
    .then(data => {
      alert('File updated');
      window.location = "admindashboard.php"
    })
  }
  const area = document.querySelector(".ta")
  
  function seeClose(){
    area.classList.remove("areas")
  }
    // window.addEventListener('load', ()=>{
    //   gettext()
    // })
    </script>
    <script>
  function see(){
        
    id = event.target.id
    area.classList.add("areas")
const see = document.getElementById("see")
let content = {
      id: id
    }
    fetch('gettext.php',{
      method: 'post',
      body: JSON.stringify(content),
      headers: {
        'Content-type': 'application/json'
      }
    })
    .then(res =>res.text())
    .then(data =>{
      see.innerHTML = `
<div class="menu">
    <img src="./images/Group 12.svg" alt="" onClick = "seeClose()" class = "xi">
  </div>
  <textarea id="ta" value = "${data}"></textarea>
<button id = "${id}" onclick="savetext()">
  Save
</button>
<button onClick = "seeClose()">
  Cancel
</button>
`
document.getElementById('ta').value = data

    })


  }
  function pdf(){
    id = event.target.id
    area.classList.add("areas")
const see = document.getElementById("see")
let content = {
      id: id
    }
    fetch('getpdf.php',{
      method: 'post',
      body: JSON.stringify(content),
      headers: {
        'Content-type': 'application/json'
      }
    })
    .then(res =>res.text())
    .then(data =>{
      see.innerHTML = `
<div class="menu">
    <img src="./images/Group 12.svg" alt="" onClick = "seeClose()" class = "xi">
  </div>
<textarea id="ta" value = ${data}></textarea>
<button id = "${id}" onclick="savepdf()">
  Save
</button>
<button onClick = "seeClose()">
  Cancel
</button>
`
document.getElementById('ta').value = data

    })


  }
  function gettxt(){
    id = event.target.id
    area.classList.add("areas")
const see = document.getElementById("see")
let content = {
      id: id
    }
    fetch('gettxt.php',{
      method: 'post',
      body: JSON.stringify(content),
      headers: {
        'Content-type': 'application/json'
      }
    })
    .then(res =>res.text())
    .then(data =>{
      see.innerHTML = `
<div class="menu">
    <img src="./images/Group 12.svg" alt="" onClick = "seeClose()" class = "xi">
  </div>
<textarea id="ta" value = ${data}></textarea>
<button id = "${id}" onclick="savetxt()">
  Save
</button>
<button onClick = "seeClose()">
  Cancel
</button>
`
document.getElementById('ta').value = data

    })


  }
  // function savetext(){
  //   let ta =document.getElementById("ta").value
  //   let data ={
  //    id: event.target.id,
  //     text: ta
  //   }
  //   fetch('savetext.php',{
  //     method: 'post',
  //     body: JSON.stringify(data),
  //     headers:{
  //       'Content-type': 'application/json'
  //     }
  //   })
  //   .then(res => res.text())
  //   .then(data => {
  //     alert('File updated');
  //     window.location = "admindashboard.php"
  //   })
  // }
  function savetxt(){
    let ta =document.getElementById("ta").value
    let data ={
     id: event.target.id,
      text: ta
    }
    fetch('savetxt.php',{
      method: 'post',
      body: JSON.stringify(data),
      headers:{
        'Content-type': 'application/json'
      }
    })
    .then(res => res.text())
    .then(data => {
      alert('File updated');
      window.location = "admindashboard.php"
    })
  }
  function formcheck(){
    const title = document.getElementById("title").value
    const description = document.getElementById("description").value
    const compose = document.getElementById("composer").value
    const upload = document.getElementById("upload").value

    if(!(title.length > 4 && title.length < 14)){
      event.preventDefault()
      alert('The title must be of 4 to 8 characters maximum')
    }
    if(title.includes(' ')){
     event.preventDefault()
     alert('Avoid leaving spaces in the title')
    }
    if(description.length < 5){
      event.preventDefault()
      alert('please provide a valid description')
    }
    if(compose.length < 5 && upload.length < 5){
      event.preventDefault()
      alert('Please select a file to upload, if not, you can just compose the text')
    }
    
  }

    </script>
    <script>
const userCheck =()=>{
  event.preventDefault()
  let name = document.getElementById('name').value
  let title = document.getElementById('knife').value
  let rand = document.getElementById('rand').value
  let contact = document.getElementById('contact').value
  let email = document.getElementById('email').value



  let data = {
      email: email
    }
   fetch('./email.php', {
      method: 'POST',
      body: JSON.stringify(data),
      headers: {
        'Content-type': 'application/json'
      }
    })
    .then(res => res.text())
    .then(d => {
      let err = 0
      if(name.length < 4){
    
    alert('please provide a name')
    err = 1
   
  }
  if(title.length < 3){
  
    alert('Please provide a valid title')
    err = 1
  }
  if(rand.length < 9){
   err = 1
    alert('passwword must be of atleast 8 characters')
  }
  if(contact.length < 10){
    err = 1
    alert('please provide a valid telephone number')
  }
  if(!(email.includes('@ict.go.ug'))){
   err = 1
    alert('please provide a valid email (hint: must contain @ict.go.ug)')
  }
      if(d >= 1){
        err = 1
        alert('There is already a user registered under this email, use another email')
    
      }
      if(err === 0){
       fetch('./adduser.php',{
        method: 'POST',
        body: JSON.stringify(
          {
            n: name,
            e: email,
            c: contact,
            t: title,
            r: rand,

          }
        )
       })
       .then(res =>res.text())
       .then(data => {
        alert(data)
        window.location = 'admindashboard.php'
       }
       
       )
      }
    })

}
</script>
  </body>
</html>
