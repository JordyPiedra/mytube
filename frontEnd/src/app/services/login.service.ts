import { Injectable } from '@angular/core';
import { AppSettings } from './settings.service';
import { Http } from '@angular/http';
import { Headers, RequestOptions } from '@angular/http';
import 'rxjs/add/operator/map';

@Injectable()
export class LoginService {

  constructor(private http:Http) { }
 
  loginAutetication(user:usuario){
    let urlAPI = AppSettings.API_ENDPOINT+'login';
    let params = 'json='+JSON.stringify(user);
    let headers = new Headers({ 'Content-Type': 'application/x-www-form-urlencoded' }); // ... Set content type to JSON
    let options = new RequestOptions({ headers: headers });
    return this.http.post(urlAPI,params,options)
      .map(res=>
      {
      //  console.log(res.json());
        return res.json();}
      )
     ;


  }

 
}

 interface usuario{
  password:string,
  email: string,
  gethash:boolean
  }