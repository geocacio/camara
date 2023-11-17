<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Office;
use App\Models\OmbudsmanPage;
use App\Models\PartyAffiliation;
use App\Models\TransparencyGroup;
use App\Models\TransparencyPortal;
use App\Models\Type;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TransparencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $transparencyPortal = TransparencyPortal::create([
            'title' => 'Bem-vindo ao nosso portal da transparência',
            'description' => 'Caso não encontre o que está procurando nas opções logo abaixo, você pode clicar em pesquisa avançada para encontrar algo mais detalhado.',
            'slug' => Str::slug('Portal da Transparência')
        ]);

        TransparencyGroup::create([
            'transparency_id' => $transparencyPortal->id,
            'title' => 'Canais de atendimento',
            'description' => 'Lei Nº 12.527 (Acesso a Informação) - Lei Nº 13.460 (Carta de Serviços)',
            'slug' => Str::slug('Portal da Transparência')
        ]);

        $officies = [
            'Cargo',
            'PRESIDENTE',
            'VICE-PRESIDENTE',
            '1º SECRETÁRIO',
            '2º SECRETÁRIO',
            'VEREADOR (A)',
            'OUVIDORA',
            'ASSISTENTE LEGISLATIVO',
            'TESOUREIRO',
            'CHEFE DE ARQUIVO GERAL',
            'CHEFE DE GABINETE DA PRESIDÊNCIA',
            'ASSESSOR ADMINISTRATIVO ',
            'ASSESSOR PARLAMENTAR',
            'CONTROLADORA INTERNA',
            'DIRETORA ADMINISTRATIVA',
            'MOTORISTA',
            'AUXILIAR ADMINISTRATIVO',
        ];
        foreach ($officies as $office) {
            Office::create([
                'office' => $office,
                'slug' => $office,
            ]);
        }

        $law = Type::create([
            'name' => 'Laws',
            'slug' => Str::slug('Laws')
        ]);

        Type::create([
            'name' => 'Lei Municipal',
            'parent_id' => $law->id,
            'slug' => Str::slug('Lei Municipal')
        ]);

        $competency = Category::create([
            'name' => 'Competências',
            'slug' => Str::slug('Competências')
        ]);
        Category::create([
            'name' => 'Janeiro',
            'parent_id' => $competency->id,
            'slug' => Str::slug('Janeiro')
        ]);

        $office = Category::create([
            'name' => 'Exercícios',
            'slug' => Str::slug('Exercícios')
        ]);
        Category::create([
            'name' => '2023',
            'parent_id' => $office->id,
            'slug' => Str::slug('2023')
        ]);

        $typeLeaf = Category::create([
            'name' => 'Tipo de folha',
            'slug' => Str::slug('Tipo de folha')
        ]);
        Category::create([
            'name' => 'Plantão',
            'parent_id' => $typeLeaf->id,
            'slug' => Str::slug('Plantão')
        ]);

        $group = Category::create([
            'name' => 'Grupos',
            'slug' => Str::slug('Grupos')
        ]);
        Category::create([
            'name' => 'Autorização ambiental',
            'parent_id' => $group->id,
            'slug' => Str::slug('Autorização ambiental')
        ]);

        $serviceLetter = Category::create([
            'name' => 'Cartas de Serviços',
            'slug' => Str::slug('Cartas de Serviços')
        ]);
        Category::create([
            'name' => 'Atendimento',
            'parent_id' => $serviceLetter->id,
            'slug' => Str::slug('Atendimento')
        ]);

        $expedients = Category::create([
            'name' => 'Expedientes',
            'slug' => Str::slug('Expedientes')
        ]);
        $expedientes = ['Ordem do dia', 'Pequeno expediente', 'Grande expediente'];
        foreach ($expedientes as $item) {
            Category::create([
                'name' => $item,
                'parent_id' => $expedients->id,
                'slug' => Str::slug($item)
            ]);
        }
        
        Category::create([
            'name' => '2023',
            'parent_id' => $expedients->id,
            'slug' => Str::slug('2023')
        ]);

        $vinculo = Category::create([
            'name' => 'Vínculo',
            'slug' => Str::slug('Vínculo')
        ]);

        $vinculos = [
            'MESA DIRETORA',
            'VEREADOR EM EXERCÍCIO',
            'VEREADOR LICENCIADO',
            'EX-VEREADOR',
            'SERVIDORES',
            'VEREADOR SUPLENTE',
            'VEREADOR AFASTADO',
        ];

        foreach ($vinculos as $item) {
            Category::create([
                'name' => $item,
                'parent_id' => $vinculo->id,
                'slug' => Str::slug($item)
            ]);
        }

        $status = Category::create([
            'name' => 'Status',
            'slug' => Str::slug('Status')
        ]);
        $statusArray = [
            'ARQUIVADO',
            'EM TRAMITAÇÃO',
            'APROVADA',
            'NÃO APROVADA',
            'ENCAMINHADA AO ÓRGÃO COMPETENTE',
            'PEDIDO DE VISTO',
            '1º TURNO DE VOTAÇÃO',
            '2º TURNO DE VOTAÇÃO',
            'RETIRADA PELO O AUTOR',
            'LEITURA',
            'EMENDA CONSTITUCIONAL',
            'VOTAÇÃO',
            'RETIRADA DE PAUTA',
            'ENCAMINHADO ÀS COMISSÕES',
            'CANCELADA',
            'RETIRADA',
            'REIRADA DA MATÉRIA',
            'AGUARDANDO EMENDA',
        ];
        $this->storeCategories($status->id, $statusArray);

        $material = Type::create([
            'name' => 'Materials',
            'slug' => Str::slug('Materials')
        ]);
        $materiais = [
            'ATA DA SESSÃO ANTERIOR',
            'CÉDULA DE VOTAÇÃO PARA PRESIDÊNCIA',
            'DECRETO LEGISLATIVO',
            'EMENDA A LEI ORGÂNICA',
            'INDICAÇÃO',
            'MOÇÃO DE APLAUSO',
            'MOÇÃO DE APOIO',
            'MOÇÃO DE PESAR',
            'MOÇÃO DE REPÚDIO',
            'PRESTAÇÃO DE CONTAS DE GOVERNO',
            'PROJETO DE DECRETO LEGISLATIVO',
            'PROJETO DE LEI - EXECUTIVO',
            'PROJETO DE LEI - LEGISLATIVO',
            'PROJETO DE LEI COMPLEMENTAR',
            'PROJETO DE RESOLUÇÃO',
            'PROPOSTA DE EMENDA A LEI ORGÂNICA',
            'REGIMENTO INTERNO ',
            'REQUERIMENTO',
            'RESOLUÇÃO',
            'VETO ',
        ];
        $this->storeTypes($material->id, $materiais);

        $session = Type::create([
            'name' => 'Sessions',
            'slug' => Str::slug('Sessions')
        ]);
        $sessoes = [
            'ORDINÁRIA',
            'EXTRAORDINÁRIA',
            'AUDIÊNCIA PÚBLICA',
            'SOLENE',
            'ABERTURA DE PERÍODO LEGISLATIVO',
            'ENCERRAMENTO DE PERÍODO LEGISLATIVO',
            'ORDINÁRIA ITINERANTE',
            'ADMINISTRATIVA',
            'ESPECIAL',
        ];
        $this->storeTypes($session->id, $sessoes);

        OmbudsmanPage::create(['route' => 'ouvidoria.show']);

        $partyAffiliations = [
            [
                "name" => "Partido dos Trabalhadores",
                "acronym" => "PT",
            ],
            [
                "name" => "Partido da Social Democracia Brasileira",
                "acronym" => "PSDB",
            ],
            [
                "name" => "Movimento Democrático Brasileiro",
                "acronym" => "MDB",
            ],
            [
                "name" => "Partido Socialista Brasileiro",
                "acronym" => "PSB",
            ],
            [
                "name" => "Partido Democrático Trabalhista",
                "acronym" => "PDT",
            ],
            [
                "name" => "Partido da República",
                "acronym" => "PR",
            ],
            [
                "name" => "Partido Progressista",
                "acronym" => "PP",
            ],
            [
                "name" => "Partido Social Cristão",
                "acronym" => "PSC",
            ],
            [
                "name" => "Partido Verde",
                "acronym" => "PV",
            ],
            [
                "name" => "Partido Comunista do Brasil",
                "acronym" => "PCdoB",
            ],
            [
                "name" => "Partido Social Liberal",
                "acronym" => "PSL",
            ],
            [
                "name" => "Partido Trabalhista Brasileiro",
                "acronym" => "PTB",
            ],
            [
                "name" => "Partido Popular Socialista",
                "acronym" => "PPS",
            ],
            [
                "name" => "Partido Democrático Brasileiro",
                "acronym" => "PDB",
            ],
            [
                "name" => "Rede Sustentabilidade",
                "acronym" => "REDE",
            ],
            [
                "name" => "Partido Republicano da Ordem Social",
                "acronym" => "PROS",
            ],
            [
                "name" => "Partido Socialismo e Liberdade",
                "acronym" => "PSOL",
            ],
            [
                "name" => "Partido Humanista da Solidariedade",
                "acronym" => "PHS",
            ],
            [
                "name" => "Partido da Mobilização Nacional",
                "acronym" => "PMN",
            ],
            [
                "name" => "Partido Socialista dos Trabalhadores Unificado",
                "acronym" => "PSTU",
            ]
        ];
    
        foreach($partyAffiliations as $party){
            PartyAffiliation::create([
                'name' => $party['name'],
                'acronym' => $party['acronym'],
                'slug' => Str::slug($party['name']),
            ]);
        }
    }
    

    private function storeCategories($parent_id, $array){
        foreach ($array as $item) {
            Category::create([
                'name' => $item,
                'parent_id' => $parent_id,
                'slug' => Str::slug($item)
            ]);
        }
        return true;
    }

    private function storeTypes($parent_id, $array){
        foreach ($array as $item) {
            Type::create([
                'name' => $item,
                'parent_id' => $parent_id,
                'slug' => Str::slug($item)
            ]);
        }

        return true;
    }
}
