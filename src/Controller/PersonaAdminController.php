<?php

namespace App\Controller;

use App\Entity\Persona;
use App\Repository\PersonaRepository;
use Doctrine\Migrations\Generator\generate;
use Doctrine\ORM\EntityManagerInterface;
use Gedmo\Sluggable\Util\Urlizer;
use Knp\Component\Pager\PaginatorInterface;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Validator\Constraints as Assertion;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PersonaAdminController extends AbstractController
{

    private $router;
    private $em;

    public function __construct(
        RouterInterface $router, EntityManagerInterface $em
    ) {
        $this->router = $router;
        $this->em     = $em;

    }

    /**
     * @Route("/admin/personaSINPAGINATOR", name="persona_adminSINPAGINATOR")
     */
    public function indexSINPAGINATOR(PersonaRepository $personaRepository, Request $request)
    {

        $q = $request->query->get('q');

        /* $personas = $personaRepository->findBy([], ['id' => 'DESC']);
        'personas'           => $personaRepository->findAll(),
        dump($personas);*/
        //$personas = $personaRepository->findBy([], ['id' => 'DESC']);

        //dump($this->getUser());
        return $this->render('persona_admin/index.html.twig', [
            'personas'           => //$personaRepository->findBy([], ['dni' => 'asc']),
            $personaRepository->findByDNI($q),
            'nombre_controlador' => 'PersonaController',
        ]);

    }

    #PaginatorInterface Knp\Component\Pager\PaginatorInterface
    #https://github.com/KnpLabs/KnpPaginatorBundle

    /**
     * @Route("/admin/persona", name="persona_admin")
     */
    public function index(PersonaRepository $personaRepository, Request $request, PaginatorInterface $paginator)
    {

        $q = $request->query->get('q');

        /* $personas = $personaRepository->findBy([], ['id' => 'DESC']);
        'personas'           => $personaRepository->findAll(),
        dump($personas);*/
        //$personas = $personaRepository->findBy([], ['id' => 'DESC']);

        //dump($this->getUser());
        //$personas    = $personaRepository->findByDNI($q);
        $queyBuilder = $personaRepository->getwithQueryBuilder($q);

        $pagination = $paginator->paginate(
            $queyBuilder, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10/*limit per page*/
        );
        return $this->render('persona_admin/index.html.twig', [
            'pagination'         => //$personaRepository->findBy([], ['dni' => 'asc']),
            $pagination,
            'nombre_controlador' => 'PersonaController',
        ]);

    }

    /**
     * @Route("/admin/controlDni/{dni}", name="persona_admin_dni")
     */
    public function controlDni($dni = null, PersonaRepository $personaRepository, Request $request, LoggerInterface $logger)
    {
        $logger->info('Se esta Buscando por DNI , Function controlDni');
        $persona = $personaRepository->findBy(['dni' => $dni]);

        //dump(isset($persona[0]));

        return new JsonResponse(['valor' => isset($persona[0])]);
        //die();
        /*

        $q = $request->query->get('q');

        /* $personas = $personaRepository->findBy([], ['id' => 'DESC']);
        'personas'           => $personaRepository->findAll(),
        dump($personas);*/
        //$personas = $personaRepository->findBy([], ['id' => 'DESC']);

        //dump($this->getUser());

        /*
    return $this->render('persona_admin/index.html.twig', [
    'personas'           => //$personaRepository->findBy([], ['dni' => 'asc']),
    $personaRepository->findByDNI($q),
    'nombre_controlador' => 'PersonaController',
    ]);
     */
    }

    public function UpcomingEvents(PersonaRepository $personaRepository, Request $request, PaginatorInterface $paginator)
    {

        $q = $request->query->get('q');

        $queyBuilder = $personaRepository->getwithQueryBuilder($q);

        $pagination = $paginator->paginate(
            $queyBuilder, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10/*limit per page*/
        );
        return $this->render('persona_admin/cuadroBusqueda.html.twig', [
            'pagination'         => //$personaRepository->findBy([], ['dni' => 'asc']),
            $pagination,
            'nombre_controlador' => 'PersonaController',
        ]);

    }
    /**
     * @Route("/admin/actualizar/{dni}", name="andaTodoMal")
     */
    public function recentArticles($q = null, PersonaRepository $personaRepository, Request $request)
    {
        // make a database call or other logic
        // to get the "$max" most recent articlessetMaxResults(1)
        //$articles = ...;$entityManager->createQueryBuilder()->expr()->max($x);

        //https://symfony.com/doc/4.1/templating/embedding_controllers.html

        //https://stackoverflow.com/questions/42221356/simple-ajax-request-to-controller-symfony3

        //https://stackoverflow.com/questions/24446149/render-template-into-symfony2-with-ajax

        //https://stackoverflow.com/questions/24446149/render-template-into-symfony2-with-ajax

        if ($q == "") {
            //dump($q);
            $personas = $personaRepository->findBy([], ['id' => 'DESC'], 10, 0);

        } else {
            $personas = $personaRepository->findBy(['dni' => $q], ['id' => 'DESC'], 10, 0);

        }

        //$q = $request->query->get('q');
        //$q = $request->query->all();

        // $q = '26258210';

        // dd($q);
        //if (!$q == "") {
        //dd($q);
        //$personas = $personaRepository->findByDniINNER($q);

        return $this->render(
            'persona_admin/recent_list.html.twig',
            ['personas' => $personas]
        );
    }

    /**
     * @Route("/admin/arrayGus/{dni}", name="andaTodoMal")
     */
    public function arrayGus($dni, PersonaRepository $personaRepository, Request $request)
    {
        // make a database call or other logic
        // to get the "$max" most recent articlessetMaxResults(1)
        //$articles = ...;$entityManager->createQueryBuilder()->expr()->max($x);

        //https://symfony.com/doc/4.1/templating/embedding_controllers.html

        //https://stackoverflow.com/questions/42221356/simple-ajax-request-to-controller-symfony3

        //https://stackoverflow.com/questions/24446149/render-template-into-symfony2-with-ajax

        //https://stackoverflow.com/questions/24446149/render-template-into-symfony2-with-ajax

        if ($dni == "") {
            // dump($q);
            //$arrData = ['output' => 'here the result which will appear in div'];
            $personas = $personaRepository->findBy([], ['id' => 'DESC'], 10, 0);
            // return new JsonResponse($arrData);
            return $this->render(
                'persona_admin/recent_list.html.twig',
                ['personas' => $personas]
            );

        } else {
            //$personas = $personaRepository->findBy(['dni' => $dni]);
            $personas = $personaRepository->findBy(['dni' => $dni], ['id' => 'DESC'], 10, 0);

            if ($personas == null) {

                $personas = $personaRepository->findBy([], ['id' => 'DESC'], 10, 0);
                // return new JsonResponse($arrData);
                return $this->render(
                    'persona_admin/recent_list.html.twig',
                    ['personas' => $personas]
                );

            } else {

                // $arrData = ['output' => 'here the result which will appear in div'];
                $arrData = ['personas' => $personas];
                //$arrData = json_encode($personas);
                //return new JsonResponse($arrData);

                // return new JsonResponse([$arrData]);

                return $this->render(
                    'persona_admin/recent_list.html.twig',
                    ['personas' => $personas]
                );}
            // return new JsonResponse($arrData);

        }

    }

    /**
     * @Route("/admin/upload/test", name="upload_test")
     */
    public function temporaryUploadAction(Request $request)
    {
        /** @var UploadedFile $uploadedFile */
        $uploadedFile = $request->files->get('image');

        /*=================================
        =            seguridad            =

        ejemplo
        5e82c8297868a_01.jpg
        para path para saber bien en donde esta

        ahora al reves 01_dasdaa_jpg
        se usa Urlizer por lo espacion
        =================================*/

        $originalFileName = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);

        $newFileName = Urlizer::urlize($originalFileName) . '_' . uniqid() . '.' . $uploadedFile->guessExtension();

        /*=====  End of seguridad  ======*/

        // dd($request->files->get('image'));

        $destination = $this->getParameter('kernel.project_dir') . '/public/uploads';
        dd($uploadedFile->move($destination,
            $newFileName
        ));

    }

    /**
     * @Route("/admin/upload/testss", name="upload_test_GUS" , methods={"GET","POST"})
     */
    public function temporaryUploadActionss(Request $request, ValidatorInterface $validator)
    {

        if ($request->isXmlHttpRequest()) {

            /** @var UploadedFile $uploadedFile
             */
            $uploadedFile = $request->files->get('files');
            $directionOld = $request->request->get('directionOld');
            //dd($directionOld);

            if ($uploadedFile == null) {

                $this->addFlash('error', 'Archivo No Valido');
                $Persona = ['PersonaImagePath' => $directionOld];
                return $this->render(
                    'persona/_imagen_form.html.twig',
                    ['persona' => $Persona]
                );
            }
            /*==================================
            =            validator             =
            ==================================*/
            $errors = $validator->validate($uploadedFile, new Assertion\Image([
                //'minWidth'  => 200,
                //'maxWidth'  => 400,
                //'minHeight' => 200,
                //'maxHeight' => 400,
                'maxSize'   => '2M',
                //'maxSize'   => '1024k',
                'mimeTypes' => [
                    'image/*',
/*                    'application/pdf',
'application/msword',
'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
'application/vnd.openxmlformats-officedocument.presentationml.presentation',
'text/plain',*/
                ],
            ]));

            if ($errors->count() > 0) {
                // ($errors[0]->getMessage());
                $errors = $errors[0];
                $this->addFlash('error', $errors->getMessage());
                $Persona = ['PersonaImagePath' => $directionOld];
                return $this->render(
                    'persona/_imagen_form.html.twig',
                    ['persona' => $Persona]
                );

                // aca poner mejor enfasis :) y poner flash mensajes :)
                // https: //symfonycasts.com/screencast/symfony-uploads/mime-type-validation
            }

            /*=====  End of validator   ======*/

            /*=======================================
            =            nuevo validator   sin aplicacion
            faltaria           =
            =======================================*/
            /*
            $violations = $validator->validate(
            $uploadedFile,
            new File([
            'maxSize'   => '5M',
            'mimeTypes' => [
            'image/*',
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'text/plain',
            ],
            ])
            );*/

            /*=====  End of nuevo validator  ======*/

            else {

                $nombre       = $uploadedFile->getPathname();
                $mimeTypes    = $uploadedFile->getClientMimeType();
                $originalName = $uploadedFile->getClientOriginalName();
                $errores      = $uploadedFile->getErrorMessage();
                $size         = $uploadedFile->getSize();

                $originalFilename = pathinfo($originalName, PATHINFO_FILENAME);
                $newFileName      = Urlizer::urlize($originalFilename) . '_' . uniqid() . '.' . $uploadedFile->guessExtension();

                //$foo          = $request->query->get('imageFile');
                $uploadedFile->move($this->getParameter('kernel.project_dir') . '/public/TEMP', $newFileName);
                /* return new JsonResponse(['valor' => $nombre,
                'valors'                         => $mimeTypes,
                'errores'                        => $errores,
                'size'                           => $size,
                'newFileName'                    => $newFileName,
                'src'                            => '/public/TEMP/' . $newFileName,
                'nameOriginal'                   => $originalName]);
                 */
                // persona.PersonaImagePath
                // $Persona = ['PersonaImagePath' => '/muni/public/TEMP/' . $newFileName];
                // http://localhost/muni/public/TEMP/01-borrar_5ea9c7abadf50.png

                $patrón = '^muni^'; #^(10|172\.16|192\.168)\.#'

                if (preg_match($patrón, $_SERVER['PHP_SELF'])) {
                    $ruta = '/muni3/public/TEMP/';
                } else {
                    $ruta = '/TEMP/';

                }
                $Persona = ['PersonaImagePath' => $ruta . $newFileName];

                return $this->render(
                    'persona/_imagen_form.html.twig',
                    ['persona' => $Persona]
                );

            }} else {

            return new JsonResponse(['valor' => "me estas hakeando"]);
        }
//$form->handleRequest($request);

//$uri = $_SERVER['REQUEST_URI'];
        //$foo = $request->query->get('imageFile', 'originalName');
        // $foo = $request->files->get('imageFile');
        //$foo = $request->getPathInfo();
        //  echo 'The value of the "foo" parameter is: ' . $foo;

// return new JsonResponse($foo);

//return new JsonResponse(['valor' => $uploadedFile]);
        // dd($uploadedFile);

/*=================================
=            seguridad            =

ejemplo
5e82c8297868a_01.jpg
para path para saber bien en donde esta

ahora al reves 01_dasdaa_jpg
se usa Urlizer por lo espacion
=================================*/

//  $originalFileName = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);

// $newFileName = Urlizer::urlize($originalFileName) . '_' . uniqid() . '.' . $uploadedFile->guessExtension();

/*=====  End of seguridad  ======*/

// dd($request->files->get('image'));

//  $destination = $this->getParameter('kernel.project_dir') . '/public/uploads';
        //  dd($uploadedFile->move($destination,
        //       $newFileName
        //    ));

    }

