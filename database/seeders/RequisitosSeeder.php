<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RequisitosSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('requisitos')->insert([
            'cod_requisitos' => 1,
            'requisitos' => '<p>Para inscribirte a un curso de educación continua tienes que seguir los siguientes requisitos:</p><ol><li>Debes crear un cuenta para que inicies sesión.</li><li>Una vez que hallas iniciado sesión podrás inscribirte a un curso.</li><li>Para inscribirte sencillamente deberás seleccionar un curso presionado el botón de inscríbete.</li><li>Se te cargarán los datos del curso.</li><li>Luego presionaras el botón de inscribirte.</li><li>Deberás subir un escaneado de tu cédula en formato PDF como requisito del curso.</li><li>Una vez inscrito tendrás el listado de los cursos en la sección del menú “Mis Curso” donde podrás revisar los estados del curso inscrito, ya que queda en estado pendiente y debes esperar que el gestor apruebe.</li><li>Desde ahí notarás los estados del curso y el botón respectivo de la acción.</li></ol><p>Para una mejor comprensión <a href="https://www.youtube.com/watch?v=nSrCFHfgkHE">has clic en este enlace del video</a></p>'
        ]);
    }
}
