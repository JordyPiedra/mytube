<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use BackendBundle\Entity\User;
use BackendBundle\Entity\Video;

class VideoController extends Controller
{
    
   

    public function newAction(Request $request){
        $hash= $request->get('autorization',null);
        $helpers= $this->get('app.helpers');
        if($hash && !empty($hash))
        {
            $jwt= $this->get('app.jwt_auth');
            $checkAuth=$jwt->checkAuth($hash);
            if($checkAuth)
            {
                $identity=$jwt->checkAuth($hash,true);
                    $json=$request->get('json',null);
                    if($json)
                    {
                        $params = json_decode($json);
                        $title_video=(isset($params->title) && !empty($params->title))? $params->title: null;
                        $description_video=(isset($params->description) && !empty($params->description))? $params->description: null;
                        $status_video=(isset($params->status) && !empty($params->status))? $params->status: null;
                        $em = $this->getDoctrine()->getManager();
                        $user= $em->getRepository("BackendBundle:User")->findOneBy(["idUser" => $identity->sub]);
                        
                        if( isset($user) && isset($title_video))
                        {
                            $video = new Video();
                            $video->setTitleVideo($title_video);
                            $video->setDescriptionVideo($description_video);
                            $video->setStatusVideo($status_video);
                            $video->setIdUser($user);
                            $em->persist($video);
                            $em->flush();

                            $video= $em->getRepository("BackendBundle:Video")->findOneBy([
                                "idUser" => $user,
                                "titleVideo" => $title_video,
                                "statusVideo" => $status_video

                            ]);
                             return $helpers->json_(["status"=>"success", "message"=>"Video created!","data"=>$video]);
                        }else
                         return $helpers->json_(["status"=>"error", "code"=>400,"message"=>"Video not created, incomplete data!"]);
                    }else
                     return $helpers->json_(["status"=>"error", "code"=>400,"message"=>"Video not created, user not valid!"]);
            }else
            return $helpers->json_(["status"=>"error", "code"=>400,"message"=>"Authorization not valid!"]);
        }else
        return $helpers->json_(["status"=>"error", "code"=>400,"message"=>"Incomplete data!"]);

    }

    public function editAction(Request $request,$id=null){
        $hash= $request->get('autorization',null);
        $helpers= $this->get('app.helpers');
        if($hash && !empty($hash))
        {
            $jwt= $this->get('app.jwt_auth');
            $checkAuth=$jwt->checkAuth($hash);
            if($checkAuth)
            {
                $identity=$jwt->checkAuth($hash,true);
                    $json=$request->get('json',null);
                    if($json)
                    {
                        $params = json_decode($json);
                        $title_video=(isset($params->title) && !empty($params->title))? $params->title: null;
                        $description_video=(isset($params->description) && !empty($params->description))? $params->description: null;
                        $status_video=(isset($params->status) && !empty($params->status))? $params->status: null;
                        $em = $this->getDoctrine()->getManager();
                        $video_id=$id;
                        $video= $em->getRepository("BackendBundle:Video")->findOneBy([
                                "idVideo" => $video_id
                            ]);

                        if(isset($video_id) && isset($identity->sub) && $identity->sub == $video->getIdUser()->getidUser())
                        {
                            
                                $video->setTitleVideo($title_video);
                                $video->setDescriptionVideo($description_video);
                                $video->setStatusVideo($status_video);
                                
                                $em->persist($video);
                                $em->flush();

                            

                                return $helpers->json_(["status"=>"success", "message"=>"Video update success!"]);
                            
                            
                        }else
                         return $helpers->json_(["status"=>"error", "code"=>400,"message"=>"Video not edited, User inconrrect!"]);
                    }else
                     return $helpers->json_(["status"=>"error", "code"=>400,"message"=>"Video not edited, user not valid!"]);
            }else
            return $helpers->json_(["status"=>"error", "code"=>400,"message"=>"Authorization not valid!"]);
        }else
        return $helpers->json_(["status"=>"error", "code"=>400,"message"=>"Incomplete data!"]);

    }

