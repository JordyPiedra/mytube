import { Component, OnInit } from '@angular/core';
import { LoginService } from '../../services/login.service';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']

})
export class LoginComponent implements OnInit {
 public user:any;
 public responseLogin:any;
 public responseLoginToken:any;
  constructor( private loginService : LoginService) { 
 this.user={
      email:"",
      password:"",
      gethash :true
    };

  }

  ngOnInit() {
   
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
                       this.responseLoginToken=response;
                          localStorage.setItem('identity', JSON.stringify(this.responseLoginToken));
                           
                       
                    }
              );

              


            }else{
              alert('Error: ' + this.responseLogin.data );
            }
    }
    );
  }

}
