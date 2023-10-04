<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Office;
use App\Models\OmbudsmanPage;
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

        $status = Category::create([
            'name' => 'Status',
            'slug' => Str::slug('Status')
        ]);
        Category::create([
            'name' => 'Aberta',
            'parent_id' => $status->id,
            'slug' => Str::slug('Aberta')
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

        $situacao = Category::create([
            'name' => 'Situação',
            'slug' => Str::slug('Situação')
        ]);
        $situacoes = [
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
        foreach ($situacoes as $item) {
            Category::create([
                'name' => $item,
                'parent_id' => $situacao->id,
                'slug' => Str::slug($item)
            ]);
        }

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

        foreach ($materiais as $item) {
            Type::create([
                'name' => $item,
                'parent_id' => $material->id,
                'slug' => Str::slug($item)
            ]);
        }

        OmbudsmanPage::create(['route' => 'ouvidoria.show']);
    }
}
