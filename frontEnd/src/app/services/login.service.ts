import { Injectable } from '@angular/core';
import { AppSettings } from './settings.service';
import { Http } from '@angular/http';
import { Headers, RequestOptions } from '@angular/http';
import 'rxjs/add/operator/map';

@Injectable()
export class LoginService {
   public identity:any;
 public identityToken:string;

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

    getIdentity(){
    let identity = JSON.parse(localStorage.getItem('identity'));
    console.log(JSON.parse(localStorage.getItem('identity')));
    if(identity != "undefined"){
      this.identity = identity;
    }else{
      this.identity= null;
    }

    return this.identity;
  }
      getIdentityToken(){
    let identityToken = localStorage.getItem('identityToken');
    console.log(identityToken);
    if(identityToken != "undefined"){
      this.identityToken = identityToken;
    }else{
      this.identityToken= null;
    }

    return this.identityToken;
  }


 register(user){
    let urlAPI = AppSettings.API_ENDPOINT+'user/new';
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