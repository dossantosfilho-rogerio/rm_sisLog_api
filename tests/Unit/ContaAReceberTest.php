<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\ContaAReceber;

class ContaAReceberTest extends TestCase
{
    /** @test */
    public function it_returns_all_status()
    {
        // Chama o método da classe ContaAReceber
        $status = ContaAReceber::getAllStatus();

        // Verifica se a quantidade dos status retornados é a esperada
        $this->assertCount(3, $status);

        // Verifica se os valores das constantes estão corretos
        $this->assertContains('vencido', $status);
        $this->assertContains('pago', $status);
        $this->assertContains('pendente', $status);
    }
}
