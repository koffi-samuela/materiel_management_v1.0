<?php

namespace App\Controller;
// Votre contrôleur ForgotPasswordController

use App\Repository\EmployeeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class ForgotPasswordController extends AbstractController
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    #[Route('/forgot_password', name: 'app_forgot_password')]
    public function index(Request $request, EmployeeRepository $employeeRepository): Response
    {
        if ($request->isMethod('POST')) {
            $formData = $request->request->all();
            // Vérifier que le champ 'username' est rempli
            if (!empty($formData['username'])) {
                $username = $formData['username'];
                $findUser = $employeeRepository->findOneBy(['username' => $username]);
                if ($findUser !== null) {
                    // Envoi de l'e-mail à l'administrateur
                    $email = (new Email())
                    ->subject('Demande de réinitialisation de mot de passe')
                    ->text('Demande de réinitialisation de mot de passe pour l\'utilisateur : ' . $findUser->getLastname() . ' ' . $findUser->getFirstname());
                    
                    $this->mailer->send($email);

                    // Rediriger l'utilisateur vers une page de confirmation
                    $this->addFlash('success', 'Votre demande a été soumise avec succès.');
                    return $this->redirectToRoute('app_login');
                } else {
                    // Gérer le cas où l'utilisateur n'est pas trouvé
                    $this->addFlash('error', 'Utilisateur non trouvé');
                }
            } else {
                // Gérer le cas où le champ 'username' est vide
                $this->addFlash('error', 'Veuillez fournir un nom d\'utilisateur');
            }
        }

        return $this->render('forgot_password/index.html.twig');
    }
}

