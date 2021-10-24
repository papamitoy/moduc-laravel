function loginAuth(){
 
        var formData = new FormData(document.getElementById('loginForm'));
        axios.post("/moduc/requests/POST/login.request.php",formData).then(res=>{
            console.log(res.data)
            if(res.data.success){
                Swal.fire(
                    'Success',
                    res.data.message,
                    'success'
                ).then(()=>{
                    location.reload();
                })
            }else{
                Swal.fire(
                    'Warning',
                    res.data.message,
                    'warning'
                ) 
            }
        }).catch(err=>{
            console.log("err",err)
        });
}

function registerForm(){
  
    var formData = new FormData(document.getElementById('registerForm'));
    axios.post("/moduc/requests/POST/register.request.php",formData).then(res=>{
        console.log(res.data)
        if(res.data.success){
            Swal.fire(
                'Success',
                res.data.message,
                'success'
            ).then(()=>{
                location.reload();
            })
        }else{
            Swal.fire(
                'Warning',
                res.data.message,
                'warning'
            ) 
        }
    }).catch(err=>{
        console.log("err",err)
    });
}

function addSubject(){
    var formData = new FormData(document.getElementById('addSubject'));
    axios.post("/moduc/requests/POST/addsubject.request.php",formData).then(res=>{
        console.log(res);
        if(res.data.success){
            Swal.fire(
                'Success',
                res.data.message,
                'success'
            ).then(()=>{
                location.reload();
            })
        }else{
            Swal.fire(
                'Warning',
                res.data.message,
                'warning'
            ) 
        }
    }).catch(err=>{
        console.log("err",err)
    });
}
function joinSubject(){
    var formData = new FormData(document.getElementById('joinsubject'));
    axios.post("/moduc/requests/POST/joinsubject.request.php",formData).then(res=>{
        console.log(res);
        if(res.data.success){
            Swal.fire(
                'Success',
                res.data.message,
                'success'
            ).then(()=>{
                location.reload();
            })
        }else{
            Swal.fire(
                'Warning',
                res.data.message,
                'warning'
            ) 
        }
    }).catch(err=>{
        console.log("err",err)
    });
}

function logout(){
    axios.post("/moduc/requests/POST/logout.request.php").then(res=>{
        location.reload();
    });
}