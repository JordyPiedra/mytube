<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use BackendBundle\Entity\User;
use BackendBundle\Entity\Video;
use BackendBundle\Entity\Comment;

class CommentController extends Controller
{


//Función para agregar comentarios a los videos
//Requiere autorización
//**Parametros json{video_id}
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
                        $body=(isset($params->body) && !empty($params->body))? $params->body: null;
                        $video_id=(isset($params->video_id) && !empty($params->video_id))? $params->video_id: null;
                         
                      
                        
                        if(isset($body)&& isset($video_id))
                        {
                            $em = $this->getDoctrine()->getManager();
                            $user= $em->getRepository("BackendBundle:User")->findOneBy(
                                ["idUser" => $identity->sub]);
                            $video= $em->getRepository("BackendBundle:Video")->findOneBy([
                                "idVideo" => $video_id,
                            ]);
                            if(!isset($user))
                            return $helpers->json_(["status"=>"error", "message"=>"User incorrect"]);
                            if(!isset($video))
                            return $helpers->json_(["status"=>"error", "message"=>"Video incorrect"]);
                            
                            
                            $comment = new Comment();
                            $comment->setIdUser($user);
                            $comment->setIdVideo($video);
                            $comment->setBodyComment($body);
                            $comment->setCreateComment(new \Datetime('now'));
                          
                            $em->persist($comment);
                            $em->flush();

                            
                             return $helpers->json_(["status"=>"success", "message"=>"Comment created!"]);
                        }else
                         return $helpers->json_(["status"=>"error", "code"=>400,"message"=>"Comment not created, incomplete data!"]);
                    }else
                     return $helpers->json_(["status"=>"error", "code"=>400,"message"=>"Parameters: json{video_id,body}"]);
            }else
            return $helpers->json_(["status"=>"error", "code"=>400,"message"=>"Authorization not valid!"]);
        }else
        return $helpers->json_(["status"=>"error", "code"=>400,"message"=>"Incomplete data!"]);

    }

/**Función para eliminar comentarios
//Requiere autorización
//Parameters: /video_id
**/
    public function deleteAction(Request $request,$id=null){
        $hash= $request->get('autorization',null);
        $helpers= $this->get('app.helpers');
        if($hash && !empty($hash))
        {
            $jwt= $this->get('app.jwt_auth');
            $checkAuth=$jwt->checkAuth($hash);
            if($checkAuth)
            {
                if(isset($id))
                {

                    $identity=$jwt->checkAuth($hash,true);
                    
                    $em = $this->getDoctrine()->getManager();

                    $comment= $em->getRepository("BackendBundle:Comment")->findOneBy(
                        ["idComment" => $id]);
                    
                    if(!isset($comment) && !is_object($comment))
                    return $helpers->json_(["status"=>"error", "message"=>"Comment incorrect"]);

                    //Comparamos si es el usuario creador del comentario o del video
                    if($comment->getIdUser()->getIdUser()==$identity->sub
                    || $comment->getIdVideo()->getIdUser()->getIdUser()==$identity->sub
                    )
                    {
                        $em->remove($comment);
                        $em->flush();
                        return $helpers->json_(["status"=>"success", "message"=>"Comment deleted!"]);

                    }else
                     return $helpers->json_(["status"=>"error", "code"=>400,"message"=>"Comment not deleted, user not valid!"]);
                }else
                 return $helpers->json_(["status"=>"error", "code"=>400,"message"=>"Parameters: /video_id"]);
            }else
            return $helpers->json_(["status"=>"error", "code"=>400,"message"=>"Authorization not valid!"]);
        }else
        return $helpers->json_(["status"=>"error", "code"=>400,"message"=>"Incomplete data!"]);

    }

/**Función para listar comentarios de un video
//No Requiere autorización
//Parameters: /video_id
**/
    public function listAction(Request $request,$id=null){
        $helpers= $this->get('app.helpers');
        $em=$this->getDoctrine()->getManager();
        $video= $em->getRepository('BackendBundle:Video')->findOneBy(
                        ["idVideo" => $id]);
        
        $comments= $em->getRepository('BackendBundle:Comment')->findBy(
                        ["idVideo" => $video]
                        ,["idComment"=>"desc"]
                        );
        
        if(count($comments)>0)
        {
        return $helpers->json_(["status"=>"success", "message"=>"Exist comments","data"=>$comments]);            
        }else
        return $helpers->json_(["status"=>"error", "code"=>400,"message"=>"Dont exist comments in this video!"]);
    }







}
