<?php

namespace App\Http\Controllers;

use App\Models\Branch\Branch;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function randomName() {
        $addressF = [
            'Gulistan',
            'Paltan',
            'Motijhil',
            'Rampura',
        ];

        $firstname = array(
            'Johnathon',
            'Anthony',
            'Erasmo',
            'Raleigh',
            'Nancie',
            'Tama',
            'Camellia',
            'Augustine',
            'Christeen',
            'Luz',
            'Diego',
            'Lyndia',
            'Thomas',
            'Georgianna',
            'Leigha',
            'Alejandro',
            'Marquis',
            'Joan',
            'Stephania',
            'Elroy',
            'Zonia',
            'Buffy',
            'Sharie',
            'Blythe',
            'Gaylene',
            'Elida',
            'Randy',
            'Margarete',
            'Margarett',
            'Dion',
            'Tomi',
            'Arden',
            'Clora',
            'Laine',
            'Becki',
            'Margherita',
            'Bong',
            'Jeanice',
            'Qiana',
            'Lawanda',
            'Rebecka',
            'Maribel',
            'Tami',
            'Yuri',
            'Michele',
            'Rubi',
            'Larisa',
            'Lloyd',
            'Tyisha',
            'Samatha',
        );

        $lastname = array(
            'Mischke',
            'Serna',
            'Pingree',
            'Mcnaught',
            'Pepper',
            'Schildgen',
            'Mongold',
            'Wrona',
            'Geddes',
            'Lanz',
            'Fetzer',
            'Schroeder',
            'Block',
            'Mayoral',
            'Fleishman',
            'Roberie',
            'Latson',
            'Lupo',
            'Motsinger',
            'Drews',
            'Coby',
            'Redner',
            'Culton',
            'Howe',
            'Stoval',
            'Michaud',
            'Mote',
            'Menjivar',
            'Wiers',
            'Paris',
            'Grisby',
            'Noren',
            'Damron',
            'Kazmierczak',
            'Haslett',
            'Guillemette',
            'Buresh',
            'Center',
            'Kucera',
            'Catt',
            'Badon',
            'Grumbles',
            'Antes',
            'Byron',
            'Volkman',
            'Klemp',
            'Pekar',
            'Pecora',
            'Schewe',
            'Ramage',
        );

        $firstName = $firstname[rand ( 0 , count($firstname) -1)];
        $LastName = $lastname[rand ( 0 , count($lastname) -1)];

        return [
            'name' => $firstName . ' ' . $LastName,
            'email' => $firstName . '.' . $LastName . '@gmail.com',
            'address' => $addressF[rand ( 0 , count($addressF) -1)] . ' -  Dhaka',
        ];
    }

    public function index() {
        for($i = 0; $i <= 100; $i++) {
            $gen = $this->randomName();
            Branch::Insert([
                'IsActive' => 1,
                'IsDeleted' => 0,
                'Name' => $gen['name'],
                'Email' => $gen['email'],
                'ContactNumber' => time(),
                'Address' => $gen['address'],
            ]);
        }
    }
}
