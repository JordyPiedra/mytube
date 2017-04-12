<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }

    public function pruebasAction(Request $request)
    {
        // replace this example code with whatever you need
       /* $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('BackendBundle:User')->findAll();
        $helpers = $this->get('app.helpers');
        return $helpers->json_($users);
        */
        $helpers = $this->get('app.helpers');
        $jwt_auth = $this->get('app.jwt_auth');

        $hash=$request->get('autorization',null);
        $checkToken=$jwt_auth->checkAuth($hash);
        var_dump($checkToken);
        die();
    }
    /**
     * @Route("/login", name="login")
     * parameters: json
     *          email: email de usuario
     *          password: contraseña de usuario
     *          gethash: hash de token     
     */
    public function loginAction(Request $request){
        //Servicios
        $helpers = $this->get('app.helpers');
        $jwt_auth = $this->get('app.jwt_auth');

        $json=$request->get("json",null);
   
      // var_dump($request->request->all());
      // die();
        if($json != null)
        {
            $params = json_decode($json);
            $email= (isset($params->email)) ? $params->email : null;
            $password= (isset($params->password)) ? $params->password : null;
            $gethash= (isset($params->gethash)) ? $params->gethash : null;

            $emailConstraint = new Assert\Email();
            $emailConstraint ->message = "This email is not valid!";
            $validate_email=$this->get('validator')->validate($email,$emailConstraint);
            if(count($validate_email) ==0 && isset($password) && !empty($password)){
                 
                 if($gethash || $gethash ==true)
                 $signup=$jwt_auth->signup($email,$password,true);
                 else
                 $signup=$jwt_auth->signup($email,$password);
                 //return $helpers->json_($signup);
                 return new \Symfony\Component\HttpFoundation\JsonResponse($signup);
            }else
                return $helpers->json_(['status' => 'error', 'data'=> 'Login not valid!']);
          

        }
        else
        {
            return $helpers->json_(['status' => 'error', 'data'=> 'Send json with POST!']);
        }
        
    }



}
