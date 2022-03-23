<?php

declare(strict_types=1);

namespace App\Model;

use App\Exception\NotFoundException;
use App\Exception\StorageException;
use PDO;
use Throwable;

class NoteModel extends AbstractModel implements ModelInterface
{

    public function list(int $pageNumber, int $pageSize,string $sortBy,string $orderBy): array{
        return $this->findBy(
            null,
            $pageNumber,
            $pageSize,
            $sortBy,
            $orderBy
        );
    }

    public function search(
        string $phrase,
        int $pageNumber,
        int $pageSize,
        string $sortBy,
        string $orderBy
    ): array{
        return $this->findBy(
            $phrase,
            $pageNumber,
            $pageSize,
            $sortBy,
            $orderBy
        );
    }

    public function searchCount(string $phrase): int{
        try{
            $phrase = $this->conn->quote('%'.$phrase.'%', PDO::PARAM_STR);

            $query = "
            SELECT count(*) AS cn
            FROM notes
            WHERE title LIKE ($phrase)
            ";
            $result = $this->conn->query($query);
            $result = $result->fetch(PDO::FETCH_ASSOC);

            if($result === false){
                throw new StorageException("Nie udało się pobrać danych o liczbie notatek", 400);
            }
            return (int) $result['cn'];
        }catch(Throwable $e){
            throw new StorageException("Nie udało się pobrać danych o liczbie notatek", 400, $e);
        }
    }

    public function count(): int{
        try{

            $query = "
            SELECT count(*) AS cn
            FROM notes
            ";
            $result = $this->conn->query($query);
            $result = $result->fetch(PDO::FETCH_ASSOC);

            if($result === false){
                throw new StorageException("Nie udało się pobrać danych o liczbie notatek", 400);
            }
            return (int) $result['cn'];
        }catch(Throwable $e){
            throw new StorageException("Nie udało się pobrać danych o liczbie notatek", 400, $e);
        }
    }

    public function get(int $id): array{
        try{
            $query = "SELECT * FROM notes 
                      WHERE id = $id";
            $result = $this->conn->query($query);
            $note = $result->fetch(PDO::FETCH_ASSOC);
        }catch(Throwable $e){
            throw new StorageException("Nie udało się pobrać notatki", 400, $e);
        }

        if (!$note){
            throw new NotFoundException("Notatka o id: $id - nie isnieje.");
            exit("Nie ma takiej notatki");
        }
        return $note;
    }

    public function create($data): void{
        try{

            $title = $this->conn->quote($data['title']);
            $description = $this->conn->quote($data['description']);
            $created = $this->conn->quote(date("Y-m-d H:i:s"));

            $query = "INSERT INTO notes(title, description, created)
                      VALUES($title, $description, $created)";

            $this->conn->exec($query);
        }catch(Throwable $e){
            throw new StorageException("Wystąpił błąd aplikacji, nie udało się utworzyć nowej notatki");
            exit;
        }
    }

    public function edit($id, $data): void{
        try{

            $title = $this->conn->quote($data['title']);
            $description = $this->conn->quote($data['description']);

            $query = "
            UPDATE notes SET
                title = $title,
                description = $description
            WHERE id = $id
            ";

            $this->conn->exec($query);
        }catch(Throwable $e){
            throw new StorageException("Wystąpił błąd aplikacji, nie udało się zaktualizować notatki");
            exit;
        }
    }

    public function delete($id): void{
        try{

            $query = "
            DELETE FROM notes
            WHERE id = $id
            LIMIT 1
            ";

            $this->conn->exec($query);
        }catch(Throwable $e){
            throw new StorageException("Wystąpił błąd aplikacji, nie udało się zaktualizować notatki");
            exit;
        }
    }

    private function findBy(
        ?string $phrase,
        int $pageNumber,
        int $pageSize,
        string $sortBy,
        string $orderBy
    ): array{
        try{

            $limit = $pageSize;
            $offset = ($pageNumber - 1) * $pageSize;

            if(!in_array($sortBy, ['created', 'title'])){
                $sortBy = 'title';
            }

            if(!in_array($orderBy, ['asc', 'desc'])){
                $sortBy = 'asc';
            }

            $wherePart = '';
            if($phrase){
                $phrase = $this->conn->quote('%'.$phrase.'%', PDO::PARAM_STR);
                $wherePart = "WHERE title LIKE ($phrase)";
            }
            
            $query = "
            SELECT id, title, created 
            FROM notes
            $wherePart
            ORDER BY $sortBy $orderBy
            LIMIT $offset, $limit
            ";
            $result = $this->conn->query($query);
            return $result->fetchAll(PDO::FETCH_ASSOC);
        }catch(Throwable $e){
            throw new StorageException("Nie udało się pobrać notatek", 400, $e);
        }
    }
}