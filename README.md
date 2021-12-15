# Загрузка фикстур

    bin/console doctrine:fixtures:load

# Создание автора

    POST http://127.0.0.1/author/create
    Accept: application/json
    Content-Type: application/json
    Cache-Control: no-cache
    
    {
      "name": "test"
    }

# Поиск книги

    POST http://127.0.0.1/book/search
    Accept: application/json
    Content-Type: application/json
    Cache-Control: no-cache
    
    {
       "title": "test"
    }

# Создание книги

    POST http://127.0.0.1/book/create
    Accept: application/json
    Content-Type: application/json
    Cache-Control: no-cache
    {
       "title": "test",
       "author": [ 
           "test1", "test2", 
       ] 
    }