    public function uploadAction(Request $request,$id=null){
        $hash= $request->get('autorization',null);
        $helpers= $this->get('app.helpers');
        if($hash && !empty($hash))
        {
            $jwt= $this->get('app.jwt_auth');
            $checkAuth=$jwt->checkAuth($hash);
            if($checkAuth)
            {
                $identity=$jwt->checkAuth($hash,true);
                $video_id=$id;
                $em=$this->getDoctrine()->getManager();
                $video= $em->getRepository("BackendBundle:Video")->findOneBy([
                                "idVideo" => $video_id
                ]);
                    if(isset($video_id) && isset($identity->sub) && $identity->sub == $video->getIdUser()->getidUser())
                    {
                        
                            $file= $request->files->get('image',null);
                            $file_video= $request->files->get('video',null);
                            if(isset($file) && !empty($file))
                            {
                                
                                
                                $ext =$file->guessExtension();
                                if($ext == "jpg" || $ext == "jpeg" || $ext == "png")
                                {
                                    $file_name = time().".".$ext;
                                    $path_of_file="uploads/video_images/video_".$video_id;
                                    $file->move($path_of_file,$file_name);
                                    $video->setImageVideo($path_of_file."/".$file_name);
                                    $em->persist($video);
                                    $em->flush();
                                }else
                                return $helpers->json_(["status"=>"error", "code"=>400,"message"=>"Format for iamge not valid!"]);
                                
                            }
                            else if(isset($file_video) && !empty($file_video))
                            {
                                
                                $ext =$file_video->guessExtension();
                                if($ext == "mp4" || $ext == "avi"  )
                                {
                                    $file_name = time().".".$ext;
                                    $path_of_file="uploads/video_files/video_".$video_id;
                                    $file_video->move($path_of_file,$file_name);
                                    $video->setPathVideo($path_of_file."/".$file_name);
                                    $em->persist($video);
                                    $em->flush();
                                }else
                                return $helpers->json_(["status"=>"error", "code"=>400,"message"=>"Format for video not valid!"]);
                            }
                            

                            return $helpers->json_(["status"=>"success", "message"=>"Video file uploaded!"]);
                        
                    }else
                        return $helpers->json_(["status"=>"error", "code"=>400,"message"=>"Video not edited, User inconrrect!"]);
            }else
            return $helpers->json_(["status"=>"error", "code"=>400,"message"=>"Authorization not valid!"]);
        }else
        return $helpers->json_(["status"=>"error", "code"=>400,"message"=>"Incomplete data!"]);

    }

    public function listAction(Request $request){
        $helpers= $this->get('app.helpers');
        $em=$this->getDoctrine()->getManager();
        $dql="SELECT v FROM BackendBundle:Video v ORDER BY v.idVideo DESC";

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
            "data"=>$pagination
        ];
        return $helpers->json_($data);

    }

    public function lastsVideosAction(Request $request){
        $helpers= $this->get('app.helpers');
        $em=$this->getDoctrine()->getManager();
        $dql="SELECT v FROM BackendBundle:Video v ORDER BY v.createUser DESC";
        $query = $em->createQuery($dql)->setMaxResults(5);     
        $videos = $query->getResult();
        $data = [
            "status" => "success",
            "data"=>$videos
        ];
        return $helpers->json_($data);

    }

    public function videoAction(Request $request, $id=null){
        $helpers= $this->get('app.helpers');
        $em=$this->getDoctrine()->getManager();
        $video_id=$id;
        $video = $em->getRepository('BackendBundle:Video')->findOneBy(
                    ['idVideo' => $video_id]);
        
        if($video)            
        {
         $data = [
            "status" => "success",
            "data"=>$video
         ];

        }else
        {
         $data = [
            "status" => "error",
            "message"=>"Video dont exist!"
         ];
        }
        return $helpers->json_($data);

    }

    public function searchAction(Request $request, $search=""){
        $helpers= $this->get('app.helpers');
        $em=$this->getDoctrine()->getManager();

        //$dql="SELECT v FROM BackendBundle:Video v WHERE v.titleVideo LIKE '%$search%' OR v.descriptionVideo LIKE '%$search%' ORDER BY v.idVideo DESC";
        //Mejorar la seguridad de datos

        $dql="SELECT v FROM BackendBundle:Video v WHERE v.titleVideo LIKE :search OR v.descriptionVideo LIKE :search ORDER BY v.idVideo DESC";

        $query = $em->createQuery($dql)
                    ->setParameter("search","%$search%");;
        
        
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
            "data"=>$pagination
        ];
        return $helpers->json_($data);

    }



}
