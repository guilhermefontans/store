<?php


namespace App\Controller;


use App\Entity\Address;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/save-address")
     */
    public function saveAddress()
    {

        $manager = $this->getDoctrine()->getManager();
        $user = new User();
        $user->setUpdatedAt(new \DateTimeImmutable());
        $user->setCreatedAt(new \DateTimeImmutable());
        $user->setEmail("teste@teste.com");
        $user->setFirstName("Fulano");
        $user->setLastName("de Tal");
        $user->setPassword("123");

        $address = new Address();
        $address->setAddress("meu endereço");
        $address->setCity("Minha cidade");
        $address->setNeighborhood("meu bairro");
        $address->setNumber(1423);
        $address->setState("RS");
        $address->setUser($user);
        $address->setZipcode("10010-100");

        $manager->persist($address);
        $manager->flush();

        return new Response("Salvou...");
    }

    /**
     * @Route("/save-user")
     */
    public function saveUser()
    {
        $manager = $this->getDoctrine()->getManager();
        $address = new Address();
        $address->setAddress("meu endereço");
        $address->setCity("Minha cidade");
        $address->setNeighborhood("meu bairro");
        $address->setNumber(1423);
        $address->setState("RS");
        $address->setZipcode("10010-100");

        $user = new User();
        $user->setUpdatedAt(new \DateTimeImmutable());
        $user->setCreatedAt(new \DateTimeImmutable());
        $user->setEmail("teste@teste.com");
        $user->setFirstName("Fulano");
        $user->setLastName("de Tal");
        $user->setPassword("123");
        $user->setAddress($address);

        $manager->persist($user);
        $manager->flush();

        return new Response("Salvou...");
    }

}