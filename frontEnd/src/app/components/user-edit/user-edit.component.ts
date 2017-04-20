import { Component, OnInit } from '@angular/core';
import { User } from '../../model/usermodel';
import { LoginService } from '../../services/login.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-user-edit',
  templateUrl: './user-edit.component.html',
  styleUrls: ['./user-edit.component.css']
})
export class UserEditComponent implements OnInit {

  public titulo:string="Actualizar mis datos";
  public user:User;
  public status:string;
  public errorMessage:String;
  constructor(public loginService:LoginService,public router:Router) { }

  ngOnInit() {
    let identity = this.loginService.getIdentity();
    if(identity == null)
    {
      this.router.navigate(['/login']);
    }
    else
    {
      
      this.user = new User (identity.sub,
                            null,
                            identity.name,
                            identity.email,
                            null,
                            identity.username,
                            null)  ;
    }
  }

}
