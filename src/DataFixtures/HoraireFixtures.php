<?php

namespace App\DataFixtures;

use App\Entity\Horaire;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class HoraireFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $horaires = 
            '<h2>Horaires d\'ouverture</h2>
            <table class="table">
            <thead>
                <tr>
                <th></th>
                <th></th>          
                </tr>          
            </thead>
            <tbody>
                <tr>
                    <td>Lundi</td>
                    <td>12:00 - 14:00<br>19:00 - 22:00</td
                </tr>
                <tr>
                    <td>Mardi</td>
                    <td>12:00 - 14:00<br>19:00 - 22:00</td
                </tr>
                <tr>
                    <td>Mercredi</td>
                    <td>fermé</td
                </tr>
                <tr>
                    <td>Jeudi</td>
                    <td>12:00 - 14:00<br>19:00 - 22:00</td
                </tr>
                <tr>
                    <td>Vendredi</td>
                    <td>12:00 - 14:00<br>19:00 - 22:00</td
                </tr>
                <tr>
                    <td>Samedi</td>
                    <td>12:00 - 14:00<br>19:00 - 23:00</td
                </tr>
                <tr>
                    <td>Dimanche</td>
                    <td>fermé</td
                </tr>         
            </tbody>
            </table>';
        $horaire = new Horaire();
        $horaire->setHoraires($horaires);
        $manager->persist($horaire);

        $manager->flush();
    }
}