#  API de Simulação de Empréstimos

API REST desenvolvida em Laravel para simulação de crédito. 

---

## Estrutura de Dados

Os dados são lidos de arquivos `.json` localizados em:  
`storage/app/data/`

### Arquivos esperados:

- `instituicoes.json`
    #### Exemplo:
    ```json
    {
        "1": "Banco Tal",
        "2": "Outro Banco"
    }
    ```
- `convenios.json`
    #### Exemplo:
    ```json
    {
      "1": "Convenio X",
      "2": "Convenio Y"
    }
    ```
- `taxas.json`
    #### Exemplo:
    ```json
    [
      {
        "instituicao_id": "1",
        "convenio_id": "1",
        "parcelas": 6,
        "coeficiente": 0.1862
      },
      {
        "instituicao_id": "2",
        "convenio_id": "2",
        "parcelas": 15,
        "coeficiente": 0.0826
      }
    ]
    
    ```

### Endpoints da API

`GET /api/instituicoes`

Retorna a lista de instituições no formato chave e valor.
#### Exemplo de retorno:
```json
[
  {
    "chave": "1",
    "valor": "Banco Tal"
  },
  {
    "chave": "2",
    "valor": "Outro Banco"
  }
]
```


`GET /api/convenios`

Retorna os convênios disponíveis no formato chave e valor.

#### Exemplo de retorno:
```json
[
  {
    "chave": "1",
    "valor": "Convenio X"
  },
  {
    "chave": "2",
    "valor": "Convenio Y"
  }
]
```

`GET /api/convenios`

Retorna os convênios disponíveis baseado em filtros.

#### Exemplo de payload:
```json
{
    "valor_emprestimo": 5000.00,
    "instituicoes": ["2"],
    "convenios": ["2"],
    "parcela": 15
}
```
Os atributos `instituicoes`, `convenios` e `parcela` são opcionais.

#### Exemplo de retorno:
```json
[
    {
        "instituicao": "Outro Banco",
        "opcoes": [
            {
                "taxa": 8.26,
                "parcelas": 15,
                "valor_parcela": 413,
                "convenio": "Convenio Y"
            }
        ]
    }
]
```

---

## Postman Collection:

O arquivo `Simulação de Empréstimo API.postman_collection.json` foi adicionado à raiz do projeto.

As chamadas de API desta collection estão configuradas para a porta 8080. Ao rodar o projeto, lembre-se de rodar o projeto na porta 8080 ou edite a chamada da API no postman para refletir a porta usada ao rodar o projeto.

```bash
php artisan serve --port=8080
```

