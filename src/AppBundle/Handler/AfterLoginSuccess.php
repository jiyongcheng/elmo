<?php
namespace AppBundle\Handler;
use Acme\FiletrackerBundle\Entity\UserSession;
use AppBundle\Entity\Contractor;
use AppBundle\Entity\Employee;
use AppBundle\Service\UserRecorder;
use Doctrine\Common\Annotations\Reader;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\SecurityContext;

use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Routing\Router;
use Doctrine\Common\Util\ClassUtils;

class AfterLoginSuccess implements AuthenticationSuccessHandlerInterface{

    protected $router;
    private $context;
    private $em;
    private $reader;
    private $userLogger;

    public function __construct(TokenStorageInterface $context, Router $router, UserRecorder $userLogger,Reader $reader)
    {
        $this->context = $context;
        $this->userLogger = $userLogger;
        $this->router = $router;
        $this->reader = $reader;

    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        $user = $token->getUser();
        $this->userLogger->recordLogin($user);
        if($user->getType()){
            $checkUser = new Employee();
        }else {
            $checkUser = new Contractor();
        }
        $InternalUserAnnotation = 'AppBundle\Annotation\InternalUser';
        $classAnnotation = $this->reader->getClassAnnotation(
            new \ReflectionClass(ClassUtils::getClass($checkUser)), $InternalUserAnnotation
        );
        if($classAnnotation) {
            $url = $this->router->generate('employee');
        }else {
            $url = $this->router->generate('contract');
        }

        return new RedirectResponse($url);
    }
}