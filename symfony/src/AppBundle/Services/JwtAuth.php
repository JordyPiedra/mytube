<?php

namespace AppBundle\Services;

use Firebase\JWT\JWT;

class JwtAuth{

    public $manager;
    public $key;
    public function __construct($manager){
        $this->manager = $manager;
        $this->key = 'clave-secreta';
    }

    public function signup($email,$password,$getHash=null){
         $pwd = hash('sha256',$password);
        $user = $this->manager->getRepository('BackendBundle:User')->findOneBy(
        array(
        'emailUser' => $email,
        'passwUser' => $pwd
        )
        );

        $signup=(is_object($user))? true:false;
        if($signup==true)
        {
        $token= [
            'sub' => $user->getIdUser(),
            'email' => $user->getEmailUser(),
            'name' => $user->getNameUser(),
            'username' => $user->getUnameUser(),
            'image' => $user-> getImageUser(),
            'iat' => time(),
            'exp' => time()+(7*24*60*60)
        ];
        $jwt = JWT::encode($token,$this->key,'HS256');
        $decoded= JWT::decode($jwt,$this->key,array('HS256'));
        if($getHash != null)
        {
            return ['status' => "success" , 'data' => ['token'=>$jwt ]];
        }
        else
             //return ['status' => "success" , 'data' => ['token'=>$decoded ]];
            return $decoded;

        }
        else
        return ['status' => "error" , 'data' => 'Login failed!'];
    }


    public function checkAuth($jwt,$getIdentity=false){
        $auth=false;

        try{
            $decoded= JWT::decode($jwt,$this->key,array('HS256'));
        }catch(\UnexpectedValueException $e){
            $auth=false;
        }catch(\DomainException $e){
            $auth=false;
        }
        if(isset($decoded->sub))
        $auth=true;
        
        if($getIdentity)
        return $decoded;
        else
        return $auth;

    }
}