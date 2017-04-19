import { Component, OnInit } from '@angular/core';
import { User } from '../../model/usermodel';
import { LoginService } from '../../services/login.service';

@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.css']
})
export class RegisterComponent implements OnInit {
 public titulo:string="Registro";
 public user:User;
 public status:string;
  public errorMessage:String;
  constructor(public loginService:LoginService) { }

  ngOnInit() {
    this.user = new User(1,"user","","","","","");
  }

  onSubmit(){
    this.loginService.register(this.user).subscribe(
      response => {
        console.log(response);
        this.status=response.status;
        this.errorMessage=response.message;
      },
      error => {
        this.errorMessage = <any> error;
        if(this.errorMessage != null) {
          console.log(this.errorMessage);
        }
      }
    );
    
  }
}
