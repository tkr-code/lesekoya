<?php
namespace App\Security;
use App\Entity\Personne;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use KnpU\OAuth2ClientBundle\Security\Authenticator\SocialAuthenticator;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use League\OAuth2\Client\Provider\GoogleUser;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class GoogleAuthenticator extends SocialAuthenticator{
    private $clientRegistry;
    private $em;
    private $router;

    public function __construct(RouterInterface $routerInterface, ClientRegistry $clientRegistry, EntityManagerInterface $entityManagerInterface)
    {
        $this->router = $routerInterface;
        $this->em = $entityManagerInterface;
        $this->clientRegistry = $clientRegistry;
    }

    public function supports(Request $request)
    {
        return $request->getPathInfo() == '/connect/google/check' && $request->isMethod('GET');
    }

    public function getCredentials(Request $request)
    {
        return $this->fetchAccessToken($this->getGoogleClient());
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        /** @var GoogleUser #googleUser */
        $googleUser = $this->getGoogleClient()
        ->fetchUserFromToken($credentials);

        $email = $googleUser->getEmail();

        $user = $this->em->getRepository('App:User')->findOneBy(['email'=>$email]);
        if(!$user){
            $personne = new Personne();
            $personne->setLastName($googleUser->getLastName())->setFirstName($googleUser->getFirstName());
            $user = new User();
            $user->setEmail($googleUser->getEmail());
            $user->setPersonne($personne);

            $this->em->persist($user);
            $this->em->flush();
        }
        return $user;
    }
    public function getGoogleClient(){
        return $this->clientRegistry->getClient('google');
    }

    public function start(Request $request, ?AuthenticationException $authException = null)
    {
        return new RedirectResponse("/login");
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $providerKey)
    {
        
    }
}