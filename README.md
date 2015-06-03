# Tabela
Classe para gerenciamento de tabela em PHP

## Modo de usar
```
<?php 

  $usuarios = [
    ['codigo' => 1, 'nome' => 'Diego'],
    ['codigo' => 2, 'nome' => 'Cleiton'],
    ['codigo' => 3, 'nome' => 'Gabriel'],
    ['codigo' => 4, 'nome' => 'Marcos']
  ];
  
  $tabela = new Tabela();
  
  $tabela->addColuna('Código', ['width' => '10%']);
  $tabela->addColuna('Nome');
  
  foreach ($usuarios as $usuario) {
    $usuarioLinha = $tabela->addLinha();
    
    $usuarioLinha->addColuna($usuario['codigo']);
    $usuarioLinha->addColuna($usuario['nome']);
  }
  
  $tabela->toHtml();
  
?>
```
