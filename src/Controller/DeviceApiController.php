<?php

namespace App\Controller;

use App\Entity\Device;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DeviceApiController extends Controller
{
    public function getById(string $deviceId, EntityManagerInterface $entityManager): Response
    {
        $device = $entityManager->find('App\Entity\Device', $deviceId);

        if ($device !== null) {
            $jsonResponse = json_encode($device->serialize());
            $status = Response::HTTP_OK;
        } else {
            $jsonResponse = json_encode(['Device with the given ID does not exist.']);
            $status = Response::HTTP_NOT_FOUND;
        }

        return new Response($jsonResponse, $status, ['Content-Type', 'application/json']);
    }

    public function getAll(EntityManagerInterface $entityManager): Response
    {
        $devices = $entityManager->getRepository(Device::class)->findAll();

        $serializedDevices = [];
        /** @var Device $device */
        foreach ($devices as $device) {
            $serializedDevices[] = $device->serialize();
        }

        $jsonResponse = json_encode($serializedDevices);
        $status = Response::HTTP_OK;

        return new Response($jsonResponse, $status, ['Content-Type', 'application/json']);
    }
}