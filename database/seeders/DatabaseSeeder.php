<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Evento;
use App\Models\PresencaCulto;
use App\Models\Visitante;
use App\Models\EbdRegistro;
use App\Models\CelestialRegistro;
use App\Models\TurmaDoutrinaria;
use App\Models\CandidatoBatismo;
use App\Models\PresencaDoutrinaria;
use App\Models\Oferta;
use App\Models\Despesa;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        /* -------------------------------------------------------
           TURMA DOUTRINÁRIA
        ------------------------------------------------------- */
        $turma = TurmaDoutrinaria::create([
            'nome'                 => 'Turma Pentecostes 2025',
            'professor'            => 'Diác. Manuel Sebastião',
            'sala'                 => 'Sala 2 — Piso Superior',
            'data_inicio'          => '2025-03-02',
            'data_fim_prevista'    => '2025-06-22',
            'total_aulas_previstas'=> 12,
            'aula_atual'           => 6,
            'data_batismo_prevista'=> '2025-07-06',
            'ativa'                => true,
        ]);

        /* Candidatos angolanos */
        $candidatosData = [
            ['Ana Beatriz Teixeira',  '923 456 789', '2000-03-14', '2025-03-02', false, [1,1,1,1,1,1]],
            ['Domingos Luvualu',      '912 345 678', '1998-07-22', '2025-03-02', false, [1,1,0,1,1,1]],
            ['Esperança Kiala',       '934 567 890', '2002-11-05', '2025-03-02', false, [1,0,1,1,0,1]],
            ['Fernando Ngola',        '945 678 901', '1995-04-18', '2025-03-02', false, [1,1,1,0,1,1]],
            ['Graça Mutombo',         '956 789 012', '2003-09-30', '2025-04-06', true,  [1,1,1]],
            ['Hélio Bumba',           '967 890 123', '1999-01-25', '2025-03-02', false, [1,0,0,1,0,1]],
            ['Inês Catumba',          '978 901 234', '2001-06-12', '2025-04-06', true,  [1,0,1]],
            ['João Mavinga',          '989 012 345', '1997-12-08', '2025-03-02', false, [1,1,1,1,1,1]],
        ];

        $provincias = ['Luanda','Luanda','Luanda','Bengo','Luanda','Malanje','Luanda','Luanda'];
        $bairros    = ['Rangel','Cazenga','Sambizanga','Viana','Kilamba','Cacuaco','Talatona','Ingombota'];

        foreach ($candidatosData as $i => $row) {
            [$nome, $tel, $nasc, $matric, $novo, $historico] = $row;

            $presencas = array_sum($historico);
            $faltas    = count($historico) - $presencas;
            $pct       = count($historico) > 0 ? round($presencas / count($historico) * 100, 2) : 0;

            $c = CandidatoBatismo::create([
                'turma_id'          => $turma->id,
                'nome'              => $nome,
                'telefone'          => $tel,
                'data_nascimento'   => $nasc,
                'data_matricula'    => $matric,
                'is_novo'           => $novo,
                'status'            => 'ativo',
                'total_presencas'   => $presencas,
                'total_faltas'      => $faltas,
                'percentual_presenca'=> $pct,
                'bairro'            => $bairros[$i],
                'provincia'         => $provincias[$i],
            ]);

            /* Presenças por aula */
            $dataAula = Carbon::parse('2025-03-02');
            foreach ($historico as $aulaNum => $pres) {
                PresencaDoutrinaria::create([
                    'turma_id'    => $turma->id,
                    'candidato_id'=> $c->id,
                    'aula_numero' => $aulaNum + 1,
                    'data_aula'   => $dataAula->copy(),
                    'presente'    => (bool)$pres,
                ]);
                $dataAula->addDays(7);
            }
        }

        /* -------------------------------------------------------
           CULTOS + EBD + CELESTIAL + OFERTAS
        ------------------------------------------------------- */
        $domingo = Carbon::parse('2025-03-02');

        $cultosDados = [
            ['Pr. António Mukendi',  'O Poder da Ressurreição',          155, 38, 28, 640000,  195000, 65000 ],
            ['Pr. Rui Lopes',        'Fé que Move Montanhas',             162, 42, 31, 710000,  225000, 80000 ],
            ['Ev. Filomena Cardoso', 'Graça e Misericórdia do Senhor',    148, 35, 27, 580000,  180000, 55000 ],
            ['Pr. António Mukendi',  'A Igreja que Deus Deseja',          171, 45, 33, 820000,  260000, 90000 ],
            ['Pr. David Mateus',     'Santificação e Vida Cristã',        159, 40, 29, 690000,  210000, 70000 ],
            ['Pr. António Mukendi',  'Pentecostes — O Espírito Santo',    188, 52, 35, 950000,  310000, 110000],
        ];

        $pregadoresEbd = [
            'Diác. Manuel Sebastião', 'Profa. Rosa Quiala', 'Diác. Manuel Sebastião',
            'Pb. Luísa Ngola',        'Diác. Manuel Sebastião', 'Profa. Rosa Quiala',
        ];
        $temasEbd = [
            'Fundamentos da Fé Cristã',
            'O Baptismo nas Águas — Significado e Propósito',
            'A Oração como Fundamento da Vida Cristã',
            'Dízimos e Ofertas — Princípios Bíblicos',
            'A Segunda Vinda de Cristo',
            'Vida em Comunidade — A Igreja de Actos',
        ];

        foreach ($cultosDados as $idx => $d) {
            [$pregador, $tema, $adt, $adol, $cri, $dinheiro, $transf, $cartao] = $d;

            $evento = Evento::create([
                'data'           => $domingo->copy(),
                'tipo_evento'    => 'culto_dominical',
                'horario_inicio' => '09:00',
                'horario_fim'    => '11:30',
                'pregador'       => $pregador,
                'tema_culto'     => $tema,
            ]);

            PresencaCulto::create([
                'evento_id'   => $evento->id,
                'adultos'     => $adt,
                'adolescentes'=> $adol,
                'criancas'    => $cri,
            ]);

            EbdRegistro::create([
                'evento_id'      => $evento->id,
                'professor'      => $pregadoresEbd[$idx],
                'tema'           => $temasEbd[$idx],
                'total_presentes'=> (int)(($adt + $adol) * 0.78),
            ]);

            CelestialRegistro::create([
                'evento_id'        => $evento->id,
                'total_criancas'   => $cri,
                'total_professores'=> 4,
            ]);

            Oferta::create([
                'evento_id'          => $evento->id,
                'tipo'               => 'Oferta de Louvor',
                'valor_dinheiro'     => $dinheiro,
                'valor_transferencia'=> $transf,
                'valor_cartao'       => $cartao,
                'valor_total'        => $dinheiro + $transf + $cartao,
                'moeda'              => 'AOA',
            ]);

            $domingo->addDays(7);
        }

        /* -------------------------------------------------------
           VISITANTES
        ------------------------------------------------------- */
        $visitantesData = [
            ['Maria Conceição dos Santos', '923 111 222', 'adulto',      'Convite de familiar',     true,  'pendente',    'Rangel',     'Luanda'],
            ['Carlos Alberto Neto',        '912 222 333', 'adulto',      'Redes sociais',           true,  'pendente',    'Cazenga',    'Luanda'],
            ['Luísa Fernanda Mbala',       '934 333 444', 'adulto',      'Convite de amigo',        false, 'acompanhado', 'Sambizanga', 'Luanda'],
            ['Pedro Augusto Kapango',      '945 444 555', 'adolescente', 'Convite de familiar',     true,  'acompanhado', 'Viana',      'Luanda'],
            ['Filomena Joaquina Luís',     '956 555 666', 'adulto',      'Passou pela frente',      false, 'convertido',  'Kilamba',    'Luanda'],
            ['Euclides Manuel Teixeira',   '967 666 777', 'adulto',      'Buscador online',         true,  'acompanhado', 'Talatona',   'Luanda'],
            ['Rosa Benvinda Luvualu',      '978 777 888', 'adulto',      'Convite de amigo',        false, 'pendente',    'Ingombota',  'Luanda'],
            ['António Dias Mavinga',       '989 888 999', 'adulto',      'Transmissão online',      true,  'acompanhado', 'Cacuaco',    'Luanda'],
        ];

        $dataVisita = Carbon::now()->subDays(28);
        foreach ($visitantesData as $v) {
            Visitante::create([
                'nome'           => $v[0],
                'telefone'       => $v[1],
                'tipo'           => $v[2],
                'como_conheceu'  => $v[3],
                'primeira_visita'=> $v[4],
                'status'         => $v[5],
                'acompanhado'    => in_array($v[5], ['acompanhado','convertido']),
                'data_visita'    => $dataVisita->copy(),
                'bairro'         => $v[6],
                'provincia'      => $v[7],
            ]);
            $dataVisita->addDays(4);
        }

        /* -------------------------------------------------------
           DESPESAS
        ------------------------------------------------------- */
        $despesasData = [
            ['2025-03-05', 'Factura de energia eléctrica',    'Utilidades',  45000,  'multicaixa'],
            ['2025-03-10', 'Material de limpeza',             'Material',    18500,  'dinheiro'  ],
            ['2025-03-15', 'Manutenção do templo',            'Manutenção',  85000,  'transferencia'],
            ['2025-03-20', 'Internet e comunicações',         'Utilidades',  12000,  'multicaixa'],
            ['2025-04-05', 'Factura de energia eléctrica',    'Utilidades',  47000,  'multicaixa'],
            ['2025-04-08', 'Material didáctico EBD',          'Material',    22000,  'dinheiro'  ],
            ['2025-04-12', 'Lanche para obreiros',            'Eventos',     15000,  'dinheiro'  ],
            ['2025-04-18', 'Manutenção sistema de som',       'Manutenção',  60000,  'transferencia'],
            ['2025-05-05', 'Factura de energia eléctrica',    'Utilidades',  49000,  'multicaixa'],
            ['2025-05-08', 'Material de limpeza',             'Material',    19500,  'dinheiro'  ],
            ['2025-05-12', 'Manutenção do templo',            'Manutenção',  90000,  'transferencia'],
            ['2025-05-18', 'Internet e comunicações',         'Utilidades',  12000,  'multicaixa'],
            ['2025-05-22', 'Impressões e publicações',        'Material',     8500,  'dinheiro'  ],
            ['2025-05-25', 'Combustível — transporte',        'Outros',      25000,  'dinheiro'  ],
        ];

        foreach ($despesasData as $d) {
            Despesa::create([
                'data'           => $d[0],
                'descricao'      => $d[1],
                'categoria'      => $d[2],
                'valor'          => $d[3],
                'moeda'          => 'AOA',
                'forma_pagamento'=> $d[4],
            ]);
        }
    }
}
