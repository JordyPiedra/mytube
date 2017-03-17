import { Injectable } from '@angular/core';
import { AppSettings } from './settings.service';
import { Http , Headers} from '@angular/http';
import 'rxjs/add/operator/map';

@Injectable()
export class LoginService {

  constructor(private http:Http) { }
 
  loginAutetication(user:usuario){
    let urlAPI = AppSettings.API_ENDPOINT+'login';
    console.log(JSON.stringify({'json':user}));
    let params = JSON.stringify({'json':user});
    let headers      = new Headers({ 'Content-Type': 'application/json' }); // ... Set content type to JSON
    return this.http.post(urlAPI,params,headers)
      .map(res=>res.json())
     ;


  }

 
}

 interface usuario{
  password:string,
  email: string,
  gethash:boolean
  }