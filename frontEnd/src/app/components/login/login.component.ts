import { Component, OnInit } from '@angular/core';
import { LoginService } from '../../services/login.service';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']

})
export class LoginComponent implements OnInit {
 public user:any;
 public token:any;
  constructor( private loginService : LoginService) { 
 this.user={
      useremail:"",
      userpassword:"",
      usergetHash :false
    };

  }

  ngOnInit() {
   
  }

  onSubmit(){
    this.loginService.loginAutetication(this.user).subscribe(
      response =>{
         this.token=response;
         console.log(this.token);
    }
    );
  }

}
