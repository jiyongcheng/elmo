<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/admin")
     */
    public function adminAction()
    {
        return $this->render('default/admin.html.twig');
    }


    /**
     * @Route("/login/success" , name="login_after")
     */
    public function loginSuccessAction()
    {
        $user= $this->get('security.token_storage')->getToken()->getUser();
//        $this->get('app.loguser')->recordLogin($user);
        return new Response('<html><body>this is success page!</body></html>');
    }

    /**
     * @Route("/contract" , name="contract")
     */
    public function contractAction()
    {
        return $this->render('default/contractor.html.twig');
    }

    /**
     * @Route("/employee" , name="employee")
     */
    public function employeeAction()
    {
        return $this->render('default/employee.html.twig');
    }
}
