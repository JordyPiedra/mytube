<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use BackendBundle\Entity\User;

class UserController extends Controller
{
    
   

    public function newAction(Request $request){
        $helpers= $this->get('app.helpers');
        $json=$request->get('json',null);
        if($json)
        {
            $params = json_decode($json);

            $email= (isset($params->email))? $params->email:null;
            $name= (isset($params->name) && ctype_alpha($params->name)&& !empty($params->name))? $params->name:null;
            $username= (isset($params->username))? $params->username:null;
            $password= (isset($params->password) && !empty($params->password))? $params->password:null;
            $role="user";

            $emailConstraint = new Assert\Email();
            $emailConstraint ->message = "This email is not valid!";
            $validate_email=$this->get('validator')->validate($email,$emailConstraint);
            
            if(count($validate_email) ==0 && isset($password) 
               && isset($name)  && isset($username)  && isset($email) 
            ){
                $user = new User();
                $user->setEmailUser($email);
                $user->setNameUser($name);
                $user->setUnameUser($username);
                $user->setRolUser($role);
                $pwd = hash('sha256',$password);
                $user->setPasswUser($pwd);


                $em = $this->getDoctrine()->getManager();
                $isset_user = $em->getRepository("BackendBundle:User")->findOneBy(
                    ['emailUser' => $email]);
                if(count($isset_user)==0)
                {
                    //var_dump($this->getDoctrine()->getManager());
                    //die();
                    $em->persist($user);
                    $em->flush();

                    return $helpers->json_(["status"=>"success", "message"=>"User created!"]);
                }else
                {
                    return $helpers->json_(["status"=>"error", "code"=>400,"message"=>"User not created email duplicated"]);
                }
            } return $helpers->json_(["status"=>"error", "code"=>400,"message"=>"User not created, incomplete data!"]);

        }
        return $helpers->json_(["status"=>"error", "code"=>400,"message"=>"User not created"]);
    }


    public function editAction(Request $request){
        $hash= $request->get('autorization',null);
        $helpers= $this->get('app.helpers');
        if($hash && !empty($hash))
        {

            $jwt= $this->get('app.jwt_auth');
            $checkAuth=$jwt->checkAuth($hash);
            if($checkAuth)
            {
                $identity=$jwt->checkAuth($hash,true);
                $em = $this->getDoctrine()->getManager();
                $user= $em->getRepository("BackendBundle:User")->findOneBy(["idUser" => $identity->sub]);
                    $json=$request->get('json',null);
                    if($json)
                    {
                        $params = json_decode($json);

                        $email= (isset($params->email))? $params->email:null;
                        $name= (isset($params->name) && ctype_alpha($params->name)&& !empty($params->name))? $params->name:null;
                        $username= (isset($params->username))? $params->username:null;
                        $password= (isset($params->password) && !empty($params->password))? $params->password:null;
                        $role="user";

                        if($email)
                        {
                            $emailConstraint = new Assert\Email();
                            $emailConstraint ->message = "This email is not valid!";
                            $validate_email=$this->get('validator')->validate($email,$emailConstraint);
                        
                            if(count($validate_email) ==0)
                                $user->setEmailUser($email);

                        }
                        
                        if($name)
                            $user->setNameUser($name);
                        
                        if($username)
                            $user->setUnameUser($username);
                            
                        if($password)
                            {
                                $pwd = hash('sha256',$password);
                                $user->setPasswUser($pwd);
                            }
                        $user->setRolUser($role);

                            $em->persist($user);
                            $em->flush();
                            return $helpers->json_(["status"=>"success","message"=>"User updated!"]);
                    }
                    return $helpers->json_(["status"=>"error", "code"=>400,"message"=>"User not updated!"]);


            }else
            return $helpers->json_(["status"=>"error", "code"=>400,"message"=>"Authorization not valid!"]);
        }
         return $helpers->json_(["status"=>"error", "code"=>400,"message"=>"Incomplete data!"]);
    }

    public function uploadImageAction(Request $request){
        $hash= $request->get('autorization',null);
        $helpers= $this->get('app.helpers');
        if($hash && !empty($hash))
        {

            $jwt= $this->get('app.jwt_auth');
            $checkAuth=$jwt->checkAuth($hash);
            if($checkAuth)
            {
                $identity=$jwt->checkAuth($hash,true);
                $em = $this->getDoctrine()->getManager();
                $user= $em->getRepository("BackendBundle:User")->findOneBy(["idUser" => $identity->sub]);
               
                $file=$request->files->get("image");
                if(isset($file) && !empty($file))
                {
                    $ext = $file->guessExtension();
                    $file_name=time().".".$ext;
                    $file->move("uploads/users",$file_name);
                    $user->setImageUser($file_name);
                    $em->persist($user);
                    $em->flush();
                            return $helpers->json_(["status"=>"success","message"=>"Image uploaded complete!"]);
                }else
                    return $helpers->json_(["status"=>"success","message"=>"Image not uploaded"]);
            }else
              return $helpers->json_(["status"=>"error", "code"=>400,"message"=>"Authorization not valid!"]);
        } else
            return $helpers->json_(["status"=>"error", "code"=>400,"message"=>"Incomplete data!"]);
    }

    public function channelAction(Request $request, $id=null){
        $helpers= $this->get('app.helpers');
        $em=$this->getDoctrine()->getManager();

        if($id)
        {
            $user= $em->getRepository("BackendBundle:User")->findOneBy(["idUser" => $id]);
            if(count($user)==1)
            {
                $dql="SELECT v FROM BackendBundle:Video v WHERE v.idUser = $id ORDER BY v.idVideo DESC";
                $query = $em->createQuery($dql);
                $page = $request->query->getInt("page",1);
                $items_per_page = $request->query->getInt("items_per_page",5);
                $paginator= $this->get("knp_paginator");
            

                $pagination = $paginator->paginate($query,$page, $items_per_page);
                $total_items_count=$pagination->getTotalItemCount();

                $data = [
                    "status" => "success",
                    "total_items_count" => $total_items_count,
                    "page_actual" => $page,
                    "items_per_page"=>$items_per_page,
                    "total_pages" => ceil($total_items_count/$items_per_page),
                    "data"=>["user" => $user , "videos" => $pagination ]
                ];
                return $helpers->json_($data);
            }else
            return $helpers->json_(["status"=>"error", "code"=>400,"message"=>"User not exist!"]);
        }else
        return $helpers->json_(["status"=>"error", "code"=>400,"message"=>"Incomplete data!"]);

        
        

        

        

    }
}
