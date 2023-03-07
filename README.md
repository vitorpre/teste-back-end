# Projeto: teste-back-end

Projeto teste utilizando PHP e Laravel para criar uma API crud de tarefas com autenticação JWT. 

<br />

### Instalação

O projeto pode ser instalado utilizando Docker, para isso é necessário a intalação do Docker e Docker-compose 

> Docker https://www.docker.com/products/docker-desktop/

> Docker-compose https://docs.docker.com/compose/

<br />

Renomeie o arquivo .env.example para .env na pasta raiz do projeto

<br />

Executar os seguintes comandos dentro da pasta do projeto:

```
docker-compose build
docker-compose up
```

Após a execução, o servidor nginx estará rodando na porta 80 e o banco de dados mysql na porta 3306

 ### API Endpoints
 
 Para utilizar a api é necessário gerar uma token JWT através da rota `/api/auth/login` . Além dela, há também outras rotas úteis referentes a autenticação:
 
 #### Autenticação
 
 | Endpoint | Método | Parâmetros | Autenticação? | Resposta | 
 | --- | --- | --- | --- | --- |
 | `/api/auth/login` | POST | email, password | Não | Token de acesso |
 | `/api/auth/logout` | POST | N/A | Sim |  Desativa o token| 
 | `/api/auth/refresh` | POST | N/A | Sim |  Atualiza  a expiração do token |
 | `/api/auth/me` | POST | N/A | Sim |  Usuário do token |
 
 Está configurado o seguinte usuário para a execução dos testes do projeto:
 
 ```
 Email: test@example.com
 Senha: password
 ```
  
 <br />
 
 ##### Exemplo de solicitação
 
  `POST /api/auth/login`
  
  ```
  {
    "email": "test@example.com",
    "password": "password"
  }
  ```
  
  Retorno:
  
  ```
  {
      "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJo...",
      "token_type": "bearer",
      "expires_in": 3600
  }
  ```
  
  `POST /api/auth/logout`
  
  *Necessário envio da token no header*
    
  ```
    {
    }
  ```
    
    
  Retorno:
    
  ```
    {
        "message": "Successfully logged out"
    }
  ```
  
  `POST /api/auth/refresh`
  
  *Necessário envio da token no header*
    
  ```
    {
    }
  ```
    
    
  Retorno:
    
  ```
    {
        "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3...",
        "token_type": "bearer",
        "expires_in": 3600
    }
  ```
  
  `POST /api/auth/me`
    
  *Necessário envio da token no header*
      
  ```
      {
      }
  ```
      
      
  Retorno:
      
  ```
      {
          "id": 2,
          "name": "Test User",
          "email": "test@example.com",
          "email_verified_at": "2023-03-06T21:47:49.000000Z",
          "created_at": "2023-03-06T21:47:49.000000Z",
          "updated_at": "2023-03-06T21:47:49.000000Z"
      }
  ```

  #### API Tarefas
  
  Todos os endpoints necessitam que o token de validação seja enviado.
  
  | Endpoint | Método | Parâmetros | Resposta | 
   | --- | --- | --- | --- |
   | `/api/tasks` | GET | N/A | Todas as tarefas paginadas |
   | `/api/tasks/[id]` | GET | id | Tarefa especifica | 
   | `/api/tasks` | POST | Título, descrição, data inicial, data de conclusão | Tarefa inserida |
   | `/api/tasks/[id]` | PUT | id | Tarefa atualizada |
   | `/api/tasks/[id]` | DELETE | id | Confirmação de exclusão |
 
 
 <br />
 
 ##### Exemplo de solicitação
 
  `GET /api/tasks`
  
  ```
  {
  }
  ```
  
  Retorno:
  
  ```
  {
      "current_page": 1,
      "data": [
          {
              "id": 1,
              "title": "Teste",
              "description": "descrição de tarefa",
              "start_date": "2025-01-01",
              "conclusion_date": "2025-01-03",
              "created_at": "2023-03-06 17:48:03",
              "updated_at": "2023-03-06 18:19:14"
          },
          {
              "id": 2,
              "title": "Teste",
              "description": "descrição de tarefa",
              "start_date": "2025-01-01",
              "conclusion_date": "2025-01-01",
              "created_at": "2023-03-06 18:22:55",
              "updated_at": "2023-03-06 18:22:55"
          },
          {
              "id": 4,
              "title": "Teste",
              "description": "descrição de tarefa",
              "start_date": "2025-01-02",
              "conclusion_date": "2025-01-05",
              "created_at": "2023-03-06 18:23:53",
              "updated_at": "2023-03-06 18:23:53"
          }
      ],
      "first_page_url": "http://.../api/tasks?page=1",
      "from": 1,
      "last_page": 1,
      "last_page_url": "http://.../api/tasks?page=1",
      "links": [
          {
              "url": null,
              "label": "&laquo; Previous",
              "active": false
          },
          {
              "url": "http://.../api/tasks?page=1",
              "label": "1",
              "active": true
          },
          {
              "url": null,
              "label": "Next &raquo;",
              "active": false
          }
      ],
      "next_page_url": null,
      "path": "http://.../api/tasks",
      "per_page": 100,
      "prev_page_url": null,
      "to": 3,
      "total": 3
  }
  ```
  
  `GET /api/tasks/[id]`
    
   ```
    {
    }
  ```
    
  Retorno:
    
  ```
    {
        "id": 1,
        "title": "Teste 1",
        "description": "descrição da tarefa",
        "start_date": "2025-01-01",
        "conclusion_date": "2025-01-05",
        "created_at": "2023-03-06 17:48:03",
        "updated_at": "2023-03-06 18:19:14"
    }
  ```
  
  `POST /api/tasks/`
    
   ```
    {
        "title": "Teste de tarefa",
        "description": "descrição da tarefa",
        "start_date": "2025-01-01",
        "conclusion_date": "2025-01-05",
    }
  ```
    
  Retorno:
    
  ```
    {
        "id": 1,
        "title": "Teste de tarefa",
        "description": "descrição da tarefa",
        "start_date": "2025-01-01",
        "conclusion_date": "2025-01-05",
        "created_at": "2023-03-06 17:48:03",
        "updated_at": "2023-03-06 17:48:03"
    }
  ```
  
  `PUT /api/tasks/[id]`
      
   ```
      {
          "title": "Teste de alteração",
          "description": "descrição da tarefa",
          "start_date": "2025-01-01",
          "conclusion_date": "2025-01-08",
      }
   ```
      
   Retorno:
      
   ```
      {
          "id": 1,
          "title": "Teste de alteração",
          "description": "descrição da tarefa",
          "start_date": "2025-01-01",
          "conclusion_date": "2025-01-08",
          "created_at": "2023-03-06 17:48:03",
          "updated_at": "2023-03-06 17:55:00"
      }
   ```
   
   `DELETE /api/tasks/[id]`
         
   ```
     {
     }
   ```
         
   Retorno:
         
   ```
     {
     }
   ```
