import { Component, OnInit } from '@angular/core';
import { LoginService } from '../../services/login.service';

@Component({
  selector: 'app-navbar',
  templateUrl: './navbar.component.html',
  styleUrls: ['./navbar.component.css']
})
export class NavbarComponent implements OnInit {

  public identity:any;
  public identityToken:any;

  constructor( private loginService : LoginService) { 


  }
   ngOnInit() {
    this.identity= this.loginService.getIdentity();
    this.identityToken= this.loginService.getIdentityToken();
   
  }

}
