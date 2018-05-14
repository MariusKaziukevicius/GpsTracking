<?php

namespace App\Controller;

use App\Entity\Device;
use App\Service\AddressClient;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class DefaultController extends Controller
{
    public function index(Request $request, ValidatorInterface $validator, EntityManagerInterface $entityManager, AddressClient $addressClient): Response
    {
        $form = $this->createFormBuilder(null)
            ->add('deviceId', TextType::class)
            ->add('coordinates', TextType::class)
            ->add('locationType', ChoiceType::class, [
                'choices' => [
                    'Home' => 'home',
                    'Work' => 'work'
                ]
            ])
            ->add('send', SubmitType::class, ['label' => 'Send'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $data = $form->getData();

            $latLng = explode(",", str_replace("°", "", $data['coordinates']));
            $latitude = $latLng[0];
            if (isset($latLng[1])) {
                $longtitude = $latLng[1];
            } else {
                $longtitude = "";
            }

            $device = (new Device())
                ->setId($data['deviceId'])
                ->setLatitude((float)$latitude)
                ->setLongtitude((float)$longtitude)
                ->setLocationType($data['locationType']);

            $errors = $validator->validate($device);

            if (count($errors) < 1) {
                $address = $addressClient->getAddressByLatLng($device->getLatitude(), $device->getLongtitude());
                if ($address === null) {
                    $errors->add(new ConstraintViolation('Couldn\'t resolve coordinates to an address.', null, [], '', null, $address));
                } else {
                    $device->setAddress($address);
                }
            }

            if (count($errors) > 0) {
                return $this->render('home.html.twig', [
                    'device_form' => $form->createView(),
                    'errors' => $errors
                ]);
            } else {
                $entityManager->persist($device);
                $entityManager->flush();
                return new Response('Device added.');
            }
        }

        return $this->render('home.html.twig', [
            'device_form' => $form->createView()
        ]);
    }
}