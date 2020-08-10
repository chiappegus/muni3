<?php

// src/Twig/AppExtension.php
namespace App\Twig;

use App\Entity\Persona;
use App\Repository\PersonaRepository;
use App\Service\UploaderHelper;
use App\Twig\AppExtensionUser;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtensionUser extends AbstractExtension
{
    private $uploaderHelper;
    private $guardHandler;
    private $personaRepository;
    private $securityChecker;
    private $security;

    public function __construct(UploaderHelper $uploaderHelper, GuardAuthenticatorHandler $guardHandler, PersonaRepository $personaRepository, AuthorizationCheckerInterface $securityChecker, Security $security)
    {

        $this->uploaderHelper    = $uploaderHelper;
        $this->guardHandler      = $guardHandler;
        $this->personaRepository = $personaRepository;
        $this->securityChecker   = $securityChecker;
        $this->security          = $security;

    }
    public function getFilters()
    {
        return [
            new TwigFilter('User', [$this, 'tiposUser']),
            new TwigFilter('UserID', [$this, 'tiposUserID']),
        ];
    }

    public function tiposUser($object, $role)
    {
        // $price = number_format($number, $decimals, $decPoint, $thousandsSep);
        // $price = '$' . $price;
        /*===============================
        =            en twig            =
        ===============================*/

        // <h3>{{ roles|User }}</h3>

        /* devuelve un string*/

        /*=====  End of en twig  ======*/

/*==========================================
=            es lo que hice yo             =
==========================================*/

        // if (in_array($comparar, $arr, true)) {

        //     return true;
        // } else {
        //     return false;

        // }

/*=====  End of es lo que hice yo   ======*/

/*=========================================
=            pero se hace asi       GOOD - use of the normal security methods       =
=========================================*/
        // BAD - $user->getRoles() will not know about the role hierarchy
        /*    $hasAccess = in_array('ROLE_ADMIN', $user->getRoles());*/

        // GOOD - use of the normal security methods
        /*  $hasAccess = $this->isGranted('ROLE_ADMIN');
        $this->denyAccessUnlessGranted('ROLE_ADMIN');*/

/*=====  End of pero se hace asi  esta bien lo de abajo pero no va el   return false

YA QUE ES BOOL:!!! ======*/

        //dd($this->securityChecker->isGranted($role, $object));

        // if (!$this->securityChecker->isGranted($role, $object)) {
        //     //throw $this->createAccessDeniedException('No access!');
        //     return false;

        // } else {
        //     return true;

        // }
        /*=====  End of pero se hace asi  YA QUE ES BOOL:!!! ======*/

        //dump($object);
        return $this->securityChecker->isGranted($role, $object);

    }

    public function tiposUserID($id, $role)
    {
        //dump($id, $role);

        // ojo $this->accessDecisionManager->decide($token, $attributes, $subject);
        //$this->personaRepository->find($id);
        //dump($id);
        $persona = new Persona();
        $persona = $this->personaRepository->findById($id);

        //dd($persona['0'])->getApiTokens();
        // dump($this->securityChecker->isGranted("ROLE_DURAZNO", $persona));
        // dump($this->security->isGranted('ROLE_DURAZNO', $persona));

        //  $hasAccess = $this->personaRepository->findById($id)->isGranted('ROLE_ADMIN');
        // dd($persona);
        //  $hasAccess = $persona->denyAccessUnlessGranted('ROLE_ADMIN');
        // dd($hasAccess);
        // dump($this->securityChecker->isGranted("ROLE_ADMIN", $persona));
        //  $arrd[] = $persona;
        // dump($persona['0']->getRoles()[0]);
        $rolesPersona = $persona['0']->getRoles();
        if (in_array('ROLE_DURAZNO', $rolesPersona, true)) {

            $rolesPersona[] = 'ROLE_ADMIN';
            $rolesPersona[] = 'ROLE_SUPRA';
            $rolesPersona[] = 'ROLE_USER';
            $rolesPersona[] = 'ROLE_VERDURA';
            //dd($rolesPersona, $persona['0']->getId());

        };

        if (in_array('ROLE_SUPRA', $rolesPersona, true)) {

            $rolesPersona[] = 'ROLE_ADMIN';
            $rolesPersona[] = 'ROLE_USER';
            //$rolesPersona[] = 'ROLE_SUPRA';
            $rolesPersona[] = 'ROLE_VERDURA';
            //dd($rolesPersona, $persona['0']->getId());

        };

        if (in_array('ROLE_ADMIN', $rolesPersona, true)) {

            $rolesPersona[] = 'ROLE_USER';
            //$rolesPersona[] = 'ROLE_SUPRA';
            $rolesPersona[] = 'ROLE_VERDURA';
            //dd($rolesPersona, $persona['0']->getId());

        };
        //$persona->getId();
        // dd($arr);

        // dump((in_array($role, $persona['0']->getRoles(), true)));
        //dump((in_array($role, $rolesPersona, true)));

        // dd($persona->getRoles()['0']);
        //return $this->securityChecker->isGranted($role, $persona);
        return in_array($role, $rolesPersona, true);

    }

}
