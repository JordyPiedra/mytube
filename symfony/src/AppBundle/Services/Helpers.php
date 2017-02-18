<?php
namespace AppBundle\Services;
class Helpers{


    public function json_($data){
        $normalize= array(new \Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer());    
        $encode = array ("json" => new \Symfony\Component\Serializer\Encoder\JsonEncoder());
        $serialize=new \Symfony\Component\Serializer\Serializer($normalize,$encode);
        $json = $serialize->serialize($data,'json');
        $response = new \Symfony\Component\HttpFoundation\Response();
        $response ->setContent($json);
        return $response;
    }

}

?>