/**
 * @Route("/aca", name="ruta_Admin")
 */
    public function FunctionName(Request $request)
    {
        dd($this->getParameter('kernel.project_dir'));
    }

    /**
     * @Route("/supra", name="switch_SUPRA",methods={"GET","POST"})
     * @IsGranted("ROLE_SUPRA")
     */

    public function supra($dni = null, PersonaRepository $personaRepository, Request $request, LoggerInterface $logger, PaginatorInterface $paginator)
    {
        $logger->info('Se esta Buscando por DNI , Function controlDni');
        $persona = $personaRepository->findBy(['dni' => $dni]);

        $role = $request->attributes->get('_is_granted');
        $role = $role[0];
        //dd($role->getAttributes());
        dump($role->getAttributes());

        /*    return new JsonResponse(['valor' => isset($persona[0]),
        'direccion'                      => $this->getParameter('kernel.project_dir'),
        "RoutePermison"                  => $request->attributes->get('_route'),
        'Permision'                      => $role->getAttributes(),
        ]);

        return $this->render('persona/index.html.twig', [
        'personas'           => $personaRepository->findAll(),
        'nombre_controlador' => 'PersonaController',
        ]);*/

        //$queyBuilder = $personaRepository->getwithQueryBuilder($q);

        $pagination = $paginator->paginate(
            $personaRepository->findAll(), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10/*limit per page*/
        );

        return $this->render('persona_admin/supra.html.twig', [
            'pagination'         => //$personaRepository->findBy([], ['dni' => 'asc']),
            $pagination,
            'nombre_controlador' => 'PersonaController',
        ]);

    }

    /**
     * @Route("/facebook", name="facebook",methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_ANONYMOUSLY")
     */

    public function facebook(PersonaRepository $personaRepository, Request $request, LoggerInterface $logger, PaginatorInterface $paginator)
    {
        $logger->info('Se esta Buscando por DNI , Function controlDni');
        //@IsGranted("IS_AUTHENTICATED_ANONYMOUSLY")
        // dd($request);
        //dd($router);
        $facebook = $request->query->all();
        //$request->attributes->get('_is_granted');
        // dd($facebook["facebook"]["nombre"], $request->attributes->get('facebook'), array_key_first($facebook));

        //dd($facebook);

        // $persona = $personaRepository->findBy(['dni' => $dni]);

        // $role = $request->attributes->get('_is_granted');
        // $role = $role[0];
        // //dd($role->getAttributes());
        // dump($role->getAttributes());

        // $pagination = $paginator->paginate(
        //     $personaRepository->findAll(), /* query NOT result */
        //     $request->query->getInt('page', 1), /*page number*/
        //     10/*limit per page*/
        // );

        // return $this->render('persona_admin/supra.html.twig', [
        //     'pagination'         => //$personaRepository->findBy([], ['dni' => 'asc']),
        //     $pagination,
        //     'nombre_controlador' => 'PersonaController',
        // ]);

        //      "facebook" => array:5 [▼
        // "nombre" => "Gustavo"
        // "email" => "ellocolocro@hotmail.com"
        // "apellido" => "Chiappe"
        // "foto_ruta" => "https://platform-lookaside.fbsbx.com/platform/profilepic/?asid=10158227387394342&height=200&width=200&ext=1597366882&hash=AeSAJ_mxuZVi4pUV"
        // "id_facebook" => "10158227387394342"
        //dd($facebook);
        return new RedirectResponse($this->router->generate('persona_new', [
            'facebook' => [
                'nombre'      => $facebook["facebook"]["nombre"],
                'email'       => $facebook["facebook"]["email"],
                'apellido'    => $facebook["facebook"]["apellido"],
                'foto_ruta'   => 'https://graph.facebook.com/$facebook/' . $facebook["facebook"]["id_facebook"] . '/picture?type=normal',
                //'foto_ruta'   => $facebook["facebook"]["foto_ruta"],
                //'foto_ruta'   => $facebook["facebook"]["foto_ruta"],
                'id_facebook' => $facebook["facebook"]["id_facebook"]],

        ]));
        // persona_new
        //return null;
        //        10158227387394342 / picture ? type = normal
    }

    /**
     * @Route("/RolesSupra", name="ROLES_CHANGES",methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function RolesSupra($dni = null, PersonaRepository $personaRepository, Request $request, LoggerInterface $logger, PaginatorInterface $paginator)
    {
        $logger->info('Se esta Buscando por DNI , Function controlDni');
        $persona = $personaRepository->findBy(['dni' => $dni]);

        $role = $request->attributes->get('_is_granted');
        $role = $role[0];
        //dd($role->getAttributes());

        // $query = $this->em->createQuery("SELECT DISTINCT p.roles  FROM  App\Entity\Persona p ")->getResult();
        //dd($query);

        //dd($personaRepository->Unicosroles()[0]['roles'], 'aca roles');
        //dump($role->getAttributes());
        // dump($role->getAttributes());

        /*    return new JsonResponse(['valor' => isset($persona[0]),
        'direccion'                      => $this->getParameter('kernel.project_dir'),
        "RoutePermison"                  => $request->attributes->get('_route'),
        'Permision'                      => $role->getAttributes(),
        ]);

        return $this->render('persona/index.html.twig', [
        'personas'           => $personaRepository->findAll(),
        'nombre_controlador' => 'PersonaController',
        ]);*/

        //$queyBuilder = $personaRepository->getwithQueryBuilder($q);

        $q           = $request->query->get('q');
        $queyBuilder = $personaRepository->getwithQueryBuilder($q);
        $pagination  = $paginator->paginate(
            $queyBuilder, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10/*limit per page*/
        );
        $rolesMio[] = $role->getAttributes();
        //$roles      = $personaRepository->Unicosroles()[0]['roles'];
        $roless = $personaRepository->Unicosroles();
        // var_dump(count($roless));
        $rolesTotales;
        foreach ($roless as $key => $value) {
            if ($roless[$key]['roles'] != null) {
                $rolesTotales[$key] = $roless[$key]['roles'][0];
            }

        };

        //dump($rolesTotales);

        //dump(array_unique($roless));
        //dump('cacac', array_unique($roless));
        //dump('dsaasdads', $roless);
        //var_dump($roles, 'fin');
        //var_dump($rolesMio);
        // $diferencia = array_diff_assoc(array_unique($roless), $rolesMio);
        //var_dump($diferencia);
        // dump('diff 1', $diferencia);
        /*==============================
        =            aca va            =
        ==============================*/

        $diferencia = array_diff_assoc($rolesTotales, $rolesMio);
        // dump('diff 0', $diferencia);

        /*=====  End of aca va  ======*/

        $rolesMios[] = $role->getAttributes();
        $rolesMios[] = 'ROLE_USER';
        //  dump($rolesMios);

        $diferencia = array_diff_assoc($rolesTotales, $rolesMios);
        //   dump('diff 0', $diferencia);

        $rolesTotales[] = 'ROLE_USER';

        $rolUser = $request->attributes->get('_is_granted');

        //  dump('tus permisos', $rolUser);

        /*================================
        =            asi va :            =
        ================================*/

        // este es la manera correcta primero traer todos los permisos
        // y luego comparar los otros
        /* $diferencia = array_diff_assoc($roles, $rolesMios);
        dump('diff 0', $diferencia);
         */
        /*=====  End of asi va :  ======*/

        /*   $diferencia = array_diff_assoc($rolesMios, $roles);
        dump('diff 0', $diferencia);*/
        // $pagination = $paginator->paginate(
        //     $personaRepository->findAll(), /* query NOT result */
        //     $request->query->getInt('page', 1), /*page number*/
        //     10/*limit per page*/
        // );

        return $this->render('persona_admin/RolesSupra.html.twig', [
            'pagination'         => //$personaRepository->findBy([], ['dni' => 'asc']),
            $pagination,
            'nombre_controlador' => 'PersonaController',
            'roles'              => $rolesTotales,
            'rolesUser'          => $rolUser,
        ]);

    }

}
