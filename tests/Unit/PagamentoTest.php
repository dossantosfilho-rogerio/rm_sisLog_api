<?php

namespace Tests\Unit;

use App\Models\Pagamento;
use PHPUnit\Framework\TestCase;

class PagamentoTest extends TestCase
{
        /** @test */
        public function it_returns_all_tipos()
        {
            // Chama o método da classe Pagamento
            $tipos = Pagamento::getAllTipos();
    
            // Verifica se a quantidade dos tipos retornados é a esperada
            $this->assertCount(3, $tipos);
    
            // Verifica se os valores das constantes estão corretos
            $this->assertContains('cartão', $tipos);
            $this->assertContains('dinheiro', $tipos);
            $this->assertContains('transferência', $tipos);
        }
    
}
