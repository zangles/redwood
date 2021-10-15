<?php

namespace Database\Seeders;

use App\Models\Player;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PlayerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nombres = ["DOLAPETV","Lete","Xanthios","Panaderoz","Rapthor","AGT","Add1end","Ambe","AndChe","Kovuh","Andriei","AntrusXee","Arvack","Berluz","Bonkisaurio","C4russian","CadiaNN","Campar","Chaloss","Chris the Beast","Dacee","Dahu","Dakanary","Dezon","Dieghost","DuelMasterX","El Peter","Epiri","Ericarlo","FEB17","Ganakor","FikShunGDz","Frixstan","Gewonnen","Golu41","Gonzo21","Gryhma","Hairen","Hazkill","Herodez","Jaroldo","JulitoRoca","Kanashis","Keygran","L4R4X","LadyBala","Lagerta Escudera","Lkzta","Lord Leftraru","Luchotron","M8DARINI","Mantequi","Miermelada","Morocha","N0TER","NelsanSapeee","Nikaiido","Oh Yeeah","Okruzhkov","Osquer","Pepejames","Piro","Porrens","Primeon","Rainbaw","Rikkuo","RobertiC1o","Scrz","SebaGGWP","Shanouwu","Shikimatute","Silvido","SopermiK1nG","SumoSK","Tarjaa","TheKata","TheKnightRox","UncleBaker","Wolwering","YOGURSIO","Yes, I'm dead","Yesmal","Yomap","ZMaximiliano","ZeBang","Zhukla","juansk8","latoxica","linkw0w","ouTNero","roNKaa","rusov1ch","spark64","xSony","yulliann","Haroldo","EicoSk","PANFULL","Dylan247","AgguslR","Agus Frolich","BET0R","BabySharkk","Bashyro","Clansuj","Draicons","Esk4nor","Ethereonn","EzequielDrax","Faqaldinho","Fefox","Fheitan","FRAGER","GodPix","ImBaTiBl3","Isaac Porthos","JORLLMX","JahRash","Keibron","KillRooy","Leoxz","LucasEstrella","MasterChivo","P1pelm3","PepeMujica","Rodsimo","Shawar","SimonEJ","SomanGOD","SverZ","Taito420","ThuG12","Tivenss","ViiTy","Wozaf","Yvory","Zaketoz","elpampa","Lindisse","Franryuu","WORWIK","Lemanich","Lilguini","TataPartuzero","Geraltexco","Tulonga","Yukizz","Skorzen","IronZeta","Puwerslide","Jerry","Radaggastt","CrimsonBeard","piltrafa","hotson","Princelot","Velkaan","fas7er","FSnipe7","Sir.Rodrinson","Rogthar","pumit","Yogger","Rathiem","TuT1","Polacoloco","PolaSJJ","LenoSSJ","Kneoxie"];

        foreach ($nombres as $nombre) {
            $id = DB::table('users')->insertGetId([
                'name' => $nombre,
                'email' => $nombre.'@gmail.com',
                'password' => Hash::make('password'),
                'current_team_id' => env('REDWOOD1_TEAM_ID')
            ]);

            DB::insert("insert into team_user (`team_id`,`user_id`,`role`) values(?,?,?)",
                [
                    env('REDWOOD1_TEAM_ID'),
                    $id,
                    'editor'
                ]
            );
        }
    }
}
