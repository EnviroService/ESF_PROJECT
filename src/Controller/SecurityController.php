<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Security\LoginFormAuthenticator;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('user_show',['id' => $this->getUser()->getId(),
            ]);
        }
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/register", name="app_register")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param UserRepository $userRepository
     * @param EntityManagerInterface $entityManager
     * @return Response
     * @throws \Exception
     */
    public function register(
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        UserRepository $userRepository,
        EntityManagerInterface $entityManager
    ): Response
    {
        {

            $user = new User();
            $form = $this->createForm(RegistrationFormType::class, $user);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $user->setRoles(['ROLE_USER']);
                $user->setSignupDate(new DateTime('now'));
                $user->setSigninDate(new DateTime('now'));
                $user->setErpClient(0);
                $user->setJustifyDoc(0);
                $user->setBonusRateCard(0);
                $user->setBonusOption(0);
                $user->getId();

                /** @var UploadedFile $cniFile */
                $cniFile = $form->get('cni')->getData();

                $ext = $cniFile->getClientOriginalExtension();
                if ($ext != "pdf") {
                    $this->addFlash('danger', "Le fichier doit être de type .pdf. 
                Format actuel envoyé: .$ext");

                    return $this->redirectToRoute('app_register');
                }

                $destination = $this->getParameter('kernel.project_dir').'/public/uploads/cni/';
                $originalFilename = pathinfo($cniFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename . ".pdf";
                $cniFile->move(
                    $destination,
                    $newFilename
                );

                $kbisFile = $form->get('kbis')->getData();

                $ext = $kbisFile->getClientOriginalExtension();
                if ($ext != "pdf") {
                    $this->addFlash('danger', "Le fichier doit être de type .pdf. 
                Format actuel envoyé: .$ext");

                    return $this->redirectToRoute('app_register');
                }

                $destination = $this->getParameter('kernel.project_dir').'/public/uploads/kbis/';
                $originalFilename = pathinfo($kbisFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename . ".pdf";
                $kbisFile->move(
                    $destination,
                    $newFilename
                );

                $user->setCni($user==!empty($user));
                $user->setKbis($user==!empty($user));

                // encode the plain password
                $user->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        $form->get('password')->getData()
                    )
                );

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                if ($form)
                    $this->addFlash('success', "Votre demande d'ouverture de compte a bien été prise en compte, vous receverez un email lors de l'activation");

                return $this->redirectToRoute('index');

            }

            return $this->render('registration/register.html.twig', [
                'registrationForm' => $form->createView(),
            ]);
        }
}
}
