import { Component, OnInit } from '@angular/core';
import { LoginService } from '../../services/login.service';
import { ActivatedRoute,Router } from '@angular/router';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']

})
export class LoginComponent implements OnInit {
 public user:any;
 public responseLogin:any;
 //public responseLoginToken:any;


  constructor( private loginService : LoginService , private activatedRoute:ActivatedRoute, private router : Router) { 
 this.user={
      email:"",
      password:"",
      gethash :true
    };

  }

  ngOnInit() {

   
    this.activatedRoute.params.subscribe(
      params => {
        if(params["id"])
        {
          let logout= + params["id"];
        console.log(logout);
        if (logout==1)
        {
           localStorage.removeItem('identity');
          localStorage.removeItem('identityToken');
          //this.router.navigate(['/index']);
          window.location.href="/login";
        }
        }
        
      }
    );

   
  }

  onSubmit(){
    this.loginService.loginAutetication(this.user).subscribe(
      response =>{
         this.responseLogin=response;
            if(this.responseLogin.status=='success')
            {
              localStorage.setItem('identityToken', this.responseLogin.data.token);
              //Obtener identificación del usuario
             this.user.gethash=false;
              this.loginService.loginAutetication(this.user).subscribe(
                    response =>
                    {
                       this.responseLogin=response;
                       console.log(this.responseLogin);
                       console.log(this.responseLogin.length);
                        if(JSON.stringify(this.responseLogin).length>0)
                          {
                          localStorage.setItem('identity', JSON.stringify(this.responseLogin));
                          window.location.href="/index";
                        }
                       
                    }
              );

                        console.log(localStorage.getItem('identityToken'));
                        console.log(localStorage.getItem('identity'));
                      //  window.location.href="/index";

            }else{
             // alert('Error: ' + this.responseLoginToken.data );
            }
    }
    );
  }

}
